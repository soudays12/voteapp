<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\StatsService;

class StatsServiceProvider extends ServiceProvider
{
    /**
     * Enregistre le service dans le container
     */
    public function register(): void
    {
        $this->app->singleton(StatsService::class, function ($app) {
            return new StatsService();
        });

    }

    /**
     * Bootstrap des services (optionnel)
     */
    public function boot(): void
    {
        // Ici vous pouvez faire des initialisations si nécessaire
    }
}