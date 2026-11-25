<?php

namespace App\Listeners;

use App\Events\PublicationCreee;
use App\Jobs\JournaliserPublicationCreee;
use App\Notifications\NouvellePublication;

class MettreEnFileJournalPublication
{
    public function handle(PublicationCreee $event): void
    {
        JournaliserPublicationCreee::dispatch($event->publication->id);
        $event->publication->auteur?->notify(
            new NouvellePublication($event->publication)
        );
    }
}