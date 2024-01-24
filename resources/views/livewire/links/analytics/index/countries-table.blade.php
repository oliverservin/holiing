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
    <table class="min-w-full table-fixed divide-y divide-zinc-300 text-zinc-800">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold text-zinc-500">
                    <div class="whitespace-nowrap">País</div>
                </th>

                <th class="px-4 py-2 text-right text-sm font-semibold text-zinc-500">
                    <div>Clics</div>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-200 bg-white text-zinc-900">
            @foreach ($dataset as $set)
                <tr wire:key="{{ $set->id }}">
                    <td class="whitespace-nowrap p-4 text-sm">
                        <div class="flex gap-1">
                            {{ $set->country }}
                        </div>
                    </td>

                    <td class="w-auto whitespace-nowrap p-4 text-sm text-zinc-800 font-semibold text-right">
                        {{ $set->total }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
