<?php

namespace App\Events;

use App\Models\PengumpulanTugas;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TugasSubmitted
{
    /*
    * The event instance.
    *
    * @return void
    */
    use Dispatchable, SerializesModels;

    public function __construct(
        public PengumpulanTugas $submission,
        public string $judulTugas,
        public string $namaSiswa,
    ) {
    }
}
