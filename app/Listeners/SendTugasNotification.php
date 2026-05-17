<?php

namespace App\Listeners;

use App\Events\TugasSubmitted;
use App\Mail\KirimHasilTugas;
use Illuminate\Support\Facades\Mail;

class SendTugasNotification
{
    /**
     * Handle the event.
     */
    public function handle(TugasSubmitted $event): void
    {
        // Fetch assignment dari submission
        $assignment = $event->submission->assignment;
        
        // Kirim email dengan assignment dan submission
        Mail::to('magungsomomiharjo@gmail.com')->send(
            new KirimHasilTugas($assignment, $event->submission, $event->namaSiswa)
        );
    }
}