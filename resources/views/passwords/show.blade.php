@extends('layouts.dashboard')

@section('page-title', 'Password Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('passwords.index') }}">Password Manager</a></li>
    <li class="breadcrumb-item active">Password Details</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('passwords.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Passwords
        </a>
        <a href="{{ route('passwords.edit', $password) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i>
            Edit
        </a>
    </div>
@endsection

@section('content')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-key me-2"></i>
                                {{ $password->title }}
                                @if($password->is_favorite)
                                    <i class="fas fa-star text-warning ms-2"></i>
                                @endif
                            </h6>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary toggle-favorite" 
                                        data-password-id="{{ $password->id }}" 
                                        title="{{ $password->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Account Name</label>
                                    <p class="form-control-plaintext">{{ $password->account_name }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Category</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-secondary">{{ ucfirst($password->category) }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Username/Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $password->username ?: 'N/A' }}" readonly>
                                        @if($password->username)
                                            <button class="btn btn-outline-secondary copy-text" type="button" data-text="{{ $password->username }}">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control password-field" 
                                               value="{{ $password->getDecryptedPassword() }}" 
                                               id="password-display" readonly>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-primary copy-password" type="button">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @if($password->url)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Website URL</label>
                                <div class="input-group">
                                    <input type="url" class="form-control" value="{{ $password->url }}" readonly>
                                    <a href="{{ $password->url }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <button class="btn btn-outline-secondary copy-text" type="button" data-text="{{ $password->url }}">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            @endif

                            @if($password->notes)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Notes</label>
                                <div class="form-control-plaintext bg-light p-3 rounded">
                                    {{ $password->notes }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>
                                Password Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-5">Created:</dt>
                                <dd class="col-sm-7">{{ $password->created_at->format('M d, Y H:i') }}</dd>
                                
                                <dt class="col-sm-5">Last Updated:</dt>
                                <dd class="col-sm-7">{{ $password->updated_at->format('M d, Y H:i') }}</dd>
                                
                                <dt class="col-sm-5">Category:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge bg-secondary">{{ ucfirst($password->category) }}</span>
                                </dd>
                                
                                <dt class="col-sm-5">Favorite:</dt>
                                <dd class="col-sm-7">
                                    @if($password->is_favorite)
                                        <i class="fas fa-star text-warning"></i> Yes
                                    @else
                                        <i class="fas fa-star text-muted"></i> No
                                    @endif
                                </dd>
                                
                                <dt class="col-sm-5">Password Length:</dt>
                                <dd class="col-sm-7">{{ strlen($password->getDecryptedPassword()) }} characters</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-tools me-2"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('passwords.edit', $password) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit Password
                                </a>
                                @if($password->url)
                                <a href="{{ $password->url }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    Visit Website
                                </a>
                                @endif
                                <button class="btn btn-outline-success copy-all" data-password="{{ $password }}">
                                    <i class="fas fa-copy me-1"></i>
                                    Copy All Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Danger Zone
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                Once you delete a password, there is no going back. Please be certain.
                            </p>
                            <form action="{{ route('passwords.destroy', $password) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this password? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-1"></i>
                                    Delete Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('scripts')
<style>
.password-field {
    font-family: monospace;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password-display');
    const togglePassword = document.querySelector('.toggle-password');
    const copyPassword = document.querySelector('.copy-password');
    const copyTextButtons = document.querySelectorAll('.copy-text');
    const copyAllButton = document.querySelector('.copy-all');
    const toggleFavorite = document.querySelector('.toggle-favorite');
    
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
    
    // Copy password to clipboard
    copyPassword.addEventListener('click', function() {
        passwordField.select();
        passwordField.setSelectionRange(0, 99999);
        
        try {
            document.execCommand('copy');
            this.innerHTML = '<i class="fas fa-check text-success"></i>';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-copy"></i>';
            }, 2000);
        } catch (err) {
            console.error('Failed to copy password: ', err);
        }
    });
    
    // Copy text to clipboard
    copyTextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const text = this.getAttribute('data-text');
            navigator.clipboard.writeText(text).then(() => {
                this.innerHTML = '<i class="fas fa-check text-success"></i>';
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-copy"></i>';
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        });
    });
    
    // Copy all details
    copyAllButton.addEventListener('click', function() {
        const password = JSON.parse(this.getAttribute('data-password'));
        const details = `Title: ${password.title}
Account: ${password.account_name}
Username: ${password.username || 'N/A'}
Password: ${password.password}
URL: ${password.url || 'N/A'}
Notes: ${password.notes || 'N/A'}`;
        
        navigator.clipboard.writeText(details).then(() => {
            this.innerHTML = '<i class="fas fa-check text-success me-1"></i>Copied!';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-copy me-1"></i>Copy All Details';
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy details: ', err);
        });
    });
    
    // Toggle favorite
    toggleFavorite.addEventListener('click', function() {
        const passwordId = this.getAttribute('data-password-id');
        
        fetch(`/passwords/${passwordId}/toggle-favorite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endsection
