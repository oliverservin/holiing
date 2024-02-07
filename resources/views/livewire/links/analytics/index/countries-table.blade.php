<?php

use function Livewire\Volt\state;
use function Livewire\Volt\with;

use Illuminate\Support\Facades\DB;

state(['dataset' => [], 'shortLink' => fn () => $shortLink]);

$fillDataset = function () {
    $results = $this->shortLink->clickEvents()
        ->select('country', DB::raw('COUNT(*) as total'))
        ->groupBy('country')
        ->orderBy('total', 'desc')
        ->take(5)
        ->get();

    $this->dataset = $results;
};

with(function () {
    $this->fillDataset();

    return [];
});

?>

<div>
    <x-table>
        <x-table.head>
            <x-table.row>
                <x-table.header>País</x-table.header>
                <x-table.header class="text-right">Clics</x-table.header>
            </x-table.row>
        </x-table.head>

        <x-table.body>
            @foreach ($dataset as $set)
                <x-table.row wire:key="{{ $set->id }}">
                    <x-table.cell>
                        {{ $set->country->label() }}
                    </x-table.cell>

                    <x-table.cell class="text-right">
                        {{ $set->total }}
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.body>
    </x-table>
</div>
