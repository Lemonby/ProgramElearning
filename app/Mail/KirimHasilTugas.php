<?php

namespace App\Mail;

use App\Models\Assignments;
use App\Models\PengumpulanTugas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KirimHasilTugas extends Mailable
{
    use Queueable, SerializesModels;

    public Assignments $assignment;
    public PengumpulanTugas $submission;
    public string $namaSiswa;

    /**
     * Create a new message instance.
     */
    public function __construct(Assignments $assignment, PengumpulanTugas $submission, string $namaSiswa)
    {
        $this->assignment = $assignment;
        $this->submission = $submission;
        $this->namaSiswa = $namaSiswa;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengumpulan Tugas - ' . $this->assignment->title . ' Berhasil Diterima',
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
                'assignment' => $this->assignment,
                'submission' => $this->submission,
                'namaSiswa' => $this->namaSiswa,
                'judulTugas' => $this->assignment->title,
                'tanggalSubmit' => $this->submission->submitted_at->format('d M Y H:i'),
                'batasTugas' => $this->assignment->deadline->format('d M Y H:i'),
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
