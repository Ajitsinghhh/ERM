@extends('layouts.dashboard')

@section('page-title', 'Edit Task')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Task Management</a></li>
    <li class="breadcrumb-item active">Edit Task</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Tasks
        </a>
        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-1"></i>
            View Task
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Task Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $task->title) }}" 
                                       placeholder="Enter task title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    @foreach($priorities as $key => $label)
                                        <option value="{{ $key }}" {{ old('priority', $task->priority) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    @foreach($statuses as $key => $label)
                                        <option value="{{ $key }}" {{ old('status', $task->status) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Enter task description">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Enter any additional notes">{{ old('notes', $task->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        Task Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">
                            <i class="fas fa-user me-2"></i>
                            Created By
                        </h6>
                        <p class="text-muted small">{{ $task->creator->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-info">
                            <i class="fas fa-calendar me-2"></i>
                            Created At
                        </h6>
                        <p class="text-muted small">{{ $task->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-warning">
                            <i class="fas fa-clock me-2"></i>
                            Last Updated
                        </h6>
                        <p class="text-muted small">{{ $task->updated_at->format('M d, Y H:i') }}</p>
                    </div>

                    @if($task->completed_at)
                        <div class="mb-3">
                            <h6 class="text-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Completed At
                            </h6>
                            <p class="text-muted small">{{ $task->completed_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-lightbulb me-2"></i>
                        Status Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-warning">
                            <i class="fas fa-clock me-2"></i>
                            Pending
                        </h6>
                        <p class="text-muted small">
                            Task is created but not yet started.
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-primary">
                            <i class="fas fa-play me-2"></i>
                            In Progress
                        </h6>
                        <p class="text-muted small">
                            Task is currently being worked on.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-success">
                            <i class="fas fa-check me-2"></i>
                            Completed
                        </h6>
                        <p class="text-muted small">
                            Task has been finished successfully.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-danger">
                            <i class="fas fa-times me-2"></i>
                            Cancelled
                        </h6>
                        <p class="text-muted small">
                            Task has been cancelled and will not be completed.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
