<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'employee_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is HR Manager
     */
    public function isHRManager(): bool
    {
        return $this->employee_role === 'hr_manager';
    }

    /**
     * Check if user is Employee
     */
    public function isEmployee(): bool
    {
        return $this->employee_role === 'employee';
    }

    /**
     * Get employee role display name
     */
    public function getEmployeeRoleDisplayName(): string
    {
        return match($this->employee_role) {
            'hr_manager' => 'HR Manager',
            'employee' => 'Employee',
            default => 'N/A'
        };
    }

    /**
     * Get the employee record associated with the user
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}
