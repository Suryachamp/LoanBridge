<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\BusinessRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LeadApiController extends Controller
{
    public function store(Request $request)
    {
        if (Lead::where('mobile', $request->mobile)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lead already exists'
            ], 400);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'email' => 'required|email|max:255',
            'dob' => 'required|date',
            'city' => 'required|string|max:255',
            'pincode' => 'required|digits:6',
            'loan_type' => 'required|string',
            'employment_type' => 'required|string',
            'monthly_income' => 'required|numeric|min:0',
            'loan_amount' => 'required|numeric|min:0',
            'property_value' => 'required|numeric|min:0',
            'consent' => 'required|boolean',
        ]);

        // Credit Score Integration API Call
        $creditScore = $this->fetchCreditScore($validated['mobile']);

        // Business Rule Engine Validation
        $breResult = $this->evaluateBRE($validated, $creditScore);

        $lead = Lead::create(array_merge($validated, [
            'credit_score' => $creditScore,
            'bre_status' => $breResult['status'],
            'bre_reasons' => $breResult['reasons']
        ]));

        return response()->json([
            'status' => 'success',
            'lead_id' => $lead->id,
            'credit_score' => $lead->credit_score,
            'bre_status' => $lead->bre_status,
            'reasons' => $breResult['reasons']
        ]);
    }

    private function fetchCreditScore($mobile)
    {
        try {
            // Internal call to our Mock Credit Bureau API 
            // Note: 'php artisan serve' is single-threaded. Making an HTTP request to itself causes a 10-second deadlock.
            // For local testing, we bypass the network layer. In production, we use Http::post().
            if (app()->environment('local')) {
                $controller = new \App\Http\Controllers\Api\CreditScoreController();
                $req = \Illuminate\Http\Request::create('/api/credit-score/check', 'POST', ['mobile' => $mobile]);
                $res = $controller->check($req);
                return $res->getData(true)['data']['credit_score'] ?? null;
            }

            $response = Http::timeout(10)->post(
                url('/api/credit-score/check'),
                ['mobile' => $mobile]
            );

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['credit_score'] ?? null;
            }

            Log::warning('Credit Score API returned non-success status', [
                'mobile' => $mobile,
                'status' => $response->status(),
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Credit Score API failed: ' . $e->getMessage());
            return null;
        }
    }

    private function evaluateBRE($data, $creditScore)
    {
        $rules = BusinessRule::all();
        $reasons = [];

        $customerAge = Carbon::parse($data['dob'])->age;

        foreach ($rules as $rule) {
            $field = $rule->rule_field;
            $operator = $rule->operator;
            $ruleValue = $rule->value;
            $customerValue = null;

            // Dynamic field mapping — maps admin rule fields to actual customer data
            $fieldMap = [
                'Age'             => $customerAge,
                'Monthly Income'  => $data['monthly_income'] ?? null,
                'Credit Score'    => $creditScore,
                'Loan Amount'     => $data['loan_amount'] ?? null,
                'Property Value'  => $data['property_value'] ?? null,
                'Pincode'         => $data['pincode'] ?? null,
            ];

            $customerValue = $fieldMap[$field] ?? null;

            if ($field === 'Loan Amount' && stripos($ruleValue, '% Property Value') !== false) {
                $percentage = (float) str_ireplace('% Property Value', '', $ruleValue);
                $ruleValue = ($percentage / 100) * $data['property_value'];
            }

            if ($customerValue !== null && !$this->evaluateCondition($customerValue, $operator, $ruleValue)) {
                $reasons[] = "{$field} requirement not met. (Criteria: {$field} {$operator} {$rule->value})";
            }
        }

        if (count($reasons) > 0) {
            return ['status' => 'Not Eligible', 'reasons' => $reasons];
        }

        return ['status' => 'Eligible', 'reasons' => []];
    }

    private function evaluateCondition($left, $operator, $right)
    {
        $left = (float) $left;
        $right = (float) $right;

        switch ($operator) {
            case '>': return $left > $right;
            case '>=': return $left >= $right;
            case '<': return $left < $right;
            case '<=': return $left <= $right;
            case '==': 
            case '=': return $left == $right;
            case '!=': return $left != $right;
            default: return true;
        }
    }
}
