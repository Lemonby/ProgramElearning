<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'file_submission' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:25600',
            'link_submission' => 'nullable|url',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'file_submission.file' => 'File harus berupa file yang valid.',
            'file_submission.mimes' => 'File hanya boleh berupa: pdf, doc, docx, ppt, pptx, xls, xlsx, zip, rar.',
            'file_submission.max' => 'Ukuran file tidak boleh lebih dari 25 MB.',
            'link_submission.url' => 'Link harus berupa URL yang valid.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (empty($this->get('link_submission'))) {
            $this->merge(['link_submission' => null]);
        }
    }
}
