@extends('layouts.dashboard')

@section('page-title', 'Search Results')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}">HR Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search Results</li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-search me-2"></i>
            Search Results
        </h1>
    </div>

    @if($query)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Search results for: <strong>"{{ $query }}"</strong>
        </div>
    @endif

    @if(isset($results) && $query)
        <!-- Employees Results -->
        @if($results['employees']->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users me-2"></i>
                        Employees ({{ $results['employees']->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results['employees'] as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->full_name }}</td>
                                        <td>{{ $employee->personal_email }}</td>
                                        <td>{{ $employee->personal_mobile }}</td>
                                        <td>{{ $employee->designation }}</td>
                                        <td>
                                            <span class="badge {{ $employee->getStatusBadgeClass() }}">
                                                {{ $employee->getStatusDisplayText() }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('hr.employees.show', $employee->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tasks Results -->
        @if($results['tasks']->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tasks me-2"></i>
                        Tasks ({{ $results['tasks']->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results['tasks'] as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>
                                            <span class="badge {{ $task->getPriorityBadgeClass() }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $task->getStatusBadgeClass() }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($task->due_date)
                                                {{ $task->due_date->format('M d, Y') }}
                                                @if($task->isOverdue())
                                                    <span class="text-danger">(Overdue)</span>
                                                @endif
                                            @else
                                                <span class="text-muted">No due date</span>
                                            @endif
                                        </td>
                                        <td>{{ $task->creator->name ?? 'Unknown' }}</td>
                                        <td>
                                            <a href="{{ route('tasks.show', $task->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- No Results -->
        @if($results['employees']->count() == 0 && $results['tasks']->count() == 0)
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No results found</h4>
                    <p class="text-muted">Try searching with different keywords or check your spelling.</p>
                </div>
            </div>
        @endif
    @else
        <!-- No Search Query -->
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Search HR Data</h4>
                <p class="text-muted">Use the search box in the sidebar to find employees and tasks.</p>
            </div>
        </div>
    @endif
</div>
@endsection
