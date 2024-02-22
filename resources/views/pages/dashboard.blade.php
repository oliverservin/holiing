<?php

use App\HashIdGenerator;
use App\Livewire\ShortLinks\Index\Archivable;
use App\Livewire\ShortLinks\Index\Searchable;
use App\Livewire\ShortLinks\Index\Sortable;
use App\Models\ShortLink;
use Illuminate\Support\Facades\Auth;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;
use function Livewire\Volt\usesPagination;
use function Livewire\Volt\with;

usesPagination();

uses([Searchable::class, Sortable::class, Archivable::class]);

name('dashboard');

middleware(['auth']);

$delete = function (ShortLink $shorLink) {
    $this->authorize('delete', $shorLink);

    $shorLink->delete();
};

with(function () {
    $query = Auth::user()->currentTeam->links();

    $query = $this->applySearch($query);

    $query = $this->applySorting($query);

    $query = $this->applyArchive($query);

    $shortLinks = $query->paginate(5);

    return [
        'shortLinks' => $shortLinks,
    ];
});

?>

<x-layouts.app>
    @volt('app.dashboard')
        <div>
            <x-settings.header />

            <x-main>
                <x-container>
                    <x-section>
                        <div class="flex justify-between">
                            <div class="space-y-0.5">
                                <x-heading.h1>Enlaces</x-heading.h1>
                                <x-text.lead>Gestiona y configura tus enlaces cortos.</x-text.lead>
                            </div>
                            <div>
                                <x-button href="{{ route('short-links.create') }}">Crear enlace</x-button>
                            </div>
                        </div>

                        <x-separator />

                        <x-short-links.index.table :$shortLinks :$sortCol :$sortAsc />
                    </x-section>
                </x-container>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
