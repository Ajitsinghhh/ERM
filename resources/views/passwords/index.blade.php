@extends('layouts.dashboard')

@section('page-title', 'Password Manager')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Password Manager</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('passwords.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            Add Password
        </a>
    </div>
@endsection

@section('content')

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('passwords.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search passwords...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="favorites" class="form-label">Filter</label>
                            <select class="form-select" id="favorites" name="favorites">
                                <option value="" {{ !request('favorites') ? 'selected' : '' }}>All</option>
                                <option value="1" {{ request('favorites') == '1' ? 'selected' : '' }}>Favorites Only</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>
                                Search
                            </button>
                            <a href="{{ route('passwords.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Passwords List -->
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>
                        Saved Passwords ({{ $passwords->total() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($passwords->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Account</th>
                                        <th>Username</th>
                                        <th>Category</th>
                                        <th>Password</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($passwords as $password)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($password->is_favorite)
                                                        <i class="fas fa-star text-warning me-2"></i>
                                                    @endif
                                                    <strong>{{ $password->title }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $password->account_name }}</td>
                                            <td>{{ $password->username ?: 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($password->category) }}</span>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="password" class="form-control password-field" 
                                                           value="{{ $password->getDecryptedPassword() }}" 
                                                           id="password-{{ $password->id }}" readonly>
                                                    <button class="btn btn-outline-secondary toggle-password" 
                                                            type="button" data-target="password-{{ $password->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-primary copy-password" 
                                                            type="button" data-password-id="{{ $password->id }}">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('passwords.show', $password) }}" 
                                                       class="btn btn-sm btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('passwords.edit', $password) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-{{ $password->is_favorite ? 'warning' : 'secondary' }} toggle-favorite" 
                                                            data-password-id="{{ $password->id }}" 
                                                            title="{{ $password->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                    <form action="{{ route('passwords.destroy', $password) }}" 
                                                          method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this password?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $passwords->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-key fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No passwords found</h5>
                            <p class="text-muted">Start by adding your first password to get started.</p>
                            <a href="{{ route('passwords.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Add Your First Password
                            </a>
                        </div>
                    @endif
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
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordField = document.getElementById(targetId);
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
    });

    // Copy password to clipboard
    document.querySelectorAll('.copy-password').forEach(button => {
        button.addEventListener('click', function() {
            const passwordId = this.getAttribute('data-password-id');
            const passwordField = document.getElementById('password-' + passwordId);
            
            passwordField.select();
            passwordField.setSelectionRange(0, 99999); // For mobile devices
            
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
    });

    // Toggle favorite
    document.querySelectorAll('.toggle-favorite').forEach(button => {
        button.addEventListener('click', function() {
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
});
</script>
@endsection
