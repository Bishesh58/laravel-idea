<?php

namespace App\Http\Requests;

use App\IdeaStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreideaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::enum(IdeaStatus::class)],
            'links' => ['nullable', 'array', 'max:3'],
            'links.*' => ['nullable', 'url', 'max:2048', 'distinct'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title for your idea.',
            'status.required' => 'Please select a status.',
            'links.*.url' => 'Each link must be a valid URL.',
            'image.image' => 'The uploaded file must be an image.',
            'image.max' => 'The image must not be larger than 2MB.',
        ];
    }
}
