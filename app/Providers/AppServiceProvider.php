<?php

namespace App\Providers;

use App\Events\PublicationCreee;
use App\Listeners\MettreEnFileJournalPublication;
use App\Models\User;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('gerer-categories', function (User $utilisateur): bool {
            return $utilisateur->role === 'admin';
        });

        Event::listen(
            PublicationCreee::class,
            MettreEnFileJournalPublication::class
        );

        if (config('quality.log_queries')) {
            DB::listen(function (QueryExecuted $query): void {
                Log::debug('Diagnostic SQL', [
                    'sql' => $query->sql,
                    'duree_ms' => $query->time,
                ]);
            });
        }
    }
}