@extends('layouts.hr')

@section('page-title', 'Edit Employee')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('hr.employees.index') }}">Employee Management</a></li>
    <li class="breadcrumb-item"><a href="{{ route('hr.employees.show', $employee) }}">{{ $employee->full_name }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('page-actions')
    <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-eye me-1"></i>
        View Details
    </a>
    <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Back to Employees
    </a>
@endsection

@section('content')

            @if($errors->any())
                <div class="card border-danger mb-4">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Validation Errors</strong>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-3"><strong>Please correct the following errors:</strong></p>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li class="mb-1">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('hr.employees.update', $employee) }}" id="editEmployeeForm">
                @csrf
                @method('PUT')
                
                <!-- Personal Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user me-2"></i>
                            Personal Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label fw-bold">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('full_name') is-invalid @enderror" 
                                           id="full_name" 
                                           name="full_name" 
                                           value="{{ old('full_name', $employee->full_name) }}" 
                                           required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label fw-bold">
                                        Gender <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('gender') is-invalid @enderror" 
                                            id="gender" 
                                            name="gender" 
                                            required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label fw-bold">
                                        Date of Birth <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="date_of_birth" 
                                           name="date_of_birth" 
                                           value="{{ old('date_of_birth', $employee->date_of_birth->format('Y-m-d')) }}" 
                                           required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="blood_group" class="form-label fw-bold">
                                        Blood Group <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('blood_group') is-invalid @enderror" 
                                            id="blood_group" 
                                            name="blood_group" 
                                            required>
                                        <option value="">-- Select Blood Group --</option>
                                        <option value="A+" {{ old('blood_group', $employee->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_group', $employee->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_group', $employee->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_group', $employee->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_group', $employee->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_group', $employee->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_group', $employee->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_group', $employee->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                    @error('blood_group')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="marital_status" class="form-label fw-bold">
                                        Marital Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('marital_status') is-invalid @enderror" 
                                            id="marital_status" 
                                            name="marital_status" 
                                            required>
                                        <option value="">-- Select Status --</option>
                                        <option value="single" {{ old('marital_status', $employee->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                        <option value="married" {{ old('marital_status', $employee->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                        <option value="divorced" {{ old('marital_status', $employee->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="widowed" {{ old('marital_status', $employee->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                    @error('marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nationality" class="form-label fw-bold">
                                        Nationality <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('nationality') is-invalid @enderror" 
                                            id="nationality" 
                                            name="nationality" 
                                            required>
                                        <option value="">-- Select Nationality --</option>
                                        <option value="Indian" {{ old('nationality', $employee->nationality) == 'Indian' ? 'selected' : '' }}>Indian</option>
                                        <option value="American" {{ old('nationality', $employee->nationality) == 'American' ? 'selected' : '' }}>American</option>
                                        <option value="British" {{ old('nationality', $employee->nationality) == 'British' ? 'selected' : '' }}>British</option>
                                        <option value="Canadian" {{ old('nationality', $employee->nationality) == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                        <option value="Australian" {{ old('nationality', $employee->nationality) == 'Australian' ? 'selected' : '' }}>Australian</option>
                                        <option value="Other" {{ old('nationality', $employee->nationality) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('nationality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="religion" class="form-label fw-bold">
                                        Religion <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('religion') is-invalid @enderror" 
                                           id="religion" 
                                           name="religion" 
                                           value="{{ old('religion', $employee->religion) }}" 
                                           required>
                                    @error('religion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aadhaar_number" class="form-label fw-bold">
                                        Aadhaar Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('aadhaar_number') is-invalid @enderror" 
                                           id="aadhaar_number" 
                                           name="aadhaar_number" 
                                           value="{{ old('aadhaar_number', $employee->aadhaar_number) }}" 
                                           maxlength="12"
                                           required>
                                    @error('aadhaar_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passport_number" class="form-label fw-bold">
                                        Passport Number
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('passport_number') is-invalid @enderror" 
                                           id="passport_number" 
                                           name="passport_number" 
                                           value="{{ old('passport_number', $employee->passport_number) }}">
                                    @error('passport_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="marriage_anniversary" class="form-label fw-bold">
                                        Marriage Anniversary
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('marriage_anniversary') is-invalid @enderror" 
                                           id="marriage_anniversary" 
                                           name="marriage_anniversary" 
                                           value="{{ old('marriage_anniversary', $employee->marriage_anniversary ? $employee->marriage_anniversary->format('Y-m-d') : '') }}">
                                    @error('marriage_anniversary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pan_card" class="form-label fw-bold">
                                        PAN Card Number
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('pan_card') is-invalid @enderror" 
                                           id="pan_card" 
                                           name="pan_card" 
                                           value="{{ old('pan_card', $employee->pan_card) }}"
                                           maxlength="10">
                                    @error('pan_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passport" class="form-label fw-bold">
                                        Passport (Document)
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('passport') is-invalid @enderror" 
                                           id="passport" 
                                           name="passport" 
                                           value="{{ old('passport', $employee->passport) }}">
                                    @error('passport')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="profile_photo" class="form-label fw-bold">
                                        Profile Photo
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('profile_photo') is-invalid @enderror" 
                                           id="profile_photo" 
                                           name="profile_photo" 
                                           value="{{ old('profile_photo', $employee->profile_photo) }}">
                                    @error('profile_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aadhaar_card_front" class="form-label fw-bold">
                                        Aadhaar Card Front
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('aadhaar_card_front') is-invalid @enderror" 
                                           id="aadhaar_card_front" 
                                           name="aadhaar_card_front" 
                                           value="{{ old('aadhaar_card_front', $employee->aadhaar_card_front) }}">
                                    @error('aadhaar_card_front')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aadhaar_card_back" class="form-label fw-bold">
                                        Aadhaar Card Back
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('aadhaar_card_back') is-invalid @enderror" 
                                           id="aadhaar_card_back" 
                                           name="aadhaar_card_back" 
                                           value="{{ old('aadhaar_card_back', $employee->aadhaar_card_back) }}">
                                    @error('aadhaar_card_back')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input @error('terms_and_conditions') is-invalid @enderror" 
                                               type="checkbox" 
                                               id="terms_and_conditions" 
                                               name="terms_and_conditions" 
                                               value="1"
                                               {{ old('terms_and_conditions', $employee->terms_and_conditions) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="terms_and_conditions">
                                            Terms and Conditions Accepted
                                        </label>
                                        @error('terms_and_conditions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-briefcase me-2"></i>
                            Professional Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="designation" class="form-label fw-bold">
                                        Designation <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('designation') is-invalid @enderror" 
                                           id="designation" 
                                           name="designation" 
                                           value="{{ old('designation', $employee->designation) }}" 
                                           required>
                                    @error('designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_of_joining" class="form-label fw-bold">
                                        Date of Joining <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('date_of_joining') is-invalid @enderror" 
                                           id="date_of_joining" 
                                           name="date_of_joining" 
                                           value="{{ old('date_of_joining', $employee->date_of_joining->format('Y-m-d')) }}" 
                                           required>
                                    @error('date_of_joining')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-phone me-2"></i>
                            Contact Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="personal_mobile" class="form-label fw-bold">
                                        Personal Mobile <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('personal_mobile') is-invalid @enderror" 
                                           id="personal_mobile" 
                                           name="personal_mobile" 
                                           value="{{ old('personal_mobile', $employee->personal_mobile) }}" 
                                           required>
                                    @error('personal_mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="personal_email" class="form-label fw-bold">
                                        Personal Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('personal_email') is-invalid @enderror" 
                                           id="personal_email" 
                                           name="personal_email" 
                                           value="{{ old('personal_email', $employee->personal_email) }}" 
                                           required>
                                    @error('personal_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_address" class="form-label fw-bold">
                                        Current Address <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('current_address') is-invalid @enderror" 
                                              id="current_address" 
                                              name="current_address" 
                                              rows="3" 
                                              required>{{ old('current_address', $employee->current_address) }}</textarea>
                                    @error('current_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="permanent_address" class="form-label fw-bold">
                                        Permanent Address <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('permanent_address') is-invalid @enderror" 
                                              id="permanent_address" 
                                              name="permanent_address" 
                                              rows="3" 
                                              required>{{ old('permanent_address', $employee->permanent_address) }}</textarea>
                                    @error('permanent_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Emergency Contact
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_name" class="form-label fw-bold">
                                        Emergency Contact Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                           id="emergency_contact_name" 
                                           name="emergency_contact_name" 
                                           value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}" 
                                           required>
                                    @error('emergency_contact_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_number" class="form-label fw-bold">
                                        Emergency Contact Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('emergency_contact_number') is-invalid @enderror" 
                                           id="emergency_contact_number" 
                                           name="emergency_contact_number" 
                                           value="{{ old('emergency_contact_number', $employee->emergency_contact_number) }}" 
                                           required>
                                    @error('emergency_contact_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_relation" class="form-label fw-bold">
                                        Relation <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('emergency_contact_relation') is-invalid @enderror" 
                                            id="emergency_contact_relation" 
                                            name="emergency_contact_relation" 
                                            required>
                                        <option value="">-- Select Relation --</option>
                                        <option value="Father" {{ old('emergency_contact_relation', $employee->emergency_contact_relation) == 'Father' ? 'selected' : '' }}>Father</option>
                                        <option value="Mother" {{ old('emergency_contact_relation', $employee->emergency_contact_relation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Spouse" {{ old('emergency_contact_relation', $employee->emergency_contact_relation) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                        <option value="Sibling" {{ old('emergency_contact_relation', $employee->emergency_contact_relation) == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                        <option value="Friend" {{ old('emergency_contact_relation', $employee->emergency_contact_relation) == 'Friend' ? 'selected' : '' }}>Friend</option>
                                        <option value="Other" {{ old('emergency_contact_relation', $employee->emergency_contact_relation) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('emergency_contact_relation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_address" class="form-label fw-bold">
                                        Emergency Contact Address <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('emergency_contact_address') is-invalid @enderror" 
                                              id="emergency_contact_address" 
                                              name="emergency_contact_address" 
                                              rows="3" 
                                              required>{{ old('emergency_contact_address', $employee->emergency_contact_address) }}</textarea>
                                    @error('emergency_contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i>
                        Update Employee
                    </button>
                </div>
            </form>
@endsection

@section('scripts')
<style>
.text-danger {
    color: #dc3545 !important;
}

.form-label.fw-bold {
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aadhaar number validation
    const aadhaarInput = document.getElementById('aadhaar_number');
    aadhaarInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, ''); // Only allow digits
        if (this.value.length > 12) {
            this.value = this.value.slice(0, 12);
        }
    });

    // Phone number validation
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Only allow digits
        });
    });

    // Form validation
    const form = document.getElementById('editEmployeeForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});
</script>
@endsection
