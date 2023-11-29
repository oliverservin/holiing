<?php

use App\HashIdGenerator;
use App\Models\ShortLink;

use Illuminate\Support\Str;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

$getShortLinks = fn () => $this->shortLinks = ShortLink::latest()->get();

state([
    'url' => '',
    'shortLinks' => $getShortLinks,
]);

rules(['url' => 'required|string|max:255']);

$store = function (HashIdGenerator $hashIdGenerator) {
    $this->validate();

    ShortLink::create([
        'url' => $this->url,
        'hashid' => $hashIdGenerator->generate(),
    ]);

    $this->url = '';

    $this->getShortLinks();
}

?>

<x-app-layout>
    @volt
        <div class="py-2 px-5">
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

            <div class="mt-8">
                <h2>Enlaces cortos</h2>
                <ul>
                    @foreach ($shortLinks as $shortLink)
                        <li>
                            <a href="{{ url('/' . $shortLink->hashid) }}" class="underline">
                            {{ url('/' . $shortLink->hashid) }}</a> —> {{ $shortLink->url }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endvolt
</x-app-layout>
