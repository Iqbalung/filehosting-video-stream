<?php

namespace App\Providers;

use App\Models\StorageServer;
use Illuminate\Support\ServiceProvider;

class StorageServerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return  $this->app['config']["filesystems.disks.local"];
    }
}
