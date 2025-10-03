<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'user_id', // Optional - only for employees with login accounts
        'status',
        'full_name',
        'gender',
        'date_of_birth',
        'blood_group',
        'marital_status',
        'nationality',
        'religion',
        'aadhaar_number',
        'aadhaar_card_front',
        'aadhaar_card_back',
        'passport_photo',
        'pan_card',
        'passport_number',
        'designation',
        'date_of_joining',
        'personal_mobile',
        'personal_email',
        'current_address',
        'permanent_address',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_relation',
        'emergency_contact_address',
        'terms_accepted',
        // New fields from CSV format
        'marriage_anniversary',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_joining' => 'date',
        'marriage_anniversary' => 'date',
        'terms_accepted' => 'boolean',
    ];

    /**
     * Get the user that owns the employee record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active employees
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for inactive employees
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Check if employee is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if employee is inactive
     */
    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    /**
     * Get status badge class for display
     */
    public function getStatusBadgeClass()
    {
        return $this->status === 'active' ? 'bg-success' : 'bg-secondary';
    }

    /**
     * Get status display text
     */
    public function getStatusDisplayText()
    {
        return $this->status === 'active' ? 'Active' : 'Inactive';
    }
}
