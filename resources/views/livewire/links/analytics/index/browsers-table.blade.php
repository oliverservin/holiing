<?php

use function Livewire\Volt\state;
use function Livewire\Volt\with;

use Illuminate\Support\Facades\DB;

state('shortLink');

state('filters')->reactive();

with(function () {
    $results = $this->shortLink->clickEvents()
        ->select('browser', DB::raw('COUNT(*) as total'))
        ->tap(function ($query) {
            $this->filters->apply($query);
        })
        ->groupBy('browser')
        ->orderBy('total', 'desc')
        ->paginate(5);

    return ['dataset' => $results];
});

?>

<div>

    <x-table>
        <x-table.head>
            <x-table.row>
                <x-table.header>Navegador</x-table.header>
                <x-table.header class="text-right">Clics</x-table.header>
            </x-table.row>
        </x-table.head>

        <x-table.body>
            @foreach ($dataset as $set)
                <x-table.row wire:key="{{ $set->id }}">
                    <x-table.cell>
                        {{ $set->browser }}
                    </x-table.cell>

                    <x-table.cell class="text-right">
                        {{ $set->total }}
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.body>
    </x-table>
</div>
