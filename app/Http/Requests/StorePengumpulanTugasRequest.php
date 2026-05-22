<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengumpulanTugasRequest extends FormRequest
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
            // Data tugas
            'assignmentId' => 'required|integer|exists:assignments,id',
            'memberId' => 'required|integer|exists:users,id',
            'judulTugas' => 'required|string|max:255',
            'namaSiswa' => 'required|string|max:255',
            
            // File atau Link
            'fileTugas' => 'nullable|required_without:linkTugas|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:25600',
            'linkTugas' => 'nullable|required_without:fileTugas|url',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            // Assignment & Member
            'assignmentId.required' => 'ID tugas harus diisi.',
            'assignmentId.integer' => 'ID tugas harus berupa angka.',
            'assignmentId.exists' => 'Tugas tidak ditemukan.',
            'memberId.required' => 'ID anggota harus diisi.',
            'memberId.integer' => 'ID anggota harus berupa angka.',
            'memberId.exists' => 'Anggota tidak ditemukan.',
            'judulTugas.required' => 'Judul tugas harus diisi.',
            'judulTugas.string' => 'Judul tugas harus berupa teks.',
            'judulTugas.max' => 'Judul tugas tidak boleh lebih dari 255 karakter.',
            'namaSiswa.required' => 'Nama siswa harus diisi.',
            'namaSiswa.string' => 'Nama siswa harus berupa teks.',
            'namaSiswa.max' => 'Nama siswa tidak boleh lebih dari 255 karakter.',
            
            // File atau Link
            'fileTugas.required_without' => 'File atau link harus diisi salah satu.',
            'fileTugas.file' => 'Yang diunggah harus berupa file.',
            'fileTugas.mimes' => 'Format file harus PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, atau RAR.',
            'fileTugas.max' => 'Ukuran file tidak boleh lebih dari 25MB.',
            'linkTugas.required_without' => 'File atau link harus diisi salah satu.',
            'linkTugas.url' => 'Link tugas harus berupa URL yang valid.',
        ];
    }
}
