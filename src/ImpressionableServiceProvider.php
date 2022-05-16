<?php

namespace Jangaraev\LaravelImpressionable;

use Illuminate\Support\ServiceProvider;

class ImpressionableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../migrations' => base_path('database/migrations'),
            ], 'migrations');
        }
    }
}
