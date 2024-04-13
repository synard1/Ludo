<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use Modules\Communication\Services\TelegramService;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind('telegram', function ($app) {
            return new TelegramService($app->make(Client::class));
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
