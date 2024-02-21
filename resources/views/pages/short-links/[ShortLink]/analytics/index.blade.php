<?php

use App\Livewire\App\Links\Analytics\Index\Filters;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Laravel\Folio\render;
use function Livewire\Volt\form;
use function Livewire\Volt\mount;
use function Livewire\Volt\state;

middleware('auth');

name('short-links.analytics');

state(['shortLink' => fn () => $shortLink]);

form(Filters::class, 'filters');

mount(function () {
    $this->filters->init($this->shortLink);
});

render(function ($shortLink) {
    if (! auth()->user()->can('view', $shortLink)) {
        abort(403);
    }
});

?>

<x-layouts.app>
    @volt('short-links.analytics')
        <div>
            <x-settings.header />

            <x-main>
                <x-container>
                    <x-section>
                        <div>
                            <x-link href="{{ route('dashboard') }}" class="text-sm text-zinc-950 dark:text-white">← Regresar</x-link>
                        </div>

                        <div class="space-y-0.5">
                            <x-heading.h1>Analíticas</x-heading.h1>
                            <x-text.lead>{{ $shortLink->domain->name.'/'.$shortLink->hashid }}</x-text.lead>
                        </div>

                        <x-separator />

                        <div class="flex w-full flex-col gap-8">
                            <x-short-links.analytics.index.filter-range :$filters />

                            <livewire:short-links.analytics.index.chart :$shortLink :$filters />

                            <div class="grid grid-cols-2 gap-6">
                                <livewire:short-links.analytics.index.countries-table :$shortLink :$filters />
                                <livewire:short-links.analytics.index.devices-table :$shortLink :$filters />
                                <livewire:short-links.analytics.index.browsers-table :$shortLink :$filters />
                                <livewire:short-links.analytics.index.referers-table :$shortLink :$filters />
                            </div>
                        </div>
                    </x-section>
                </x-container>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
