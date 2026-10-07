<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'site',
        'phone',
        'job_title',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Roles
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isReviewer(): bool
    {
        return in_array($this->role, ['reviewer', 'admin']);
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    // Relationships
    public function submissions(): HasMany
    {
        return $this->hasMany(IdeaSubmission::class);
    }

    public function assignedIdeas(): HasMany
    {
        return $this->hasMany(IdeaSubmission::class, 'assigned_reviewer_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(IdeaComment::class);
    }

    public function statusChanges(): HasMany
    {
        return $this->hasMany(IdeaStatusHistory::class);
    }

    // Scopes
    public function scopeReviewers($query)
    {
        return $query->whereIn('role', ['reviewer', 'admin'])->where('is_active', true);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin')->where('is_active', true);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'reviewer' => 'Reviewer',
            default => 'Employee',
        };
    }
}
