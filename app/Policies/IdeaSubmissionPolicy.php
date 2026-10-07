<?php

namespace App\Policies;

use App\Models\IdeaSubmission;
use App\Models\User;

class IdeaSubmissionPolicy
{
    /**
     * Only authenticated reviewers/admins can list all submissions.
     */
    public function viewAny(User $user): bool
    {
        return $user->isReviewer();
    }

    /**
     * Anyone can view a single submission (with valid reference, no auth needed
     * for public tracking; this policy is for the admin view).
     */
    public function view(User $user, IdeaSubmission $submission): bool
    {
        return $user->isReviewer()
            || $user->id === $submission->user_id;
    }

    /**
     * Admins and reviewers can update status.
     */
    public function updateStatus(User $user, IdeaSubmission $submission): bool
    {
        return $user->isReviewer();
    }

    /**
     * Only admins can assign reviewers.
     */
    public function assignReviewer(User $user, IdeaSubmission $submission): bool
    {
        return $user->isAdmin();
    }

    /**
     * Reviewers and admins can add comments.
     */
    public function addComment(User $user, IdeaSubmission $submission): bool
    {
        return $user->isReviewer();
    }

    /**
     * Only admins can delete submissions.
     */
    public function delete(User $user, IdeaSubmission $submission): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only admins can export.
     */
    public function export(User $user): bool
    {
        return $user->isAdmin();
    }
}
