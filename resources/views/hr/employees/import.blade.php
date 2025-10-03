@extends('layouts.hr')

@section('page-title', 'Import Employees')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('hr.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('hr.employees.index') }}">Employee Management</a></li>
    <li class="breadcrumb-item active">Import Employees</li>
@endsection

@section('page-actions')
    <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Back to Employees
    </a>
    <a href="{{ route('hr.employees.template') }}" class="btn btn-success">
        <i class="fas fa-download me-1"></i>
        Download Template
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Import Success</strong>
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
                    <strong>Import Error</strong>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
            <div class="card-body">
                <div class="card-text mb-0" style="white-space: pre-line; font-family: monospace;">{!! nl2br(e(session('error'))) !!}</div>
            </div>
        </div>
    @endif

    @if(session('errors'))
        <div class="card border-warning mb-4">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Import Warnings</strong>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <div class="card-body">
                <p class="card-text mb-3"><strong>Import completed with errors:</strong></p>
                <ul class="mb-0">
                    @foreach(session('errors') as $error)
                        <li class="mb-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-import me-2"></i>
                        Import Employees from CSV
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>CSV Import Form</strong> - Please select a CSV file to import employee data.
                    </div>
                    
                    <form action="{{ route('hr.employees.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="csv_file" class="form-label fw-bold">
                                <i class="fas fa-file-csv me-2 text-primary"></i>
                                Select CSV File
                            </label>
                            <input type="file" 
                                   class="form-control @error('csv_file') is-invalid @enderror" 
                                   id="csv_file" 
                                   name="csv_file" 
                                   accept=".csv,.txt"
                                   required
                                   style="border: 2px dashed #007bff; padding: 20px; text-align: center;">
                            @error('csv_file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Maximum file size: 10MB. Supported formats: CSV, TXT
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i>
                                Import Employees
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Import Instructions
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="text-primary mb-3">CSV Format Requirements:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            First row must contain headers
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Use comma (,) as delimiter
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Enclose text fields in quotes if they contain commas
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Date format: YYYY-MM-DD
                        </li>
                    </ul>

                    <h6 class="text-primary mb-3 mt-4">Required Fields:</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1">• Full Name</li>
                        <li class="mb-1">• Email Address</li>
                        <li class="mb-1">• Mobile Number</li>
                        <li class="mb-1">• Gender (male/female/other)</li>
                        <li class="mb-1">• Date of Birth</li>
                        <li class="mb-1">• Designation</li>
                    </ul>

                    <div class="alert alert-info mt-3">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tip:</strong> Download the template CSV file to see the exact format required.
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Important Notes
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                            Duplicate email addresses will be skipped
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                            All imported employees will have default password: <code>password123</code>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                            Missing required fields will cause row to be skipped
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                            Default values will be used for optional fields
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
