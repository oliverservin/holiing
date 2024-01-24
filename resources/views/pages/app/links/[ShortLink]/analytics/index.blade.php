<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\render;

middleware('auth');

render(function ($shortLink) {
    if (! auth()->user()->can('view', $shortLink)) {
        abort(403);
    }
});

?>

<x-layouts.minimal>
    <div class="w-full flex flex-col gap-8">
        <div class="gap-4 flex flex-col items-start justify-start sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-1">
                <h1 class="font-semibold text-3xl text-gray-800">Analíticas</h1>

                <p class="hidden sm:block text-sm text-gray-500">{{ $shortLink->url }}</p>
            </div>
        </div>

        <livewire:links.analytics.index.chart :$shortLink />

        <div class="grid grid-cols-2 gap-6">
            <livewire:links.analytics.index.countries-table :$shortLink />

            <livewire:links.analytics.index.devices-table :$shortLink />

            <livewire:links.analytics.index.referers-table :$shortLink />
        </div>
    </div>
</x-layouts.minimal>
