<?php

use function Livewire\Volt\state;
use function Livewire\Volt\with;

use Illuminate\Support\Facades\DB;

state(['dataset' => [], 'shortLink' => fn () => $shortLink]);

$fillDataset = function () {
    $results = $this->shortLink->clickEvents()
        ->select('device', DB::raw('COUNT(*) as total'))
        ->groupBy('device')
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
    <table class="min-w-full table-fixed divide-y divide-gray-300 text-gray-800">
        <thead>
            <tr>
                <th class="p-3 text-left text-sm font-semibold text-gray-900">
                    <div class="whitespace-nowrap">Dispositivo</div>
                </th>

                <th class="p-3 text-right text-sm font-semibold text-gray-900">
                    <div>Clics</div>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white text-gray-700">
            @foreach ($dataset as $set)
                <tr wire:key="{{ $set->id }}">
                    <td class="whitespace-nowrap p-3 text-sm">
                        <div class="flex gap-1">
                            {{ $set->device }}
                        </div>
                    </td>

                    <td class="w-auto whitespace-nowrap p-3 text-sm text-gray-800 font-semibold text-right">
                        {{ $set->total }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
