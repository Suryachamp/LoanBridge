@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>BRE Management</h2>
            <a href="/admin" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Existing Rules
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Rule Field</th>
                            <th>Operator</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rules as $rule)
                        <tr>
                            <td>{{ $rule->rule_field }}</td>
                            <td>{{ $rule->operator }}</td>
                            <td>{{ $rule->value }}</td>
                            <td>
                                <!-- Simple delete form -->
                                <form action="/admin/rules/{{ $rule->id }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Add New Rule
            </div>
            <div class="card-body">
                <form action="/admin/rules" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Rule Field</label>
                        <input type="text" name="rule_field" class="form-control" required placeholder="e.g. Age, Monthly Income, Credit Score, Loan Amount">
                        <small class="text-muted">Type any field name you want to create a rule for</small>
                    </div>
                    <div class="mb-3">
                        <label>Operator</label>
                        <select name="operator" class="form-select" required>
                            <option value=">=">>= (Greater than or equal)</option>
                            <option value="<="><= (Less than or equal)</option>
                            <option value=">">> (Greater than)</option>
                            <option value="<">< (Less than)</option>
                            <option value="=">= (Equal)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Value</label>
                        <input type="text" name="value" class="form-control" required placeholder="e.g. 21, 30000, 80% Property Value">
                        <small class="text-muted">For Loan Amount against Property Value use format "80% Property Value"</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Rule</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
