@props(['type' => 'success', 'title' => null, 'dismissible' => true])

@php
    $typeClasses = [
        'success' => 'border-success bg-success text-white',
        'error' => 'border-danger bg-danger text-white',
        'warning' => 'border-warning bg-warning text-dark',
        'info' => 'border-info bg-info text-white',
        'danger' => 'border-danger bg-danger text-white'
    ];
    
    $icons = [
        'success' => 'fas fa-check-circle',
        'error' => 'fas fa-exclamation-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'info' => 'fas fa-info-circle',
        'danger' => 'fas fa-exclamation-circle'
    ];
    
    $defaultTitles = [
        'success' => 'Success',
        'error' => 'Error',
        'warning' => 'Warning',
        'info' => 'Information',
        'danger' => 'Error'
    ];
    
    $cardClass = $typeClasses[$type] ?? $typeClasses['success'];
    $icon = $icons[$type] ?? $icons['success'];
    $title = $title ?? $defaultTitles[$type];
@endphp

<div class="card {{ $cardClass }} mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="{{ $icon }} me-2"></i>
            <strong>{{ $title }}</strong>
        </div>
        @if($dismissible)
            <button type="button" class="btn-close {{ $type === 'warning' ? '' : 'btn-close-white' }}" data-bs-dismiss="alert"></button>
        @endif
    </div>
    <div class="card-body">
        <div class="card-text">
            {{ $slot }}
        </div>
    </div>
</div>
