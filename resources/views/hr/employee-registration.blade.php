@extends('layouts.dashboard')

@section('page-title', 'Employee Registration')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Employee Registration</li>
        </ol>
    </nav>
@endsection

@section('page-actions')
    <a href="{{ route('hr.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Back to Dashboard
    </a>
@endsection

@section('content')

            @if(session('success'))
                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Success</strong>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-0">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

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

            <form method="POST" action="{{ route('hr.employee-registration.store') }}" enctype="multipart/form-data" id="employeeRegistrationForm">
                @csrf
                
                <!-- Step 1: Personal Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user me-2"></i>
                            Step 1: Employee Personal Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label fw-bold">
                                        Full Name (As per Government ID) <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('full_name') is-invalid @enderror" 
                                           id="full_name" 
                                           name="full_name" 
                                           value="{{ old('full_name') }}" 
                                           placeholder="Enter Your Full Name"
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
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
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
                                           value="{{ old('date_of_birth') }}" 
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
                                        <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
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
                                        <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                        <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                                        <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                    @error('marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Marriage Anniversary Field (shown only when married) -->
                        <div class="row" id="marriage_anniversary_row" style="display: none;">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="marriage_anniversary" class="form-label fw-bold">
                                        Marriage Anniversary Date (Optional)
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('marriage_anniversary') is-invalid @enderror" 
                                           id="marriage_anniversary" 
                                           name="marriage_anniversary" 
                                           value="{{ old('marriage_anniversary') }}" 
                                           placeholder="Select Marriage Anniversary Date">
                                    @error('marriage_anniversary')
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
                                        <option value="Indian" {{ old('nationality') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                        <option value="American" {{ old('nationality') == 'American' ? 'selected' : '' }}>American</option>
                                        <option value="British" {{ old('nationality') == 'British' ? 'selected' : '' }}>British</option>
                                        <option value="Canadian" {{ old('nationality') == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                        <option value="Australian" {{ old('nationality') == 'Australian' ? 'selected' : '' }}>Australian</option>
                                        <option value="Other" {{ old('nationality') == 'Other' ? 'selected' : '' }}>Other</option>
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
                                           value="{{ old('religion') }}" 
                                           placeholder="Enter Your Religion"
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
                                        Aadhaar Number (Govt. ID Proof) <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('aadhaar_number') is-invalid @enderror" 
                                           id="aadhaar_number" 
                                           name="aadhaar_number" 
                                           value="{{ old('aadhaar_number') }}" 
                                           placeholder="Enter Aadhaar Number"
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
                                        Passport Number (Optional)
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('passport_number') is-invalid @enderror" 
                                           id="passport_number" 
                                           name="passport_number" 
                                           value="{{ old('passport_number') }}" 
                                           placeholder="Enter Passport Number">
                                    @error('passport_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

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
                                           value="{{ old('designation') }}" 
                                           placeholder="Enter Designation"
                                           required>
                                    @error('designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_of_joining" class="form-label fw-bold">
                                        Date of Joining <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('date_of_joining') is-invalid @enderror" 
                                           id="date_of_joining" 
                                           name="date_of_joining" 
                                           value="{{ old('date_of_joining') }}" 
                                           required>
                                    @error('date_of_joining')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Document Uploads -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aadhaar_card_front" class="form-label fw-bold">
                                        Upload Aadhaar Card Front Photo <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('aadhaar_card_front') is-invalid @enderror" 
                                           id="aadhaar_card_front" 
                                           name="aadhaar_card_front" 
                                           accept="image/*"
                                           required>
                                    <div class="form-text">Max size: 2MB, Formats: JPG, PNG, JPEG</div>
                                    @error('aadhaar_card_front')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aadhaar_card_back" class="form-label fw-bold">
                                        Upload Aadhaar Card Back Photo <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('aadhaar_card_back') is-invalid @enderror" 
                                           id="aadhaar_card_back" 
                                           name="aadhaar_card_back" 
                                           accept="image/*"
                                           required>
                                    <div class="form-text">Max size: 2MB, Formats: JPG, PNG, JPEG</div>
                                    @error('aadhaar_card_back')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passport_photo" class="form-label fw-bold">
                                        Upload Professional Passport Size Photo <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('passport_photo') is-invalid @enderror" 
                                           id="passport_photo" 
                                           name="passport_photo" 
                                           accept="image/*"
                                           required>
                                    <div class="form-text">Max size: 2MB, Formats: JPG, PNG, JPEG</div>
                                    @error('passport_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pan_card" class="form-label fw-bold">
                                        Upload PAN Card (Optional)
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('pan_card') is-invalid @enderror" 
                                           id="pan_card" 
                                           name="pan_card" 
                                           accept="image/*">
                                    <div class="form-text">Max size: 2MB, Formats: JPG, PNG, JPEG</div>
                                    @error('pan_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Contact & Emergency Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-phone me-2"></i>
                            Step 2: Contact & Emergency Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="personal_mobile" class="form-label fw-bold">
                                        Personal Mobile Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('personal_mobile') is-invalid @enderror" 
                                           id="personal_mobile" 
                                           name="personal_mobile" 
                                           value="{{ old('personal_mobile') }}" 
                                           placeholder="Enter Your Phone Number"
                                           required>
                                    @error('personal_mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="personal_email" class="form-label fw-bold">
                                        Personal Email ID <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('personal_email') is-invalid @enderror" 
                                           id="personal_email" 
                                           name="personal_email" 
                                           value="{{ old('personal_email') }}" 
                                           placeholder="Enter Your Email"
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
                                        Current Full Address <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('current_address') is-invalid @enderror" 
                                              id="current_address" 
                                              name="current_address" 
                                              rows="3" 
                                              placeholder="Enter Your Current Address"
                                              required>{{ old('current_address') }}</textarea>
                                    @error('current_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="permanent_address" class="form-label fw-bold">
                                        Permanent Address / HomeTown Address <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('permanent_address') is-invalid @enderror" 
                                              id="permanent_address" 
                                              name="permanent_address" 
                                              rows="3" 
                                              placeholder="Enter Your Permanent Address"
                                              required>{{ old('permanent_address') }}</textarea>
                                    @error('permanent_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h6 class="text-primary mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Emergency Contact Information
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_name" class="form-label fw-bold">
                                        Emergency Contact Person Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                           id="emergency_contact_name" 
                                           name="emergency_contact_name" 
                                           value="{{ old('emergency_contact_name') }}" 
                                           placeholder="Enter Emergency Contact Name"
                                           required>
                                    @error('emergency_contact_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_number" class="form-label fw-bold">
                                        Emergency Contact Person Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('emergency_contact_number') is-invalid @enderror" 
                                           id="emergency_contact_number" 
                                           name="emergency_contact_number" 
                                           value="{{ old('emergency_contact_number') }}" 
                                           placeholder="Enter Emergency Contact Number"
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
                                        Relation with Emergency Contact Person <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('emergency_contact_relation') is-invalid @enderror" 
                                            id="emergency_contact_relation" 
                                            name="emergency_contact_relation" 
                                            required>
                                        <option value="">-- Select Relation --</option>
                                        <option value="Father" {{ old('emergency_contact_relation') == 'Father' ? 'selected' : '' }}>Father</option>
                                        <option value="Mother" {{ old('emergency_contact_relation') == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Spouse" {{ old('emergency_contact_relation') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                        <option value="Sibling" {{ old('emergency_contact_relation') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                        <option value="Friend" {{ old('emergency_contact_relation') == 'Friend' ? 'selected' : '' }}>Friend</option>
                                        <option value="Other" {{ old('emergency_contact_relation') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('emergency_contact_relation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_address" class="form-label fw-bold">
                                        Emergency Contact Person Address <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('emergency_contact_address') is-invalid @enderror" 
                                              id="emergency_contact_address" 
                                              name="emergency_contact_address" 
                                              rows="3" 
                                              placeholder="Enter Emergency Contact Address"
                                              required>{{ old('emergency_contact_address') }}</textarea>
                                    @error('emergency_contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="card shadow mb-4 border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Terms and Conditions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Important:</strong> By registering an employee, you confirm that all provided information is accurate and you have obtained necessary permissions for data collection and storage.
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('terms_accepted') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="terms_accepted" 
                                   name="terms_accepted" 
                                   value="1" 
                                   {{ old('terms_accepted') ? 'checked' : '' }}
                                   required>
                            <label class="form-check-label fw-bold" for="terms_accepted">
                                I accept the Terms and Conditions and confirm the accuracy of all provided information <span class="text-danger">*</span>
                            </label>
                            @error('terms_accepted')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('hr.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-1"></i>
                        Register Employee
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

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
}

.form-check-input.is-invalid {
    border-color: #dc3545;
}

.form-check-input.is-invalid:checked {
    background-color: #dc3545;
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}

.border-warning {
    border-color: #ffc107 !important;
}

/* Smooth transition for conditional fields */
#marriage_anniversary_row {
    transition: all 0.3s ease-in-out;
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

    // Aadhaar card upload validation
    const aadhaarFrontInput = document.getElementById('aadhaar_card_front');
    const aadhaarBackInput = document.getElementById('aadhaar_card_back');
    
    function validateAadhaarFile(input, fieldName) {
        const file = input.files[0];
        if (file) {
            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                alert(`${fieldName} file size must not exceed 2MB.`);
                input.value = '';
                return false;
            }
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert(`${fieldName} must be a JPEG, PNG, or JPG file.`);
                input.value = '';
                return false;
            }
        }
        return true;
    }
    
    aadhaarFrontInput.addEventListener('change', function() {
        validateAadhaarFile(this, 'Aadhaar Card Front');
    });
    
    aadhaarBackInput.addEventListener('change', function() {
        validateAadhaarFile(this, 'Aadhaar Card Back');
    });
    
    // Terms and conditions real-time validation
    const termsCheckbox = document.getElementById('terms_accepted');
    termsCheckbox.addEventListener('change', function() {
        if (this.checked) {
            this.classList.remove('is-invalid');
        } else {
            this.classList.add('is-invalid');
        }
    });

    // Marriage anniversary field visibility
    const maritalStatusSelect = document.getElementById('marital_status');
    const marriageAnniversaryRow = document.getElementById('marriage_anniversary_row');
    const marriageAnniversaryInput = document.getElementById('marriage_anniversary');
    
    function toggleMarriageAnniversary() {
        if (maritalStatusSelect.value === 'married') {
            marriageAnniversaryRow.style.display = 'block';
        } else {
            marriageAnniversaryRow.style.display = 'none';
            marriageAnniversaryInput.value = ''; // Clear the field when hidden
        }
    }
    
    // Show/hide marriage anniversary field on page load (for form validation errors)
    toggleMarriageAnniversary();
    
    // Show/hide marriage anniversary field on change
    maritalStatusSelect.addEventListener('change', toggleMarriageAnniversary);

    // Form validation
    const form = document.getElementById('employeeRegistrationForm');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        // Special validation for Aadhaar card uploads
        if (!aadhaarFrontInput.files[0]) {
            aadhaarFrontInput.classList.add('is-invalid');
            isValid = false;
            alert('Please upload Aadhaar Card Front Photo.');
        } else {
            aadhaarFrontInput.classList.remove('is-invalid');
        }
        
        if (!aadhaarBackInput.files[0]) {
            aadhaarBackInput.classList.add('is-invalid');
            isValid = false;
            alert('Please upload Aadhaar Card Back Photo.');
        } else {
            aadhaarBackInput.classList.remove('is-invalid');
        }
        
        // Terms and conditions validation
        const termsCheckbox = document.getElementById('terms_accepted');
        if (!termsCheckbox.checked) {
            termsCheckbox.classList.add('is-invalid');
            isValid = false;
            alert('You must accept the Terms and Conditions to register an employee.');
        } else {
            termsCheckbox.classList.remove('is-invalid');
        }
        
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
