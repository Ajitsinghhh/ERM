@extends('layouts.dashboard')

@section('page-title', 'Add New Password')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('passwords.index') }}">Password Manager</a></li>
    <li class="breadcrumb-item active">Add New Password</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('passwords.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Passwords
        </a>
    </div>
@endsection

@section('content')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-key me-2"></i>
                                Password Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('passwords.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title') }}" 
                                               placeholder="e.g., Gmail Account" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="account_name" class="form-label">Account Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('account_name') is-invalid @enderror" 
                                               id="account_name" name="account_name" value="{{ old('account_name') }}" 
                                               placeholder="e.g., Gmail" required>
                                        @error('account_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username/Email</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                               id="username" name="username" value="{{ old('username') }}" 
                                               placeholder="username@example.com">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select class="form-select @error('category') is-invalid @enderror" 
                                                id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $key => $value)
                                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" value="{{ old('password') }}" 
                                               placeholder="Enter password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" type="button" id="generatePassword">
                                            <i class="fas fa-random"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Use a strong password with at least 8 characters, including uppercase, lowercase, numbers, and symbols.
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="url" class="form-label">Website URL</label>
                                    <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                           id="url" name="url" value="{{ old('url') }}" 
                                           placeholder="https://example.com">
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3" 
                                              placeholder="Additional notes about this password...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_favorite" name="is_favorite" 
                                               value="1" {{ old('is_favorite') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_favorite">
                                            <i class="fas fa-star text-warning me-1"></i>
                                            Mark as favorite
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('passwords.index') }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-times me-1"></i>
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>
                                        Save Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-shield-alt me-2"></i>
                                Security Tips
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Use unique passwords for each account
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Include uppercase and lowercase letters
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Add numbers and special characters
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Make passwords at least 12 characters long
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Avoid personal information
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Change passwords regularly
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-random me-2"></i>
                                Password Generator
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="passwordLength" class="form-label">Length</label>
                                <input type="range" class="form-range" id="passwordLength" min="8" max="32" value="16">
                                <div class="d-flex justify-content-between">
                                    <small>8</small>
                                    <small id="lengthValue">16</small>
                                    <small>32</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeUppercase" checked>
                                    <label class="form-check-label" for="includeUppercase">
                                        Uppercase (A-Z)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeLowercase" checked>
                                    <label class="form-check-label" for="includeLowercase">
                                        Lowercase (a-z)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeNumbers" checked>
                                    <label class="form-check-label" for="includeNumbers">
                                        Numbers (0-9)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="includeSymbols" checked>
                                    <label class="form-check-label" for="includeSymbols">
                                        Symbols (!@#$%^&*)
                                    </label>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-primary w-100" id="generatePasswordBtn">
                                <i class="fas fa-random me-1"></i>
                                Generate Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const generatePassword = document.getElementById('generatePassword');
    const generatePasswordBtn = document.getElementById('generatePasswordBtn');
    const passwordLength = document.getElementById('passwordLength');
    const lengthValue = document.getElementById('lengthValue');
    
    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Update length display
    passwordLength.addEventListener('input', function() {
        lengthValue.textContent = this.value;
    });
    
    // Generate password
    function generateRandomPassword() {
        const length = parseInt(passwordLength.value);
        const uppercase = document.getElementById('includeUppercase').checked;
        const lowercase = document.getElementById('includeLowercase').checked;
        const numbers = document.getElementById('includeNumbers').checked;
        const symbols = document.getElementById('includeSymbols').checked;
        
        let charset = '';
        if (uppercase) charset += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if (lowercase) charset += 'abcdefghijklmnopqrstuvwxyz';
        if (numbers) charset += '0123456789';
        if (symbols) charset += '!@#$%^&*()_+-=[]{}|;:,.<>?';
        
        if (charset === '') {
            alert('Please select at least one character type.');
            return;
        }
        
        let password = '';
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        
        passwordField.value = password;
        passwordField.type = 'text';
        togglePassword.querySelector('i').classList.remove('fa-eye');
        togglePassword.querySelector('i').classList.add('fa-eye-slash');
    }
    
    generatePassword.addEventListener('click', generateRandomPassword);
    generatePasswordBtn.addEventListener('click', generateRandomPassword);
});
</script>
@endsection
