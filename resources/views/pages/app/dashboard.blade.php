<?php

use App\HashIdGenerator;
use App\Models\ShortLink;
use function Laravel\Folio\name;
use function Livewire\Volt\uses;

use function Livewire\Volt\with;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\middleware;
use App\Livewire\App\Links\Index\Sortable;
use function Livewire\Volt\usesPagination;
use App\Livewire\App\Links\Index\Searchable;

usesPagination();

uses([Searchable::class, Sortable::class]);

name('app.dashboard');

middleware(['auth']);

$delete = function(ShortLink $shorLink)
{
    $this->authorize('delete', $shorLink);

    $shorLink->delete();
};

with(function () {
    $query = Auth::user()->currentTeam->links();

    $query = $this->applySearch($query);

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
            <x-app.settings.header />

            <x-app.main>
                <x-container>
                    <x-app.section>
                        <div class="flex justify-between">
                            <div class="space-y-0.5">
                                <x-heading.h1>Enlaces</x-heading.h1>
                                <x-text.lead>Gestiona y configura tus enlaces cortos.</x-text.lead>
                            </div>
                            <div>
                                <x-button size="sm" href="{{ route('app.links.create') }}">Crear enlace</x-button>
                            </div>
                        </div>

                        <x-divider />

                        <x-app.links.index.table :$shortLinks :$sortCol :$sortAsc />
                    </x-app.section>
                </x-container>
            </x-app.main>
        </div>
    @endvolt
</x-layouts.app>
