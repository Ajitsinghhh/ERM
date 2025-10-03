@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-home me-2"></i>
                        Welcome, {{ Auth::user()->name }}!
                    </h4>
                    <span class="badge bg-{{ Auth::user()->isAdmin() ? 'primary' : 'success' }} fs-6">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="text-muted mb-3">Dashboard Overview</h5>
                            <p class="lead">
                                Welcome to your personal dashboard! You are logged in as a 
                                <strong class="text-{{ Auth::user()->isAdmin() ? 'primary' : 'success' }}">
                                    {{ ucfirst(Auth::user()->role) }}
                                </strong>.
                            </p>
                            
                            @if(Auth::user()->isAdmin())
                                <div class="alert alert-primary" role="alert">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-user-shield me-2"></i>
                                        Admin Access
                                    </h6>
                                    <p class="mb-0">You have administrative privileges to manage the system.</p>
                                </div>
                            @else
                                <div class="alert alert-info" role="alert">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-info-circle me-2"></i>
                                        User Access
                                    </h6>
                                    <p class="mb-0">You have standard user access to the system. Contact your administrator to assign you a specific role (HR Manager, Accountant, Manager, or Employee).</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        @if(Auth::user()->isAdmin())
                                            <i class="fas fa-user-shield fa-3x text-primary"></i>
                                        @else
                                            <i class="fas fa-user fa-3x text-success"></i>
                                        @endif
                                    </div>
                                    <h6 class="card-title">{{ Auth::user()->name }}</h6>
                                    <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                                    <small class="text-muted">
                                        Role: {{ ucfirst(Auth::user()->role) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">Quick Actions</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                        <i class="fas fa-tachometer-alt me-1"></i>
                                        Admin Dashboard
                                    </a>
                                @endif
                                
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-user-edit me-1"></i>
                                    Edit Profile
                                </button>
                                
                                <button class="btn btn-outline-info">
                                    <i class="fas fa-cog me-1"></i>
                                    Settings
                                </button>
                                
                                <a href="{{ route('logout') }}" 
                                   class="btn btn-outline-danger"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-1"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
