@extends('layouts.dashboard')

@section('page-title', 'HR Manager Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('hr.employee-registration') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i>
            Register New Employee
        </a>
        <a href="{{ route('hr.employees.import') }}" class="btn btn-info">
            <i class="fas fa-file-import me-1"></i>
            Import CSV
        </a>
        <a href="{{ route('hr.employees.export') }}" class="btn btn-success">
            <i class="fas fa-download me-1"></i>
            Export CSV
        </a>
    </div>
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

<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title mb-1">
                            <i class="fas fa-hand-wave me-2"></i>
                            Welcome back, {{ Auth::user()->name }}!
                        </h4>
                        <p class="card-text mb-0">
                            You are logged in as <strong>{{ Auth::user()->getEmployeeRoleDisplayName() }}</strong>
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <i class="fas fa-user-tie fa-4x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Employees
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEmployees }}</div>
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
                            Active Employees
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeEmployees }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Inactive Employees
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inactiveEmployees }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-times fa-2x text-gray-300"></i>
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
                            HR Managers
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hrManagers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Statistics Row -->
<div class="row mb-4">
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
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
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
                            In Progress Tasks
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskStats['in_progress'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
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

<!-- Quick Actions -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('hr.employee-registration') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus me-2"></i>
                            Add New Employee
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('hr.employees.index') }}" class="btn btn-info btn-block">
                            <i class="fas fa-users me-2"></i>
                            View All Employees
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('hr.employees.import') }}" class="btn btn-info btn-block">
                            <i class="fas fa-file-import me-2"></i>
                            Import Employee Data
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('hr.employees.export') }}" class="btn btn-success btn-block">
                            <i class="fas fa-download me-2"></i>
                            Export Employee Data
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('tasks.index') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-tasks me-2"></i>
                            Task Management
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="btn btn-secondary btn-block">
                            <i class="fas fa-cog me-2"></i>
                            HR Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection