<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengumpulanTugas extends Mailable
{
    use Queueable, SerializesModels;

    public $namaTugas;
    public $namaSiswa;

    /**
     * Create a new message instance.
     */
    public function __construct($namaTugas, $namaSiswa, $pesan = null)
    {
        $this->namaTugas = $namaTugas;
        $this->namaSiswa = $namaSiswa;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengumpulan Tugas - ' . $this->namaTugas . ' Berhasil Terkirim !',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'PengumpulanTugas',
            with: [
                'namaTugas' => $this->namaTugas,
                'namaSiswa' => $this->namaSiswa,
                'pesan' => $this->pesan ?? 'Ini adalah email test untuk memastikan bahwa pengiriman email berfungsi dengan baik. Jika Anda menerima email ini, berarti konfigurasi email sudah benar.',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
