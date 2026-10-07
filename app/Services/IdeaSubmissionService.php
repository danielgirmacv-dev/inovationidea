<?php

namespace App\Services;

use App\Models\IdeaAttachment;
use App\Models\IdeaStatusHistory;
use App\Models\IdeaSubmission;
use App\Models\User;
use App\Notifications\NewIdeaSubmittedNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class IdeaSubmissionService
{
    /**
     * Generate the next unique reference number (EEC-IDEA-YEAR-XXXXX).
     * Uses a DB lock to avoid concurrent duplicates.
     */
    public function generateReferenceNumber(): string
    {
        return DB::transaction(function () {
            $year = now()->year;
            $prefix = "EEC-IDEA-{$year}-";

            $last = IdeaSubmission::withTrashed()
                ->where('reference_number', 'like', $prefix.'%')
                ->lockForUpdate()
                ->orderByDesc('id')
                ->first();

            $nextSeq = $last
                ? (int) substr($last->reference_number, strrpos($last->reference_number, '-') + 1) + 1
                : 1;

            return $prefix.str_pad($nextSeq, 5, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Create a new submission atomically:
     * - Generates reference number
     * - Creates submission record
     * - Syncs categories (max 3)
     * - Stores attachments
     * - Records initial status history
     * - Sends notifications
     */
    public function createSubmission(array $data, array $categoryIds, array $uploadedFiles = [], ?int $userId = null): IdeaSubmission
    {
        return DB::transaction(function () use ($data, $categoryIds, $uploadedFiles, $userId) {
            // Limit to 3 categories
            $categoryIds = array_slice($categoryIds, 0, 3);

            // Generate reference
            $data['reference_number'] = $this->generateReferenceNumber();
            $data['user_id'] = $userId;
            $data['status'] = 'Submitted';

            // Create submission
            $submission = IdeaSubmission::create($data);

            // Sync categories
            $syncData = [];
            foreach ($categoryIds as $catId) {
                $syncData[$catId] = ['custom_value' => $data['custom_category'] ?? null];
            }
            $submission->categories()->sync($syncData);

            // Store attachments
            foreach ($uploadedFiles as $file) {
                if ($file instanceof UploadedFile && $file->isValid()) {
                    $this->storeAttachment($submission, $file);
                }
            }

            // Record initial status history
            IdeaStatusHistory::create([
                'idea_submission_id' => $submission->id,
                'user_id' => $userId,
                'from_status' => null,
                'to_status' => 'Submitted',
                'remarks' => 'Idea submitted by '.$submission->submitter_name,
            ]);

            // Send notifications
            $this->sendNewSubmissionNotifications($submission);

            return $submission->load(['categories', 'attachments', 'statusHistory']);
        });
    }

    /**
     * Transition submission to a new status, log the change, and notify.
     */
    public function transitionStatus(IdeaSubmission $submission, string $newStatus, ?string $remarks = null, ?int $actorUserId = null): IdeaSubmission
    {
        if (! $submission->canTransitionTo($newStatus)) {
            throw new \InvalidArgumentException(
                "Cannot transition from '{$submission->status}' to '{$newStatus}'."
            );
        }

        return DB::transaction(function () use ($submission, $newStatus, $remarks, $actorUserId) {
            $oldStatus = $submission->status;

            $updateData = ['status' => $newStatus];
            if ($newStatus === IdeaSubmission::STATUS_REJECTED && $remarks) {
                $updateData['rejection_reason'] = $remarks;
            } elseif ($newStatus === IdeaSubmission::STATUS_APPROVED && $remarks) {
                $updateData['approval_notes'] = $remarks;
            } elseif ($remarks) {
                $updateData['reviewer_notes'] = $remarks;
            }

            $submission->update($updateData);

            IdeaStatusHistory::create([
                'idea_submission_id' => $submission->id,
                'user_id' => $actorUserId,
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'remarks' => $remarks,
            ]);

            return $submission->fresh(['categories', 'statusHistory']);
        });
    }

    /**
     * Assign a reviewer to a submission.
     */
    public function assignReviewer(IdeaSubmission $submission, int $reviewerId, ?int $actorUserId = null): IdeaSubmission
    {
        return DB::transaction(function () use ($submission, $reviewerId, $actorUserId) {
            $submission->update(['assigned_reviewer_id' => $reviewerId]);

            IdeaStatusHistory::create([
                'idea_submission_id' => $submission->id,
                'user_id' => $actorUserId,
                'from_status' => $submission->status,
                'to_status' => $submission->status,
                'remarks' => 'Reviewer assigned: '.User::find($reviewerId)?->name,
            ]);

            return $submission->fresh();
        });
    }

    /**
     * Store a single file attachment.
     */
    private function storeAttachment(IdeaSubmission $submission, UploadedFile $file): IdeaAttachment
    {
        $path = $file->store("idea-attachments/{$submission->reference_number}", 'local');
        $ext = strtolower($file->getClientOriginalExtension());

        return IdeaAttachment::create([
            'idea_submission_id' => $submission->id,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $ext,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'disk' => 'local',
        ]);
    }

    /**
     * Send notifications to admins and reviewers about a new submission.
     */
    private function sendNewSubmissionNotifications(IdeaSubmission $submission): void
    {
        try {
            $admins = User::admins()->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewIdeaSubmittedNotification($submission));
            }
        } catch (\Exception $e) {
            // Log but do not fail submission
            \Log::warning('Failed to send new idea notification: '.$e->getMessage());
        }
    }
}
