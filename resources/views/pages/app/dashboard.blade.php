<?php

use App\HashIdGenerator;
use App\Models\ShortLink;
use App\Livewire\App\Links\Index\Sortable;
use Illuminate\Support\Facades\Auth;

use function Laravel\Folio\name;
use function Livewire\Volt\uses;
use function Livewire\Volt\with;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Laravel\Folio\middleware;
use function Livewire\Volt\usesPagination;

usesPagination();

uses(Sortable::class);

name('app.dashboard');

middleware(['auth']);

with(function () {
    $query = Auth::user()->currentTeam->links();

    $query = $this->applySorting($query);

    $shortLinks = $query->paginate(5);

    return [
        'shortLinks' => $shortLinks,
    ];
});

?>

<x-layouts.app>
    @volt('pages.app.dashboard')
        <div>
            <x-app.navigation />

            <x-main>
                <x-section>
                    <x-container>
                        <x-page-header>
                            <x-page-header.content>
                                <x-page-header.text>
                                    <x-h1>Enlaces</x-h1>
                                </x-page-header.text>
                                <x-page-header.actions>
                                    <x-button href="/app/links/create">Crear enlace</x-button>
                                </x-page-header.actions>
                            </x-page-header.content>
                        </x-page-header>
                    </x-container>
                </x-section>

                <x-section>
                    <x-container>
                        <x-app.links.index.table :$shortLinks :$sortCol :$sortAsc />
                    </x-container>
                </x-section>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
