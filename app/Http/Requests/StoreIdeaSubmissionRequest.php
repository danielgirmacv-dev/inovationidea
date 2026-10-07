<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdeaSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public form
    }

    public function rules(): array
    {
        return [
            // Step 1: Contact Information
            'submitter_name' => ['required', 'string', 'max:255'],
            'submitter_job_title' => ['nullable', 'string', 'max:255'],
            'submitter_department' => ['nullable', 'string', 'max:255'],
            'submitter_site' => ['nullable', 'string', 'max:255'],
            'submitter_email' => ['nullable', 'email', 'max:255'],
            'submitter_phone' => ['required', 'string', 'max:100'],

            // Step 2: Idea Description
            'title' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'min:50'],
            'categories' => ['required', 'array', 'min:1', 'max:3'],
            'categories.*' => ['integer', 'exists:idea_categories,id'],
            'custom_category' => ['nullable', 'string', 'max:255'],
            'problem_addressed' => ['required', 'string', 'min:30'],
            'company_benefits' => ['required', 'string', 'min:30'],
            'risks_challenges' => ['required', 'string', 'min:20'],
            'supporting_links' => ['nullable', 'string'],
            'submission_date' => ['required', 'date', 'before_or_equal:today'],

            // Attachments
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => [
                'file',
                'max:10240', // 10 MB
                'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,webp,zip',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'submitter_name.required' => 'Your full name is required.',
            'submitter_phone.required' => 'A phone number is required.',
            'title.required' => 'Your idea needs a title.',
            'description.required' => 'Please provide a brief description of your idea.',
            'description.min' => 'Description must be at least 50 characters.',
            'categories.required' => 'Please select at least one category.',
            'categories.max' => 'You may select a maximum of 3 categories.',
            'problem_addressed.required' => 'Please describe the problem your idea addresses.',
            'company_benefits.required' => 'Please explain how this idea will benefit EEC.',
            'risks_challenges.required' => 'Please outline any potential risks or challenges.',
            'submission_date.required' => 'Submission date is required.',
            'submission_date.before_or_equal' => 'Submission date cannot be in the future.',
            'attachments.*.max' => 'Each attachment must not exceed 10 MB.',
            'attachments.*.mimes' => 'Accepted file types: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, GIF, WEBP, ZIP.',
        ];
    }

    /**
     * Parse supporting links from newline/comma-separated string to array.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('supporting_links') && is_string($this->supporting_links)) {
            // Keep as-is; we'll process in service
        }
    }
}
