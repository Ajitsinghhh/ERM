<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = [
        'created_by',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'completed_at',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user who created the task
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope for overdue tasks
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now()->toDateString())
                    ->whereIn('status', ['pending', 'in_progress']);
    }

    /**
     * Scope for tasks due today
     */
    public function scopeDueToday($query)
    {
        return $query->where('due_date', now()->toDateString())
                    ->whereIn('status', ['pending', 'in_progress']);
    }

    /**
     * Scope for tasks due this week
     */
    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [
                        now()->startOfWeek()->toDateString(),
                        now()->endOfWeek()->toDateString()
                    ])
                    ->whereIn('status', ['pending', 'in_progress']);
    }

    /**
     * Get priority badge class
     */
    public function getPriorityBadgeClass()
    {
        return match($this->priority) {
            'urgent' => 'bg-danger',
            'high' => 'bg-warning',
            'medium' => 'bg-info',
            'low' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'completed' => 'bg-success',
            'in_progress' => 'bg-primary',
            'pending' => 'bg-warning',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayName()
    {
        return match($this->status) {
            'completed' => 'Completed',
            'in_progress' => 'In Progress',
            'pending' => 'Pending',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    /**
     * Get priority display name
     */
    public function getPriorityDisplayName()
    {
        return match($this->priority) {
            'urgent' => 'Urgent',
            'high' => 'High',
            'medium' => 'Medium',
            'low' => 'Low',
            default => 'Unknown'
        };
    }

    /**
     * Check if task is overdue
     */
    public function isOverdue()
    {
        return $this->due_date && 
               $this->due_date->isPast() && 
               !in_array($this->status, ['completed', 'cancelled']);
    }

    /**
     * Check if task is due today
     */
    public function isDueToday()
    {
        return $this->due_date && $this->due_date->isToday();
    }

    /**
     * Mark task as completed
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }

    /**
     * Mark task as in progress
     */
    public function markAsInProgress()
    {
        $this->update([
            'status' => 'in_progress',
            'completed_at' => null
        ]);
    }

    /**
     * Mark task as pending
     */
    public function markAsPending()
    {
        $this->update([
            'status' => 'pending',
            'completed_at' => null
        ]);
    }
}