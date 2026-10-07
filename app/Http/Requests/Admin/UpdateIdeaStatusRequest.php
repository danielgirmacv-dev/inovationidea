<?php

namespace App\Http\Requests\Admin;

use App\Models\IdeaSubmission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIdeaStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isReviewer() ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(array_keys(IdeaSubmission::STATUSES))],
            'remarks' => [
                Rule::when(
                    in_array($this->input('status'), ['Rejected', 'Need More Information']),
                    ['required', 'string', 'min:10'],
                    ['nullable', 'string']
                ),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'A status must be selected.',
            'status.in' => 'The selected status is invalid.',
            'remarks.required' => 'A remark is required when rejecting or requesting more information.',
            'remarks.min' => 'Remarks must be at least 10 characters.',
        ];
    }
}
