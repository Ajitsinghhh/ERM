@extends('layouts.dashboard')

@section('page-title', 'User Management')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">User Management</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>
            Create New User
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

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>
                        All Users
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Employee Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-white small"></i>
                                                </div>
                                                <strong>{{ $user->name }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'superadmin')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-crown me-1"></i>
                                                    Super Admin
                                                </span>
                                            @elseif($user->role === 'admin')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-user-shield me-1"></i>
                                                    Admin
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-user me-1"></i>
                                                    User
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->employee_role)
                                                <span class="badge bg-info">
                                                    <i class="fas fa-briefcase me-1"></i>
                                                    {{ $user->getEmployeeRoleDisplayName() }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                @if($user->id !== Auth::id())
                                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $user->email_verified_at ? 'btn-warning' : 'btn-success' }}" 
                                                                title="{{ $user->email_verified_at ? 'Deactivate' : 'Activate' }}">
                                                            <i class="fas fa-{{ $user->email_verified_at ? 'pause' : 'play' }}"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No users found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($users->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
@endsection
