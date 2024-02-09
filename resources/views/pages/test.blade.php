<?php

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

$test = function () {
    $response = Http::get('https://livewire.laravel.com');

    $crawler = new Crawler($response->body());
    $titleTag = $crawler->filter('title')->first()->text();
    $title = $crawler->filter('meta[property="og:title"], meta[property="twitter:title"]')->first()->attr('content') ?? $titleTag;
    $description = $crawler->filter('meta[name="description"], meta[property="twitter:description"], meta[property="og:description"]')->first()->attr('content');
    $image = $crawler->filter('meta[property="og:image"], meta[property="twitter:image"]')->first()->attr('content');

    dd($title, $description, $image);
};

?>

<x-layouts.app>
    @volt('pages.app.dashboard')
        <x-app.main>
            <x-container>
                <x-app.section>
                    <form wire:submit="test">
                        <x-button>Enviar</x-button>
                    </form>
                </x-app.section>
            </x-container>
        </x-app.main>
    @endvolt
</x-layouts.app>
