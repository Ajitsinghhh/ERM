@extends('layouts.dashboard')

@section('page-title', 'Create New Task')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Task Management</a></li>
    <li class="breadcrumb-item active">Create New Task</li>
@endsection

@section('page-actions')
    <div class="btn-group me-2">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Tasks
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus me-2"></i>
                        Task Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" 
                                       placeholder="Enter task title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    @foreach($priorities as $key => $label)
                                        <option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" name="due_date" value="{{ old('due_date') }}"
                                       min="{{ date('Y-m-d') }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Enter task description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Enter any additional notes">{{ old('notes') }}</textarea>
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
                                Create Task
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
                        Priority Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Urgent
                        </h6>
                        <p class="text-muted small">
                            Critical tasks that need immediate attention and should be completed as soon as possible.
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-warning">
                            <i class="fas fa-arrow-up me-2"></i>
                            High
                        </h6>
                        <p class="text-muted small">
                            Important tasks that should be prioritized and completed within a short timeframe.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-info">
                            <i class="fas fa-minus me-2"></i>
                            Medium
                        </h6>
                        <p class="text-muted small">
                            Standard priority tasks that should be completed in due course.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-secondary">
                            <i class="fas fa-arrow-down me-2"></i>
                            Low
                        </h6>
                        <p class="text-muted small">
                            Tasks that can be completed when time permits or when higher priority tasks are done.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
