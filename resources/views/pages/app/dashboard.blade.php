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
                                    <x-button href="{{ route('app.links.create') }}">Crear enlace</x-button>
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
