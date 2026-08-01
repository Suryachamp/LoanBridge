@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Admin Dashboard</h2>
            <div>
                <a href="/admin/leads" class="btn btn-outline-primary">Manage Leads</a>
                <a href="/admin/rules" class="btn btn-outline-secondary">Manage Rules</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card bg-primary text-white text-center p-3 mb-3">
            <h3>{{ $totalLeads }}</h3>
            <p class="mb-0">Total Leads</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white text-center p-3 mb-3">
            <h3>{{ $eligibleLeads }}</h3>
            <p class="mb-0">Eligible Leads</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white text-center p-3 mb-3">
            <h3>{{ $rejectedLeads }}</h3>
            <p class="mb-0">Rejected Leads</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white text-center p-3 mb-3">
            <h3>{{ number_format($avgCreditScore, 0) }}</h3>
            <p class="mb-0">Avg Credit Score</p>
        </div>
    </div>
</div>
@endsection
