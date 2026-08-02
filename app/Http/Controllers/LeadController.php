<?php

namespace App\Http\Controllers;

use App\Models\BusinessRule;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $rules = BusinessRule::all();
        return view('apply', compact('rules'));
    }
}
