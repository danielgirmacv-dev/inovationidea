<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdeaStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'idea_status_history';

    protected $fillable = [
        'idea_submission_id',
        'user_id',
        'from_status',
        'to_status',
        'remarks',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(IdeaSubmission::class, 'idea_submission_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
