@extends('layouts.dashboard')

@section('page-title', 'Employee Details')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hr.employees.index') }}">Employee Management</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $employee->full_name }}</li>
        </ol>
    </nav>
@endsection

@section('page-actions')
    <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-arrow-left me-1"></i>
        Back to Employees
    </a>
    <form method="POST" action="{{ route('hr.employees.toggle-status', $employee->id) }}" class="d-inline me-2">
        @csrf
        <button type="submit" class="btn {{ $employee->isActive() ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                onclick="return confirm('Are you sure you want to {{ $employee->isActive() ? 'deactivate' : 'activate' }} this employee?')">
            <i class="fas {{ $employee->isActive() ? 'fa-user-times' : 'fa-user-check' }} me-1"></i>
            {{ $employee->isActive() ? 'Deactivate' : 'Activate' }} Employee
        </button>
    </form>
    <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-warning">
        <i class="fas fa-edit me-1"></i>
        Edit Employee
    </a>
@endsection

@section('content')

            <div class="row">
                <!-- Employee Photo and Basic Info -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-body text-center">
                            @if($employee->passport_photo)
                                <img src="{{ Storage::url($employee->passport_photo) }}" 
                                     alt="Employee Photo" 
                                     class="rounded-circle mb-3" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x"></i>
                                </div>
                            @endif
                            
                            <h4 class="card-title">{{ $employee->full_name }}</h4>
                            <p class="text-muted">{{ $employee->designation }}</p>
                            
                            <span class="badge {{ $employee->getStatusBadgeClass() }} fs-6">
                                <i class="fas {{ $employee->isActive() ? 'fa-check' : 'fa-times' }} me-1"></i>
                                {{ $employee->getStatusDisplayText() }} Employee
                            </span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-tools me-2"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit Details
                                </a>
                                <a href="mailto:{{ $employee->personal_email }}" class="btn btn-info">
                                    <i class="fas fa-envelope me-1"></i>
                                    Send Email
                                </a>
                                <a href="tel:{{ $employee->personal_mobile }}" class="btn btn-success">
                                    <i class="fas fa-phone me-1"></i>
                                    Call Employee
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Information -->
                <div class="col-lg-8">
                    <!-- Personal Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user me-2"></i>
                                Personal Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Full Name</label>
                                        <p class="form-control-plaintext">{{ $employee->full_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Gender</label>
                                    <p class="form-control-plaintext text-capitalize">{{ $employee->gender }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Date of Birth</label>
                                        <p class="form-control-plaintext">{{ $employee->date_of_birth->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-muted">Blood Group</label>
                                    <p class="form-control-plaintext">{{ $employee->blood_group }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-muted">Marital Status</label>
                                    <p class="form-control-plaintext text-capitalize">{{ $employee->marital_status }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Nationality</label>
                                        <p class="form-control-plaintext">{{ $employee->nationality }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Religion</label>
                                    <p class="form-control-plaintext">{{ $employee->religion }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Aadhaar Number</label>
                                        <p class="form-control-plaintext">{{ $employee->aadhaar_number }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Passport Number</label>
                                    <p class="form-control-plaintext">{{ $employee->passport_number ?: 'Not provided' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Marriage Anniversary</label>
                                        <p class="form-control-plaintext">
                                            {{ $employee->marriage_anniversary ? $employee->marriage_anniversary->format('M d, Y') : 'Not provided' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">PAN Card Number</label>
                                    <p class="form-control-plaintext">{{ $employee->pan_card ?: 'Not provided' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Passport (Document)</label>
                                        <p class="form-control-plaintext">{{ $employee->passport ?: 'Not provided' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Profile Photo</label>
                                    <p class="form-control-plaintext">{{ $employee->profile_photo ?: 'Not provided' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Aadhaar Card Front</label>
                                        <p class="form-control-plaintext">{{ $employee->aadhaar_card_front ?: 'Not provided' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Aadhaar Card Back</label>
                                    <p class="form-control-plaintext">{{ $employee->aadhaar_card_back ?: 'Not provided' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Terms and Conditions</label>
                                        <p class="form-control-plaintext">
                                            @if($employee->terms_and_conditions)
                                                <span class="badge bg-success">Accepted</span>
                                            @else
                                                <span class="badge bg-warning">Not Accepted</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-briefcase me-2"></i>
                                Professional Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Designation</label>
                                        <p class="form-control-plaintext">{{ $employee->designation }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Date of Joining</label>
                                    <p class="form-control-plaintext">{{ $employee->date_of_joining->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-phone me-2"></i>
                                Contact Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Personal Mobile</label>
                                        <p class="form-control-plaintext">
                                            <a href="tel:{{ $employee->personal_mobile }}" class="text-decoration-none">
                                                {{ $employee->personal_mobile }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Personal Email</label>
                                    <p class="form-control-plaintext">
                                        <a href="mailto:{{ $employee->personal_email }}" class="text-decoration-none">
                                            {{ $employee->personal_email }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Current Address</label>
                                        <p class="form-control-plaintext">{{ $employee->current_address }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Permanent Address</label>
                                    <p class="form-control-plaintext">{{ $employee->permanent_address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Emergency Contact
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Emergency Contact Name</label>
                                        <p class="form-control-plaintext">{{ $employee->emergency_contact_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Emergency Contact Number</label>
                                    <p class="form-control-plaintext">
                                        <a href="tel:{{ $employee->emergency_contact_number }}" class="text-decoration-none">
                                            {{ $employee->emergency_contact_number }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Relation</label>
                                        <p class="form-control-plaintext">{{ $employee->emergency_contact_relation }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Emergency Contact Address</label>
                                    <p class="form-control-plaintext">{{ $employee->emergency_contact_address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-file-alt me-2"></i>
                                Documents
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Aadhaar Card Front</label>
                                        @if($employee->aadhaar_card_front)
                                            <div>
                                                <a href="{{ Storage::url($employee->aadhaar_card_front) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>
                                                    View Document
                                                </a>
                                            </div>
                                        @else
                                            <p class="text-muted">Not uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Aadhaar Card Back</label>
                                    @if($employee->aadhaar_card_back)
                                        <div>
                                            <a href="{{ Storage::url($employee->aadhaar_card_back) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>
                                                View Document
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-muted">Not uploaded</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">PAN Card</label>
                                        @if($employee->pan_card)
                                            <div>
                                                <a href="{{ Storage::url($employee->pan_card) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>
                                                    View Document
                                                </a>
                                            </div>
                                        @else
                                            <p class="text-muted">Not uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Passport Photo</label>
                                    @if($employee->passport_photo)
                                        <div>
                                            <a href="{{ Storage::url($employee->passport_photo) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>
                                                View Document
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-muted">Not uploaded</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('scripts')
<style>
.form-label.fw-bold {
    font-weight: 600;
    color: #5a5c69;
}

.form-control-plaintext {
    font-weight: 500;
    color: #2c3e50;
}
</style>
@endsection
