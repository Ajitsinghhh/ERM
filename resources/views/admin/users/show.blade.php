@extends('layouts.dashboard')

@section('page-title', 'User Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User Management</a></li>
    <li class="breadcrumb-item active">User Details</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Users
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i>
            Edit User
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user me-2"></i>
                    User Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Full Name
                            </label>
                            <p class="form-control-plaintext">{{ $user->name }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                Email Address
                            </label>
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user-tag me-2 text-primary"></i>
                                User Role
                            </label>
                            <p class="form-control-plaintext">
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-primary">Regular User</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-briefcase me-2 text-primary"></i>
                                Employee Role
                            </label>
                            <p class="form-control-plaintext">
                                @if($user->employee_role)
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $user->employee_role)) }}</span>
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                Created At
                            </label>
                            <p class="form-control-plaintext">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                Last Updated
                            </label>
                            <p class="form-control-plaintext">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-check-circle me-2 text-primary"></i>
                                Email Verified
                            </label>
                            <p class="form-control-plaintext">
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                    <small class="text-muted d-block">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                @else
                                    <span class="badge bg-warning">Not Verified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-sign-in-alt me-2 text-primary"></i>
                                Last Login
                            </label>
                            <p class="form-control-plaintext">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('M d, Y H:i') }}
                                @else
                                    <span class="text-muted">Never logged in</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tools me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit User
                    </a>
                    
                    @if($user->email_verified_at)
                        <button class="btn btn-warning" onclick="resendVerification({{ $user->id }})">
                            <i class="fas fa-envelope me-1"></i>
                            Resend Verification
                        </button>
                    @endif
                    
                    <button class="btn btn-info" onclick="resetPassword({{ $user->id }})">
                        <i class="fas fa-key me-1"></i>
                        Reset Password
                    </button>
                    
                    <button class="btn btn-{{ $user->email_verified_at ? 'secondary' : 'success' }}" 
                            onclick="toggleUserStatus({{ $user->id }})">
                        <i class="fas fa-{{ $user->email_verified_at ? 'ban' : 'check' }} me-1"></i>
                        {{ $user->email_verified_at ? 'Deactivate' : 'Activate' }} User
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Danger Zone
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Once you delete a user, there is no going back. Please be certain.
                </p>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash me-1"></i>
                        Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function resendVerification(userId) {
    if (confirm('Are you sure you want to resend the verification email?')) {
        // Add AJAX call to resend verification
        console.log('Resending verification for user:', userId);
    }
}

function resetPassword(userId) {
    if (confirm('Are you sure you want to reset this user\'s password? They will receive an email with a new password.')) {
        // Add AJAX call to reset password
        console.log('Resetting password for user:', userId);
    }
}

function toggleUserStatus(userId) {
    if (confirm('Are you sure you want to change this user\'s status?')) {
        // Add AJAX call to toggle user status
        console.log('Toggling status for user:', userId);
    }
}
</script>
@endsection