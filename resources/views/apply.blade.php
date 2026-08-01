@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Customer Loan Application</h4>
            </div>
            <div class="card-body">
                <div id="alert-container"></div>
                
                <form id="loanForm">
                    @csrf
                    
                    <h5 class="mt-2 border-bottom pb-2">Customer Details</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number *</label>
                            <input type="text" name="mobile" class="form-control" required pattern="\d{10}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email ID *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth *</label>
                            <input type="date" name="dob" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">City *</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pincode *</label>
                            <input type="text" name="pincode" class="form-control" required pattern="\d{6}">
                        </div>
                    </div>

                    <h5 class="mt-4 border-bottom pb-2">Loan Details</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Loan Type *</label>
                            <select name="loan_type" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Home Loan">Home Loan</option>
                                <option value="Loan Against Property">Loan Against Property (LAP)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Employment Type *</label>
                            <select name="employment_type" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Salaried">Salaried</option>
                                <option value="Self Employed">Self Employed</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Monthly Income *</label>
                            <input type="number" name="monthly_income" class="form-control" required min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Loan Amount Required *</label>
                            <input type="number" name="loan_amount" class="form-control" required min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Property Value *</label>
                            <input type="number" name="property_value" class="form-control" required min="0">
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="consent" class="form-check-input" id="consent" required value="1">
                        <label class="form-check-label" for="consent">
                            I consent to sharing my information with lending partners for loan processing. *
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">Check Eligibility & Apply</button>
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
        btn.prop('disabled', true).text('Processing...');
        $('#alert-container').html('');

        $.ajax({
            url: '/api/leads',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                btn.prop('disabled', false).text('Check Eligibility & Apply');
                
                let alertClass = response.bre_status === 'Eligible' ? 'alert-success' : 'alert-danger';
                let alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show">
                    <h5 class="alert-heading">Status: ${response.bre_status}</h5>
                    <p>Lead ID: ${response.lead_id}</p>
                    <p>Credit Score: ${response.credit_score}</p>`;
                
                if (response.bre_status === 'Not Eligible' && response.reasons) {
                    alertHtml += '<hr><p class="mb-0"><strong>Reasons for Rejection:</strong></p><ul>';
                    response.reasons.forEach(function(reason) {
                        alertHtml += `<li>${reason}</li>`;
                    });
                    alertHtml += '</ul>';
                }
                
                alertHtml += `<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
                
                $('#alert-container').html(alertHtml);
                $('#loanForm')[0].reset();
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Check Eligibility & Apply');
                
                let errorMsg = 'An error occurred while processing your application.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                let alertHtml = `<div class="alert alert-danger alert-dismissible fade show">
                    ${errorMsg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
                
                $('#alert-container').html(alertHtml);
            }
        });
    });
});
</script>
@endsection
