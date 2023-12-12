<?php

use App\HashIdGenerator;
use App\Models\ShortLink;

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
    <div class="w-full max-w-screen-sm mx-auto">
        <div class="px-8 pt-12 pb-24">
            @volt
                <div class="space-y-24">
                    <form wire:submit="store">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium" for="url">Acortar una URL larga</label>
                                <input
                                    wire:model="url"
                                    type="text"
                                    id="url"
                                    placeholder="https://"
                                    class="mt-1.5 w-full rounded-md text-sm py-2 px-3 border-zinc-200 shadow-sm"
                                    required
                                    autocomplete="off"
                                >
                                <p class="mt-2 text-[13px] text-zinc-500">
                                    Introduce aquí tu URL larga.
                                </p>
                            </div>

                            <button class="block w-full py-2 px-4 rounded-md bg-zinc-900 border border-zinc-500 text-sm text-zinc-50 font-medium">
                                Acortar URL
                            </button>
                        </div>
                    </form>

                    <div class="space-y-4">
                        @foreach ($shortLinks as $shortLink)
                            <div class="rounded-xl border border-zinc-200 p-6">
                                <h3 class="font-semibold">
                                    <a href="{{ url('/' . $shortLink->hashid) }}">{{ 'deviare.test/' . $shortLink->hashid }}</a>
                                </h3>
                                <p class="text-zinc-500 text-sm">{{ $shortLink->url }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endvolt
        </div>
    </div>
</x-app-layout>
