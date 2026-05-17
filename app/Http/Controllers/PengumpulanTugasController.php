<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengumpulanTugasRequest;
use App\Models\Assignments;
use App\Services\PengumpulanTugasService;
use Illuminate\Support\Facades\Auth;

class PengumpulanTugasController extends Controller
{
    private PengumpulanTugasService $tugasService;

    public function __construct(PengumpulanTugasService $tugasService)
    {
        $this->tugasService = $tugasService;
    }

    /**
     * Show semua assignment dalam bentuk cards
     */
    public function show()
    {
        $assignments = Assignments::with('submissions')->get();
        return view('submissions.index', compact('assignments'));
    }

    /**
     * Show form pengumpulan tugas (legacy - untuk testing)
     */
    public function index()
    {
        return view('TestKirimEmail');
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
                memberId: Auth::id(), // Auto dari session user
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

    /**
     * Test kirim email pengumpulan tugas (legacy - untuk testing saja)
     * 
     * @param \Illuminate\Http\Request: dipake untuk ambil input dari form test (judulTugas, namaSiswa, fileTugas)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function kirimEmailPengumpulanTugas(\Illuminate\Http\Request $request)
    {
        try {
            $judulTugas = $request->input('judulTugas');
            $namaSiswa = $request->input('namaSiswa');
            $fileTugas = $request->file('fileTugas');

            // Validasi input
            if (!$judulTugas || !$namaSiswa || !$fileTugas) {
                return redirect()->back()->with('error', 'Judul tugas, nama siswa, dan file tugas harus diisi!');
            }

            // Dispatch event untuk kirim email
            \App\Events\TugasSubmitted::dispatch(
                $fileTugas->getClientOriginalName(), // bisa juga disimpan dulu lalu kirim path file
                $judulTugas,
                $namaSiswa,
            );

            return redirect()->back()->with('success', 'Email test berhasil dikirim ke ' . config('mail.from.address'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
