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

<x-layouts.app>
    <div>
        <x-app.settings.header />

        <x-app.main>
            <x-container>
                <x-app.section>
                    <div>
                        <x-app.back href="{{ route('app.dashboard') }}" />
                    </div>

                    <div class="space-y-0.5">
                        <x-heading.h1>Analíticas</x-heading.h1>
                        <x-text.lead>{{ $shortLink->domain->name . '/' . $shortLink->hashid }}</x-text.lead>
                    </div>

                    <x-divider />

                    <div class="w-full flex flex-col gap-8">
                        <livewire:links.analytics.index.chart :$shortLink />
                        <div class="grid grid-cols-2 gap-6">
                            <livewire:links.analytics.index.countries-table :$shortLink />
                            <livewire:links.analytics.index.devices-table :$shortLink />
                            <livewire:links.analytics.index.referers-table :$shortLink />
                        </div>
                    </div>
                </x-app.section>
            </x-container>
        </x-app.main>
    </div>
</x-layouts.app>
