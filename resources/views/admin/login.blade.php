@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="glass-card">
            <div class="card-header d-flex flex-column align-items-center gap-2 pt-5 pb-4">
                <div class="p-3 rounded-circle bg-primary bg-opacity-25 text-indigo-300 mb-2">
                    <i class="bi bi-shield-lock fs-2"></i>
                </div>
                <h4 class="mb-0 text-white fw-bold">Admin Portal Access</h4>
                <p class="text-muted text-center px-4 mb-0" style="font-size: 0.85rem;">Authenticate to configure business rule boundaries and manage customer leads</p>
            </div>
            
            <div class="card-body px-4 pb-5">
                @if(session('error'))
                    <div class="alert alert-danger border-danger mb-4">
                        <i class="bi bi-exclamation-octagon me-2"></i> {{ session('error') }}
                    </div>
                @endif
                
                <form action="{{ url('/admin/login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label d-flex align-items-center gap-1">
                            <i class="bi bi-envelope"></i> Email Address
                        </label>
                        <input type="email" name="email" class="form-control" placeholder="admin@loanbridge.com" required autofocus>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label d-flex align-items-center gap-1">
                            <i class="bi bi-key"></i> Password
                        </label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 mt-2 d-flex align-items-center justify-content-center gap-2">
                        <span>Authenticate</span> <i class="bi bi-unlock fs-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
