<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;

middleware('auth');

name('app.links.analytics');

render(function ($shortLink) {
    if (! auth()->user()->can('view', $shortLink)) {
        abort(403);
    }
});

?>

<x-app-layout>
    <div>
        <x-app.navigation />

        <x-main>
            <x-section>
                <x-container>
                    <x-page-header>
                        <x-back href="{{ route('app.dashboard') }}" />
                        <x-page-header.content>
                            <x-page-header.text>
                                <x-h1>Analíticas</x-h1>
                            </x-page-header.text>
                        </x-page-header.content>
                    </x-page-header>
                </x-container>
            </x-section>

            <x-section>
                <x-container>
                    <div class="w-full flex flex-col gap-8">
                        <livewire:links.analytics.index.chart :$shortLink />
                        <div class="grid grid-cols-2 gap-6">
                            <livewire:links.analytics.index.countries-table :$shortLink />
                            <livewire:links.analytics.index.devices-table :$shortLink />
                            <livewire:links.analytics.index.referers-table :$shortLink />
                        </div>
                    </div>
                </x-container>
            </x-section>
        </x-main>
    </div>
</x-app-layout>
