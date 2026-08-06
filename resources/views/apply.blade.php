@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12 d-block d-lg-flex gap-4 align-items-start">
        
        <!-- Left Column: Current Eligibility Criteria -->
        @if(isset($rules) && $rules->count() > 0)
        <div class="glass-card mb-4 flex-grow-1 col-lg-4" style="min-width: 320px;">
            <div class="card-header d-flex align-items-center gap-2">
                <div class="p-2 rounded bg-indigo-500 bg-opacity-20 text-indigo-400 d-inline-flex">
                    <i class="bi bi-shield-check fs-5 text-primary-light"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-white">Current Eligibility Rules</h5>
                    <small class="text-muted">Real-time evaluation ruleset</small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th>Condition</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rules as $rule)
                            <tr class="align-middle">
                                <td>
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill text-indigo-400 text-opacity-70" style="font-size: 0.85rem;"></i>
                                        <strong>{{ $rule->rule_field }}</strong>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-opacity-25 bg-info text-info border border-info border-opacity-20 px-2 py-1">
                                        {{ $rule->operator }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-white fw-semibold">{{ $rule->value }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Right Column: Customer Loan Application Form -->
        <div class="glass-card flex-grow-1 col-lg-8">
            <div class="card-header d-flex align-items-center gap-3">
                <div class="p-3 rounded-3 bg-opacity-10 bg-primary d-inline-flex text-white">
                    <i class="bi bi-file-earmark-person fs-4"></i>
                </div>
                <div>
                    <h4 class="mb-0 text-white">Customer Loan Application</h4>
                    <p class="text-muted mb-0">Complete details below to query instantly against our Business Rule Engine</p>
                </div>
            </div>
            
            <div class="card-body">
                <div id="alert-container"></div>
                
                <form id="loanForm" class="needs-validation" novalidate>
                    @csrf
                    
                    <!-- Section Title -->
                    <div class="d-flex align-items-center gap-2 mb-4 mt-2">
                        <span class="badge bg-primary-light bg-opacity-20 text-indigo-300 rounded-pill px-3 py-1">1. Contact Information</span>
                        <div class="flex-grow-1 border-bottom border-secondary border-opacity-10"></div>
                    </div>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-person me-1"></i> Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="full_name" class="form-control" placeholder="e.g. John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-telephone me-1"></i> Mobile Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="mobile" class="form-control" placeholder="10-digit number" required pattern="\d{10}">
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-envelope me-1"></i> Email ID <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" class="form-control" placeholder="e.g. john@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-calendar-event me-1"></i> Date of Birth <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="dob" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-geo-alt me-1"></i> City <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Mumbai" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-mailbox me-1"></i> Pincode <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="pincode" class="form-control" placeholder="6-digit pincode" required pattern="\d{6}">
                        </div>
                    </div>

                    <!-- Section Title -->
                    <div class="d-flex align-items-center gap-2 mb-4 mt-5">
                        <span class="badge bg-primary-light bg-opacity-20 text-indigo-300 rounded-pill px-3 py-1">2. Financial Details</span>
                        <div class="flex-grow-1 border-bottom border-secondary border-opacity-10"></div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-wallet2 me-1"></i> Loan Type <span class="text-danger">*</span>
                            </label>
                            <select name="loan_type" class="form-select" required>
                                <option value="" disabled selected>Choose loan profile</option>
                                <option value="Home Loan">Home Loan</option>
                                <option value="Loan Against Property">Loan Against Property (LAP)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-briefcase me-1"></i> Employment Type <span class="text-danger">*</span>
                            </label>
                            <select name="employment_type" class="form-select" required>
                                <option value="" disabled selected>Select employment</option>
                                <option value="Salaried">Salaried</option>
                                <option value="Self Employed">Self Employed</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-currency-rupee me-1"></i> Monthly Income (INR) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="monthly_income" class="form-control" placeholder="e.g. 50000" required min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-cash-stack me-1"></i> Loan Amount Required <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="loan_amount" class="form-control" placeholder="e.g. 1500000" required min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-flex align-items-center gap-1">
                                <i class="bi bi-building me-1"></i> Collateral / Property Value <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="property_value" class="form-control" placeholder="e.g. 2500000" required min="0">
                        </div>
                    </div>

                    <!-- Consent and Submit -->
                    <div class="mb-4 form-check bg-white bg-opacity-5 p-3 rounded-3 border border-white border-opacity-5 d-flex align-items-start gap-2">
                        <input type="checkbox" name="consent" class="form-check-input ms-0 mt-1" id="consent" required value="1">
                        <label class="form-check-label text-muted" for="consent" style="font-size: 0.85rem; line-height: 1.4;">
                            I explicitly consent to LoanBridge query partners retrieving my deterministic Credit Profile score to analyze eligibility rules. *
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2" id="submitBtn">
                        <span>Check Eligibility & Submit Application</span> <i class="bi bi-arrow-right-short fs-5"></i>
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script>
$(document).ready(function() {
    $('#loanForm').on('submit', function(e) {
        e.preventDefault();
        
        let btn = $('#submitBtn');
        let form = this;
        
        if (!form.checkValidity()) {
            e.stopPropagation();
            $(form).addClass('was-validated');
            return;
        }
        
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing securely...');
        $('#alert-container').html('');

        $.ajax({
            url: '/api/leads',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                btn.prop('disabled', false).html('<span>Check Eligibility & Submit Application</span> <i class="bi bi-arrow-right-short fs-5"></i>');
                $(form).removeClass('was-validated');
                
                let isEligible = response.bre_status === 'Eligible';
                let alertClass = isEligible ? 'alert-success border-success' : 'alert-danger border-danger';
                
                let alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show p-4" role="alert">
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 rounded-circle ${isEligible ? 'bg-success' : 'bg-danger'} bg-opacity-20 d-flex">
                            <i class="bi ${isEligible ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger'} fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading text-white fw-bold mb-1">Decision: ${response.bre_status}</h5>
                            <div class="text-light mb-2">Application reference token: <code class="text-indigo-200 fw-semibold">${response.lead_id}</code></div>
                            <div class="text-light mb-3">Retrieved Credit Bureau score: <span class="badge bg-indigo-500 bg-opacity-35 text-indigo-100 px-2 py-1">${response.credit_score}</span></div>`;
                
                if (!isEligible && response.reasons) {
                    alertHtml += `<div class="border-top border-white border-opacity-10 pt-3 mt-2">
                        <strong class="text-white d-block mb-2"><i class="bi bi-info-circle me-1"></i> Decision Log / Reasons:</strong>
                        <ul class="mb-0 text-muted ps-3">`;
                    response.reasons.forEach(function(reason) {
                        alertHtml += `<li class="mb-1">${reason}</li>`;
                    });
                    alertHtml += '</ul></div>';
                } else if (isEligible) {
                    alertHtml += `<div class="border-top border-white border-opacity-10 pt-3 mt-2 text-muted">
                        <i class="bi bi-patch-check-fill text-success me-1"></i> Your lead matches the current rule profile. Our credit underwriters will reach out shortly.
                    </div>`;
                }
                
                alertHtml += `</div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>`;
                
                $('#alert-container').html(alertHtml);
                form.reset();
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<span>Check Eligibility & Submit Application</span> <i class="bi bi-arrow-right-short fs-5"></i>');
                
                let errorMsg = 'An error occurred while processing your application.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                let alertHtml = `<div class="alert alert-danger border-danger alert-dismissible fade show p-4" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                        <div>
                            <h5 class="alert-heading text-white fw-bold mb-1">Process Error</h5>
                            <span class="text-light">${errorMsg}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                
                $('#alert-container').html(alertHtml);
            }
        });
    });
});
</script>
@endsection
