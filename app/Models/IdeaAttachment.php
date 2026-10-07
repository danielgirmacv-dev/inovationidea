<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class IdeaAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'idea_submission_id',
        'original_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'disk',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(IdeaSubmission::class, 'idea_submission_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->file_path);
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes < 1024) {
            return "{$bytes} B";
        }
        if ($bytes < 1048576) {
            return round($bytes / 1024, 1).' KB';
        }

        return round($bytes / 1048576, 1).' MB';
    }

    public function getFileIconAttribute(): string
    {
        return match (strtolower($this->file_type ?? '')) {
            'pdf' => '📄',
            'doc', 'docx' => '📝',
            'xls', 'xlsx' => '📊',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => '🖼️',
            'zip', 'rar' => '🗜️',
            default => '📎',
        };
    }
}
