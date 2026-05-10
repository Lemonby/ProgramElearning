<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PengumpulanTugas;
use Illuminate\Support\Facades\Mail;


class PengumpulanTugasController extends Controller
{
    //
    public function kirimEmailPengumpulanTugas(Request $request)
    {
        /// Validasi input
        $request->validate([
            'judulTugas' => 'required|string|min:5',
            'namaSiswa' => 'required|string|min:3',
        ]);

        $judul = $request->input('judulTugas');
        $namaSiswa = $request->input('namaSiswa');

        // Untuk testing, kita masukkan email manual atau email kamu yang terdaftar
        $emailTujuan = "magungsomomiharjo@gmail.com"; 

        // Kirim Email
        Mail::to($emailTujuan)->send(new PengumpulanTugas($judul, $namaSiswa));

        return redirect()->back()->with('success', 'Email berhasil dikirim ke Mailtrap!');
    }
}
