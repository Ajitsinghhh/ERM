@extends('layouts.dashboard')

@section('page-title', 'Admin Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-download me-1"></i>
            Export
        </button>
    </div>
@endsection

@section('content')

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::whereNotNull('email_verified_at')->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Regular Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::where('role', 'user')->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        System Status
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Online</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-server fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Statistics -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="text-primary mb-3">
                        <i class="fas fa-tasks me-2"></i>
                        Task Management Overview
                    </h5>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['total'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['pending'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Completed Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['completed'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Overdue Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['overdue'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history me-2"></i>
                                Recent Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ Auth::user()->name }}</td>
                                            <td>Admin Login</td>
                                            <td>{{ now()->format('M d, Y H:i') }}</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                        <!-- Add more activity rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-tools me-2"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-user-plus me-1"></i>
                                    Create User
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-users me-1"></i>
                                    Manage Users
                                </a>
                                <a href="{{ route('passwords.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-key me-1"></i>
                                    Password Manager
                                </a>
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Generate Report
                                </button>
                                <button class="btn btn-secondary btn-sm">
                                    <i class="fas fa-database me-1"></i>
                                    View Logs
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
