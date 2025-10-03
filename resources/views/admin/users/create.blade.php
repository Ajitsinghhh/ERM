@extends('layouts.dashboard')

@section('page-title', 'Create New User')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User Management</a></li>
    <li class="breadcrumb-item active">Create New User</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Users
        </a>
    </div>
@endsection

@section('content')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-plus me-2"></i>
                                User Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.users.store') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">
                                                <i class="fas fa-user me-2 text-primary"></i>
                                                Full Name
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   required 
                                                   autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label fw-bold">
                                                <i class="fas fa-envelope me-2 text-primary"></i>
                                                Email Address
                                            </label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email') }}" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-bold">
                                                <i class="fas fa-lock me-2 text-primary"></i>
                                                Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password" 
                                                       class="form-control @error('password') is-invalid @enderror" 
                                                       id="password" 
                                                       name="password" 
                                                       required>
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label fw-bold">
                                                <i class="fas fa-lock me-2 text-primary"></i>
                                                Confirm Password
                                            </label>
                                            <input type="password" 
                                                   class="form-control" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label fw-bold">
                                                <i class="fas fa-user-tag me-2 text-primary"></i>
                                                User Role
                                            </label>
                                            <select class="form-select @error('role') is-invalid @enderror" 
                                                    id="role" 
                                                    name="role" 
                                                    required>
                                                <option value="">Select a role</option>
                                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                                    Regular User
                                                </option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="employee_role" class="form-label fw-bold">
                                                <i class="fas fa-briefcase me-2 text-primary"></i>
                                                Employee Role
                                            </label>
                                            <select class="form-select @error('employee_role') is-invalid @enderror" 
                                                    id="employee_role" 
                                                    name="employee_role">
                                                <option value="">Select employee role (optional)</option>
                                                <option value="hr_manager" {{ old('employee_role') == 'hr_manager' ? 'selected' : '' }}>
                                                    HR Manager
                                                </option>
                                                <option value="employee" {{ old('employee_role') == 'employee' ? 'selected' : '' }}>
                                                    Employee
                                                </option>
                                            </select>
                                            @error('employee_role')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>User Role:</strong> Determines system access level. <strong>Employee Role:</strong> Determines specialized dashboard and permissions.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>
                                        Create User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                Role Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-primary">
                                    <i class="fas fa-user-shield me-2"></i>
                                    Admin
                                </h6>
                                <p class="text-muted small">
                                    Administrative privileges for managing users and basic system functions.
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-success">
                                    <i class="fas fa-user me-2"></i>
                                    Regular User
                                </h6>
                                <p class="text-muted small">
                                    Standard user access with basic system permissions.
                                </p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-info">
                                    <i class="fas fa-briefcase me-2"></i>
                                    Employee Roles
                                </h6>
                                <p class="text-muted small">
                                    Specialized roles that provide access to specific dashboards and features.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
});
</script>
@endsection
