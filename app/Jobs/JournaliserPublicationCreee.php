<?php

namespace App\Jobs;

use App\Models\Publication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class JournaliserPublicationCreee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $publicationId)
    {
    }

    public function handle(): void
    {
        $publication = Publication::find($this->publicationId);

        if ($publication) {
            Log::info('Publication créée', [
                'id' => $publication->id,
                'titre' => $publication->titre,
            ]);
        }
    }
}