<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\BusinessRule;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mock login - in a real app, use Laravel Auth
    // We'll skip auth middleware here to focus on the core modules,
    // but the routes can be protected easily.

    public function index()
    {
        $totalLeads = Lead::count();
        $eligibleLeads = Lead::where('bre_status', 'Eligible')->count();
        $rejectedLeads = Lead::where('bre_status', 'Not Eligible')->count();
        $avgCreditScore = Lead::avg('credit_score');

        return view('admin.dashboard', compact(
            'totalLeads', 'eligibleLeads', 'rejectedLeads', 'avgCreditScore'
        ));
    }

    public function leads(Request $request)
    {
        $query = Lead::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('id', $search);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('bre_status', $request->status);
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.leads', compact('leads'));
    }

    public function rules()
    {
        $rules = BusinessRule::all();
        return view('admin.rules', compact('rules'));
    }

    public function storeRule(Request $request)
    {
        $request->validate([
            'rule_field' => 'required|string',
            'operator' => 'required|string',
            'value' => 'required|string'
        ]);

        BusinessRule::create($request->all());

        return redirect('/admin/rules')->with('success', 'Rule added successfully');
    }

    public function updateRule(Request $request, $id)
    {
        $request->validate([
            'rule_field' => 'required|string',
            'operator' => 'required|string',
            'value' => 'required|string'
        ]);

        $rule = BusinessRule::findOrFail($id);
        $rule->update($request->all());

        return redirect('/admin/rules')->with('success', 'Rule updated successfully');
    }

    public function deleteRule($id)
    {
        $rule = BusinessRule::findOrFail($id);
        $rule->delete();

        return redirect('/admin/rules')->with('success', 'Rule deleted successfully');
    }
}
