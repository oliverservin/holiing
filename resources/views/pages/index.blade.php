<?php

use App\Models\ShortLink;

use Illuminate\Support\Str;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'url' => '',
]);

rules(['url' => 'required|string|max:255']);

$store = function () {
    $this->validate();

    ShortLink::create([
        'url' => $this->url,
        'hashid' => Str::random(5),
    ]);

    $this->url = '';
}

?>

<x-app-layout>
    <div class="py-2 px-5">
        @volt
            <form wire:submit="store">
                <h2 class="font-bold">Crear enlace</h2>

                <div class="space-y-2">
                    <label for="url">URL:</label>

                    <input
                        wire:model="url"
                        type="text"
                        id="url"
                        placeholder="https://"
                        required
                        autocomplete="off"
                    >

                    <button class="block border-2 p-1">Submit</button>
                </div>
            </form>
        @endvolt
    </div>
</x-app-layout>
