@extends('layouts.app')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-white mb-1">Borrower Lead Management</h2>
                <p class="text-muted mb-0">Track application metrics, decision logs, and demographic data</p>
            </div>
            <a href="/admin" class="btn btn-outline-light border border-white border-opacity-10 py-2.5 px-4 d-inline-flex align-items-center gap-2" style="background: rgba(255,255,255,0.02);">
                <i class="bi bi-arrow-left-short fs-5"></i> Back to Terminal
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter Form -->
<div class="glass-card mb-4">
    <div class="card-body p-4">
        <form action="/admin/leads" method="GET" class="row g-3">
            <div class="col-md-5">
                <label class="form-label d-flex align-items-center gap-1"><i class="bi bi-search"></i> Search Query</label>
                <input type="text" name="search" class="form-control" placeholder="Search by ID, Name or Mobile" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label d-flex align-items-center gap-1"><i class="bi bi-filter"></i> BRE Eligibility</label>
                <select name="status" class="form-select">
                    <option value="">All Decisions</option>
                    <option value="Eligible" {{ request('status') == 'Eligible' ? 'selected' : '' }}>Eligible</option>
                    <option value="Not Eligible" {{ request('status') == 'Not Eligible' ? 'selected' : '' }}>Not Eligible</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 py-2.5 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-funnel-fill"></i> <span>Filter Records</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="glass-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Lead ID</th>
                        <th>Customer Name</th>
                        <th>Mobile</th>
                        <th>Loan Type</th>
                        <th>Credit Score</th>
                        <th>BRE Status</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr class="align-middle">
                        <td>
                            <code class="text-indigo-200 fw-bold">#{{ $lead->id }}</code>
                        </td>
                        <td>
                            <span class="text-white fw-semibold">{{ $lead->full_name }}</span>
                        </td>
                        <td>
                            <span class="text-muted">{{ $lead->mobile }}</span>
                        </td>
                        <td>
                            <span class="badge bg-white bg-opacity-5 border border-white border-opacity-10 text-light px-2.5 py-1">
                                {{ $lead->loan_type }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-indigo-500 bg-opacity-25 text-indigo-100 px-2 py-1">
                                {{ $lead->credit_score }}
                            </span>
                        </td>
                        <td>
                            @if($lead->bre_status == 'Eligible')
                                <span class="badge bg-emerald-500 bg-opacity-20 text-emerald-300 border border-emerald-500 border-opacity-20 px-3 py-1.5 rounded-3 d-inline-flex align-items-center gap-1.5">
                                    <span class="rounded-circle bg-emerald-400" style="width: 6px; height: 6px;"></span> Eligible
                                </span>
                            @else
                                <span class="badge bg-rose-500 bg-opacity-20 text-rose-300 border border-rose-500 border-opacity-20 px-3 py-1.5 rounded-3 d-inline-flex align-items-center gap-1.5 mb-1">
                                    <span class="rounded-circle bg-rose-400" style="width: 6px; height: 6px;"></span> Not Eligible
                                </span>
                                @if(is_array($lead->bre_reasons) && count($lead->bre_reasons) > 0)
                                    <div class="text-muted mt-1 ps-2 border-left border-secondary" style="font-size: 0.75rem; border-left: 2px solid rgba(255,255,255,0.1);">
                                        {{ implode(', ', $lead->bre_reasons) }}
                                    </div>
                                @endif
                            @endif
                        </td>
                        <td>
                            <span class="text-muted" style="font-size: 0.85rem;">{{ $lead->created_at->format('d M Y') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i> No records found matching conditions.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($leads->hasPages())
    <div class="card-footer d-flex justify-content-center border-top border-white border-opacity-10 py-3 bg-transparent">
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
