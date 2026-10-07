<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdeaComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'idea_submission_id',
        'user_id',
        'comment',
        'is_internal',
    ];

    protected function casts(): array
    {
        return [
            'is_internal' => 'boolean',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(IdeaSubmission::class, 'idea_submission_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
