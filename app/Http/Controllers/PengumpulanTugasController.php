<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengumpulanTugasRequest;
use App\Services\PengumpulanTugasService;

class PengumpulanTugasController extends Controller
{
    private PengumpulanTugasService $tugasService;

    public function __construct(PengumpulanTugasService $tugasService)
    {
        $this->tugasService = $tugasService;
    }

    /**
     * Show form pengumpulan tugas
     */
    public function index()
    {
        return view('pengumpulan-tugas');
    }

    /**
     * Simpan tugas ke database
     * 
     * @param StorePengumpulanTugasRequest $request (validasi otomatis)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function simpanTugas(StorePengumpulanTugasRequest $request)
    {
        try {
            // Service handle semua logic: file upload + simpan db + trigger event
            $submission = $this->tugasService->simpanTugas(
                assignmentId: $request->input('assignmentId'),
                memberId: $request->input('memberId'),
                fileTugas: $request->file('fileTugas'),
                linkTugas: $request->input('linkTugas'),
                judulTugas: $request->input('judulTugas'),
                namaSiswa: $request->input('namaSiswa'),
            );
            // Email otomatis terkirim via Event & Listener (TugasSubmitted -> SendTugasNotification)

            return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan tugas: ' . $e->getMessage());
        }
    }
}
