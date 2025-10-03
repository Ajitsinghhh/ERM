@extends('layouts.dashboard')

@section('page-title', 'Employee Management')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Employee Management</li>
        </ol>
    </nav>
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
    <a href="{{ route('hr.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Back to Dashboard
    </a>
@endsection

@section('content')
<div class="container-fluid">
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

    @if(session('error'))
        <div class="card border-danger mb-4">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error</strong>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
            <div class="card-body">
                <div class="card-text mb-0" style="white-space: pre-line; font-family: monospace;">{!! nl2br(e(session('error'))) !!}</div>
            </div>
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('hr.employees.index') }}" class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Employees</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Employees</option>
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Employees</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Search employees...">
                </div>
                <div class="col-lg-4 col-md-12">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary flex-fill flex-md-grow-0">
                            <i class="fas fa-search me-1"></i>
                            <span class="d-none d-sm-inline">Filter</span>
                        </button>
                        <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary flex-fill flex-md-grow-0">
                            <i class="fas fa-times me-1"></i>
                            <span class="d-none d-sm-inline">Clear</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users me-2"></i>
                Employee List ({{ $employees->total() }})
            </h6>
        </div>
        <div class="card-body">
            @if($employees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="d-none d-md-table-cell">Photo</th>
                                <th>Name</th>
                                <th class="d-none d-lg-table-cell">Designation</th>
                                <th class="d-none d-xl-table-cell">Email</th>
                                <th class="d-none d-xl-table-cell">Mobile</th>
                                <th class="d-none d-lg-table-cell">Joining Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td class="d-none d-md-table-cell">
                                        @if($employee->passport_photo)
                                            <img src="{{ Storage::url($employee->passport_photo) }}" 
                                                 alt="Employee Photo" 
                                                 class="rounded-circle" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $employee->full_name }}</strong>
                                            <br>
                                            <small class="text-muted d-md-none">{{ $employee->designation }}</small>
                                            <small class="text-muted d-none d-md-inline">{{ $employee->aadhaar_number }}</small>
                                        </div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="badge bg-info">{{ $employee->designation }}</span>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        <a href="mailto:{{ $employee->personal_email }}" class="text-decoration-none">
                                            {{ $employee->personal_email }}
                                        </a>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        <a href="tel:{{ $employee->personal_mobile }}" class="text-decoration-none">
                                            {{ $employee->personal_mobile }}
                                        </a>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        {{ $employee->date_of_joining->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $employee->getStatusBadgeClass() }}">
                                            {{ $employee->getStatusDisplayText() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('hr.employees.show', $employee) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('hr.employees.edit', $employee) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('hr.employees.toggle-status', $employee->id) }}" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $employee->isActive() ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                                        title="{{ $employee->isActive() ? 'Deactivate' : 'Activate' }}"
                                                        onclick="return confirm('Are you sure you want to {{ $employee->isActive() ? 'deactivate' : 'activate' }} this employee?')">
                                                    <i class="fas {{ $employee->isActive() ? 'fa-user-times' : 'fa-user-check' }}"></i>
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
                    {{ $employees->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No employees found</h5>
                    <p class="text-muted">Start by registering a new employee.</p>
                    <a href="{{ route('hr.employee-registration') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i>
                        Register First Employee
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection