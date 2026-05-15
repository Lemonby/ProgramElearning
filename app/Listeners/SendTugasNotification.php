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
        Mail::to('magungsomomiharjo@gmail.com')->send(
            new KirimHasilTugas($event->judulTugas, $event->namaSiswa)
        );
    }
}