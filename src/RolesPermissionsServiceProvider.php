<?php

namespace Commacodes\RolesPermissions;

use Illuminate\Support\ServiceProvider;

class RolesPermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/global.php' => config_path('global.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/global.php', 'global');
    }
}
