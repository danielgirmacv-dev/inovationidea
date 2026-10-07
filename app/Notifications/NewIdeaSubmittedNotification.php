<?php

namespace App\Notifications;

use App\Models\IdeaSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewIdeaSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly IdeaSubmission $submission) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Idea Submission: {$this->submission->reference_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line('A new innovative idea has been submitted and awaits your review.')
            ->line("**Reference:** {$this->submission->reference_number}")
            ->line("**Title:** {$this->submission->title}")
            ->line("**Submitted by:** {$this->submission->submitter_name} ({$this->submission->submitter_department})")
            ->action('Review Idea', route('admin.submissions.show', $this->submission))
            ->line('Thank you for helping drive innovation at EEC.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_submission',
            'submission_id' => $this->submission->id,
            'reference_number' => $this->submission->reference_number,
            'title' => $this->submission->title,
            'submitter_name' => $this->submission->submitter_name,
            'department' => $this->submission->submitter_department,
        ];
    }
}
