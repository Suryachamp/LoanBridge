@extends('layouts.app')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-12">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="text-white mb-1">Administrative Terminal</h2>
                <p class="text-muted mb-0">Overview of engine metrics, score statistics, and application statuses</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/admin/leads" class="btn btn-outline-light border border-white border-opacity-10 py-2.5 px-4 d-inline-flex align-items-center gap-2" style="background: rgba(255,255,255,0.02);">
                    <i class="bi bi-people"></i> Manage Leads
                </a>
                <a href="/admin/rules" class="btn btn-primary py-2.5 px-4 d-inline-flex align-items-center gap-2">
                    <i class="bi bi-gear-fill"></i> Configure Rules
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
        <div class="glass-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <span class="text-muted d-block mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Applications</span>
                    <h2 class="text-white mb-0 fw-bold">{{ $totalLeads }}</h2>
                </div>
                <div class="p-3 rounded-3 bg-indigo-500 bg-opacity-20 text-indigo-300 d-inline-flex">
                    <i class="bi bi-folder-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="glass-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <span class="text-muted d-block mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Eligible Decisions</span>
                    <h2 class="text-white mb-0 fw-bold" style="color: #10b981 !important;">{{ $eligibleLeads }}</h2>
                </div>
                <div class="p-3 rounded-3 bg-emerald-500 bg-opacity-20 text-emerald-300 d-inline-flex">
                    <i class="bi bi-shield-check fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="glass-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <span class="text-muted d-block mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Rejected Decisions</span>
                    <h2 class="text-white mb-0 fw-bold" style="color: #ef4444 !important;">{{ $rejectedLeads }}</h2>
                </div>
                <div class="p-3 rounded-3 bg-rose-500 bg-opacity-20 text-rose-300 d-inline-flex">
                    <i class="bi bi-shield-x fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="glass-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <span class="text-muted d-block mb-1 fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Average Bureau Score</span>
                    <h2 class="text-white mb-0 fw-bold">{{ number_format($avgCreditScore, 0) }}</h2>
                </div>
                <div class="p-3 rounded-3 bg-cyan-500 bg-opacity-20 text-cyan-300 d-inline-flex">
                    <i class="bi bi-speedometer2 fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shortcuts Section -->
<div class="row">
    <div class="col-md-12">
        <div class="glass-card p-4">
            <h5 class="text-white mb-4"><i class="bi bi-shield-shaded me-2 text-indigo-400"></i>Engine Overview</h5>
            <p class="text-muted">The LoanBridge Credit Assessment system executes incoming borrower requests through a deterministic Credit bureau check, caching the scores, and running them through seed-level rule validations. Configure these business rules dynamically to adjust eligibility thresholds instantly without codebase deployment.</p>
        </div>
    </div>
</div>
@endsection
