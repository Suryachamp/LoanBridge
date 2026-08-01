@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Lead Management</h2>
            <a href="/admin" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="/admin/leads" method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search by ID, Name or Mobile" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="Eligible" {{ request('status') == 'Eligible' ? 'selected' : '' }}>Eligible</option>
                    <option value="Not Eligible" {{ request('status') == 'Not Eligible' ? 'selected' : '' }}>Not Eligible</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Lead ID</th>
                    <th>Customer Name</th>
                    <th>Mobile</th>
                    <th>Loan Type</th>
                    <th>Credit Score</th>
                    <th>BRE Status</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                <tr>
                    <td>{{ $lead->id }}</td>
                    <td>{{ $lead->full_name }}</td>
                    <td>{{ $lead->mobile }}</td>
                    <td>{{ $lead->loan_type }}</td>
                    <td>{{ $lead->credit_score }}</td>
                    <td>
                        @if($lead->bre_status == 'Eligible')
                            <span class="badge bg-success">Eligible</span>
                        @else
                            <span class="badge bg-danger">Not Eligible</span>
                            <small class="d-block text-muted" style="font-size: 0.75rem;">
                                @if(is_array($lead->bre_reasons))
                                    {{ implode(', ', $lead->bre_reasons) }}
                                @endif
                            </small>
                        @endif
                    </td>
                    <td>{{ $lead->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No leads found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer pb-0">
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
