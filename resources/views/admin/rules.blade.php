@extends('layouts.app')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-white mb-1">Business Rule Engine Configurator</h2>
                <p class="text-muted mb-0">Modify, append, and prune parameters executed against borrower profiles</p>
            </div>
            <a href="/admin" class="btn btn-outline-light border border-white border-opacity-10 py-2.5 px-4 d-inline-flex align-items-center gap-2" style="background: rgba(255,255,255,0.02);">
                <i class="bi bi-arrow-left-short fs-5"></i> Back to Terminal
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-success mb-4 p-4">
    <div class="d-flex align-items-center gap-3">
        <div class="p-2 rounded-circle bg-success bg-opacity-20 d-flex text-success">
            <i class="bi bi-check-circle-fill fs-4"></i>
        </div>
        <div>
            <h5 class="alert-heading text-white fw-bold mb-1">Engine Synchronized</h5>
            <span class="text-light">{{ session('success') }}</span>
        </div>
    </div>
</div>
@endif

<div class="row g-4">
    <!-- Existing Rules Section -->
    <div class="col-lg-8">
        <div class="glass-card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-list-task text-primary-light"></i>
                <h5 class="mb-0 text-white">Active Evaluation Rules</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Rule Field</th>
                                <th>Operator</th>
                                <th>Boundary Value</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rules as $rule)
                            <tr class="align-middle">
                                <td>
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-sliders text-indigo-400 text-opacity-70"></i>
                                        <strong>{{ $rule->rule_field }}</strong>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-opacity-25 bg-info text-info border border-info border-opacity-20 px-2.5 py-1">
                                        {{ $rule->operator }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-white fw-semibold">{{ $rule->value }}</span>
                                </td>
                                <td class="text-end">
                                    <form action="/admin/rules/{{ $rule->id }}" method="POST" class="d-inline" onsubmit="return confirm('Pruning this rule will instantly change eligibility flow. Proceed?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-danger border-opacity-20 py-1.5 px-3 rounded-3 d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-trash3-fill" style="font-size: 0.8rem;"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Rule Form -->
    <div class="col-lg-4">
        <div class="glass-card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill text-primary-light"></i>
                <h5 class="mb-0 text-white">Append Rule</h5>
            </div>
            <div class="card-body">
                <form action="/admin/rules" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label d-flex align-items-center gap-1">
                            <i class="bi bi-tag"></i> Rule Field
                        </label>
                        <input type="text" name="rule_field" class="form-control" required placeholder="e.g. Age, Monthly Income, Credit Score">
                        <small class="text-muted d-block mt-2">Use existing form variables (e.g. Age, Monthly Income, Credit Score, Loan Amount, Property Value, Pincode)</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label d-flex align-items-center gap-1">
                            <i class="bi bi-code"></i> Operator
                        </label>
                        <select name="operator" class="form-select" required>
                            <option value=">=">>= (Greater than or equal)</option>
                            <option value="<="><= (Less than or equal)</option>
                            <option value=">">> (Greater than)</option>
                            <option value="<">< (Less than)</option>
                            <option value="=">= (Equal)</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label d-flex align-items-center gap-1">
                            <i class="bi bi-graph-up-arrow"></i> Boundary Value
                        </label>
                        <input type="text" name="value" class="form-control" required placeholder="e.g. 21, 30000, 80% Property Value">
                        <small class="text-muted d-block mt-2">For Loan Amount relative limit, use: <code>80% Property Value</code></small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-2.5 mt-2 d-flex align-items-center justify-content-center gap-2">
                        <span>Deploy Rule</span> <i class="bi bi-send-fill fs-6"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
