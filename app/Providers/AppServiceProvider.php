<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootStringDomainMacro();
    }

    private function bootStringDomainMacro()
    {
        Str::macro('domain', function ($url) {
            if (empty($url)) {
                return '';
            }

            $validator = Validator::make(['url' => $url], [
                'url' => 'url'
            ]);

            if ($validator->passes()) {
                $hostname = parse_url($url, PHP_URL_HOST);

                return preg_replace('/^www\./', '', $hostname);
            }

            if (strpos($url, '.') !== false && strpos($url, ' ') === false) {
                $hostname = parse_url('https://' . $url, PHP_URL_HOST);

                return preg_replace('/^www\./', '', $hostname);
            }

            return '';
        });

        Stringable::macro('domain', function () {
            return new Stringable (Str::domain($this->value));
        });
    }
}
