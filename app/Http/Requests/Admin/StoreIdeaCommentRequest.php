<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdeaCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isReviewer() ?? false;
    }

    public function rules(): array
    {
        return [
            'comment' => ['required', 'string', 'min:3', 'max:2000'],
            'is_internal' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'Comment cannot be empty.',
            'comment.min' => 'Comment must be at least 3 characters.',
        ];
    }
}
