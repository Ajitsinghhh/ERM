@extends('layouts.dashboard')

@section('page-title', 'Task Management')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Task Management</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            Add New Task
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

    <!-- Task Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Tasks
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['completed'] }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['overdue'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Tasks Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-tasks me-2"></i>
                Tasks List
            </h6>
        </div>
        <div class="card-body">
            @if($tasks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th class="d-none d-md-table-cell">Priority</th>
                                <th>Status</th>
                                <th class="d-none d-lg-table-cell">Due Date</th>
                                <th class="d-none d-xl-table-cell">Created By</th>
                                <th class="d-none d-xl-table-cell">Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $task->title }}</strong>
                                            @if($task->isOverdue())
                                                <span class="badge bg-danger ms-2">Overdue</span>
                                            @elseif($task->isDueToday())
                                                <span class="badge bg-warning ms-2">Due Today</span>
                                            @endif
                                            @if($task->description)
                                                <br><small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                            @endif
                                            <br><small class="text-muted d-md-none">
                                                <span class="badge {{ $task->getPriorityBadgeClass() }} me-1">
                                                    {{ $task->getPriorityDisplayName() }}
                                                </span>
                                            </small>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="badge {{ $task->getPriorityBadgeClass() }}">
                                            {{ $task->getPriorityDisplayName() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $task->getStatusBadgeClass() }}">
                                            {{ $task->getStatusDisplayName() }}
                                        </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if($task->due_date)
                                            {{ $task->due_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">No due date</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-xl-table-cell">{{ $task->creator->name }}</td>
                                    <td class="d-none d-xl-table-cell">{{ $task->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('tasks.show', $task) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger delete-task" 
                                                    data-task-id="{{ $task->id }}" 
                                                    data-task-title="{{ $task->title }}" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($tasks->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $tasks->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-4">
                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No tasks found</h5>
                    <p class="text-muted">Start by creating your first task.</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Create Task
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete task confirmation
    document.querySelectorAll('.delete-task').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const taskTitle = this.getAttribute('data-task-title');
            
            if (confirm(`Are you sure you want to delete the task "${taskTitle}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tasks/${taskId}`;
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                const tokenField = document.createElement('input');
                tokenField.type = 'hidden';
                tokenField.name = '_token';
                tokenField.value = '{{ csrf_token() }}';
                
                form.appendChild(methodField);
                form.appendChild(tokenField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
</script>
@endsection
