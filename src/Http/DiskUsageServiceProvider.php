<?php

namespace Donald1597\DiskUsage\Http;

use Illuminate\Support\ServiceProvider;

class DiskUsageServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/disk-usage.php' => config_path('disk-usage.php'),
            ], 'config');
        }
    }

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'disk-usage');

        $this->publishes([
            __DIR__ . '/../config/disk-usage.php' => config_path('disk-usage.php'),
        ]);
    }
}
