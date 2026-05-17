<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
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
            // Info Assignment
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'deadline' => 'required|date|after_or_equal:today',
            'class_id' => 'required|integer|exists:classes,id',
            
            // File atau Link Materi
            'file_assignment' => 'nullable|required_without:link_assignment|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:102400',
            'link_assignment' => 'nullable|required_without:file_assignment|url',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul assignment harus diisi.',
            'title.string' => 'Judul assignment harus berupa teks.',
            'title.max' => 'Judul assignment tidak boleh lebih dari 255 karakter.',
            
            'description.required' => 'Deskripsi assignment harus diisi.',
            'description.string' => 'Deskripsi assignment harus berupa teks.',
            'description.max' => 'Deskripsi assignment tidak boleh lebih dari 5000 karakter.',
            
            'deadline.required' => 'Batas waktu assignment harus diisi.',
            'deadline.date' => 'Batas waktu assignment harus berupa tanggal yang valid.',
            'deadline.after_or_equal' => 'Batas waktu assignment tidak boleh lebih awal dari hari ini.',
            
            'class_id.required' => 'Kelas harus dipi lih.',
            'class_id.integer' => 'Kelas harus berupa angka.',
            'class_id.exists' => 'Kelas tidak ditemukan.',
            
            'file_assignment.required_without' => 'File atau link assignment harus diisi minimal salah satu.',
            'file_assignment.file' => 'File assignment harus berupa file yang valid.',
            'file_assignment.mimes' => 'File assignment hanya boleh format: pdf, doc, docx, ppt, pptx, xls, xlsx, zip, rar.',
            'file_assignment.max' => 'File assignment tidak boleh lebih dari 100MB.',
            
            'link_assignment.required_without' => 'File atau link assignment harus diisi minimal salah satu.',
            'link_assignment.url' => 'Link assignment harus berupa URL yang valid.',
        ];
    }
}
