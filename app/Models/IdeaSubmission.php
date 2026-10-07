<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdeaSubmission extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_SUBMITTED = 'Submitted';

    public const STATUS_UNDER_REVIEW = 'Under Review';

    public const STATUS_NEED_MORE_INFO = 'Need More Information';

    public const STATUS_APPROVED = 'Approved';

    public const STATUS_REJECTED = 'Rejected';

    public const STATUS_IMPLEMENTED = 'Implemented';

    public const STATUSES = [
        self::STATUS_SUBMITTED => ['label' => 'Submitted',              'color' => 'blue'],
        self::STATUS_UNDER_REVIEW => ['label' => 'Under Review',           'color' => 'yellow'],
        self::STATUS_NEED_MORE_INFO => ['label' => 'Need More Information',  'color' => 'orange'],
        self::STATUS_APPROVED => ['label' => 'Approved',               'color' => 'green'],
        self::STATUS_REJECTED => ['label' => 'Rejected',               'color' => 'red'],
        self::STATUS_IMPLEMENTED => ['label' => 'Implemented',            'color' => 'teal'],
    ];

    protected $fillable = [
        'reference_number',
        'user_id',
        'assigned_reviewer_id',
        'submitter_name',
        'submitter_job_title',
        'submitter_department',
        'submitter_site',
        'submitter_email',
        'submitter_phone',
        'title',
        'description',
        'problem_addressed',
        'company_benefits',
        'risks_challenges',
        'supporting_links',
        'submission_date',
        'status',
        'rejection_reason',
        'approval_notes',
        'reviewer_notes',
    ];

    protected function casts(): array
    {
        return [
            'supporting_links' => 'array',
            'submission_date' => 'date',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedReviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_reviewer_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            IdeaCategory::class,
            'idea_submission_categories',
            'idea_submission_id',
            'idea_category_id'
        )->withPivot('custom_value')->withTimestamps();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(IdeaAttachment::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(IdeaComment::class)->latest();
    }

    public function publicComments(): HasMany
    {
        return $this->hasMany(IdeaComment::class)->where('is_internal', false)->latest();
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(IdeaStatusHistory::class)->latest();
    }

    // Scopes
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDepartment($query, string $department)
    {
        return $query->where('submitter_department', $department);
    }

    public function scopeBySite($query, string $site)
    {
        return $query->where('submitter_site', $site);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('reference_number', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('submitter_name', 'like', "%{$search}%")
                ->orWhere('submitter_email', 'like', "%{$search}%");
        });
    }

    // Helpers
    public function getStatusColorAttribute(): string
    {
        return self::STATUSES[$this->status]['color'] ?? 'gray';
    }

    public function isEditable(): bool
    {
        return $this->status === 'Submitted';
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $transitions = [
            'Submitted' => ['Under Review', 'Rejected'],
            'Under Review' => ['Need More Information', 'Approved', 'Rejected'],
            'Need More Information' => ['Under Review', 'Rejected'],
            'Approved' => ['Implemented', 'Rejected'],
            'Rejected' => [],
            'Implemented' => ['Under Review'],
        ];

        return in_array($newStatus, $transitions[$this->status] ?? []);
    }
}
