<?php

use App\HashIdGenerator;
use App\Models\ShortLink;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

$getShortLinks = fn () => $this->shortLinks = Auth::user()->currentTeam->links()->latest()->get();

name('app.dashboard');

middleware(['auth']);

state([
    'shortLinks' => $getShortLinks,
]);

?>

<x-app-layout>
    @volt('pages.app.dashboard')
        <div>
            <x-app.navigation />

            <x-main>
                <x-section>
                    <x-container>
                        <x-page-heading>
                            <x-h1>Enlaces</x-h1>
                            <x-slot name="action">
                                <x-button href="/app/links/create">Crear enlace</x-button>
                            </x-slot>
                        </x-page-heading>
                    </x-container>
                </x-section>

                <x-section>
                    <x-container>
                        <x-app.links.index.table :$shortLinks />
                    </x-container>
                </x-section>
            </x-main>
        </div>
    @endvolt
</x-app-layout>
