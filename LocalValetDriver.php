<?php

use Valet\Drivers\LaravelValetDriver;

class LocalValetDriver extends LaravelValetDriver
{
    public function beforeLoading(string $sitePath, string $siteName, string $uri): void
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }

        if ($siteName !== 'holiing') {
            $_SERVER['HTTP_LINKSPAGEHOST'] = $_SERVER['HTTP_HOST'];
            $_SERVER['HTTP_HOST'] = 'links.holiing.test';
        }
    }
}
