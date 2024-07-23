<?php

namespace Donald1597\DiskUsage\Http;

use Illuminate\Support\ServiceProvider;

class DiskUsageServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register bindings if needed
    }

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'disk-usage');
    }
}
