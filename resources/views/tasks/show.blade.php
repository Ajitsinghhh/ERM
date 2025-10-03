@extends('layouts.dashboard')

@section('page-title', 'Task Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Task Management</a></li>
    <li class="breadcrumb-item active">Task Details</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Tasks
        </a>
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i>
            Edit Task
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tasks me-2"></i>
                        {{ $task->title }}
                    </h6>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary update-status" 
                                data-task-id="{{ $task->id }}" 
                                data-current-status="{{ $task->status }}">
                            <i class="fas fa-sync-alt"></i>
                            Update Status
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Priority</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $task->getPriorityBadgeClass() }}">
                                    {{ $task->getPriorityDisplayName() }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge {{ $task->getStatusBadgeClass() }}">
                                    {{ $task->getStatusDisplayName() }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Due Date</label>
                            <p class="form-control-plaintext">
                                @if($task->due_date)
                                    {{ $task->due_date->format('M d, Y') }}
                                    @if($task->isOverdue())
                                        <span class="badge bg-danger ms-2">Overdue</span>
                                    @elseif($task->isDueToday())
                                        <span class="badge bg-warning ms-2">Due Today</span>
                                    @endif
                                @else
                                    <span class="text-muted">No due date set</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Created By</label>
                            <p class="form-control-plaintext">{{ $task->creator->name }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Created At</label>
                            <p class="form-control-plaintext">{{ $task->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Last Updated</label>
                            <p class="form-control-plaintext">{{ $task->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    @if($task->completed_at)
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Completed At</label>
                                <p class="form-control-plaintext">{{ $task->completed_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($task->description)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <div class="form-control-plaintext bg-light p-3 rounded">
                                {{ $task->description }}
                            </div>
                        </div>
                    @endif

                    @if($task->notes)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Notes</label>
                            <div class="form-control-plaintext bg-light p-3 rounded">
                                {{ $task->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tools me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>
                            Edit Task
                        </a>
                        
                        <button class="btn btn-success update-status" 
                                data-task-id="{{ $task->id }}" 
                                data-current-status="{{ $task->status }}"
                                data-target-status="completed">
                            <i class="fas fa-check me-1"></i>
                            Mark as Completed
                        </button>
                        
                        @if($task->status === 'pending')
                            <button class="btn btn-info update-status" 
                                    data-task-id="{{ $task->id }}" 
                                    data-current-status="{{ $task->status }}"
                                    data-target-status="in_progress">
                                <i class="fas fa-play me-1"></i>
                                Start Task
                            </button>
                        @elseif($task->status === 'in_progress')
                            <button class="btn btn-warning update-status" 
                                    data-task-id="{{ $task->id }}" 
                                    data-current-status="{{ $task->status }}"
                                    data-target-status="pending">
                                <i class="fas fa-pause me-1"></i>
                                Mark as Pending
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Danger Zone
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Once you delete a task, there is no going back. Please be certain.
                    </p>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this task? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-1"></i>
                            Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update task status
    document.querySelectorAll('.update-status').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.getAttribute('data-task-id');
            const currentStatus = this.getAttribute('data-current-status');
            const targetStatus = this.getAttribute('data-target-status');
            
            let newStatus;
            
            if (targetStatus) {
                newStatus = targetStatus;
            } else {
                // Show status selection modal or dropdown
                const statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
                const statusLabels = {
                    'pending': 'Pending',
                    'in_progress': 'In Progress',
                    'completed': 'Completed',
                    'cancelled': 'Cancelled'
                };
                
                let statusOptions = '';
                statuses.forEach(status => {
                    if (status !== currentStatus) {
                        statusOptions += `<option value="${status}">${statusLabels[status]}</option>`;
                    }
                });
                
                const select = prompt(`Current status: ${statusLabels[currentStatus]}\n\nSelect new status:\n${statusOptions.replace(/<option value="([^"]+)">([^<]+)<\/option>/g, '$1 - $2')}`);
                
                if (select && statuses.includes(select)) {
                    newStatus = select;
                } else {
                    return;
                }
            }
            
            // Update status via AJAX
            fetch(`/tasks/${taskId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update task status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update task status');
            });
        });
    });
});
</script>
@endsection
