<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class FolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Folio::domain('links.'.config('app.url'))->path(resource_path('views/pages/links'))->middleware([
            '*' => [
                //
            ],
        ]);

        Folio::domain(config('app.url'))->path(resource_path('views/pages'))->middleware([
            '*' => [
                //
            ],
        ]);
    }
}
