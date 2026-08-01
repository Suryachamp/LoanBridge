<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Mock Credit Score API Controller
 * 
 * This simulates a third-party Credit Bureau API (like CIBIL/Experian).
 * In production, this would be replaced by an actual external API endpoint.
 * 
 * The score is generated deterministically based on the mobile number
 * so the same mobile always returns the same score (consistent behavior).
 */
class CreditScoreController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
        ]);

        $mobile = $request->mobile;

        // Generate a deterministic score based on mobile number
        // This ensures the same mobile always gets the same credit score
        // (simulating a real credit bureau lookup)
        $hash = crc32($mobile);
        $score = 300 + abs($hash % 601); // Score range: 300 to 900

        return response()->json([
            'status' => 'success',
            'data' => [
                'mobile' => $mobile,
                'credit_score' => $score,
                'bureau' => 'MockCIBIL',
                'report_date' => now()->toDateString(),
            ]
        ]);
    }
}
