<?php

use App\HashIdGenerator;
use App\Models\ShortLink;

use function Laravel\Folio\middleware;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

middleware(['auth']);

state(['url' => '']);

rules(['url' => 'required|string|max:255']);

$store = function (HashIdGenerator $hashIdGenerator) {
    $this->validate();

    ShortLink::create([
        'url' => $this->url,
        'hashid' => $hashIdGenerator->generate(),
    ]);

    $this->redirect('/', navigate: true);
}

?>

<x-app-layout>
    @volt('pages.links.create')
        <div>
            <div class="max-w-xl mx-auto">
                <div class="flex px-4 pt-8 pb-4 lg:px-8">
                    <a href="/" class="group flex font-semibold text-sm leading-6 text-zinc-700 hover:text-zinc-900 dark:text-zinc-200 dark:hover:text-white">
                        <svg viewBox="0 -9 3 24" class="overflow-visible mr-3 text-zinc-400 w-auto h-6 group-hover:text-zinc-600 dark:group-hover:text-zinc-300">
                            <path d="M3 0L0 3L3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Regresar
                    </a>
                </div>
            </div>
            <div class="max-w-xl mx-auto">
                <div class="px-4 lg:px-8">
                    <x-card>
                        <form wire:submit="store" class="w-full space-y-8">
                            <h3 class="text-lg/7 font-semibold tracking-[-0.015em] text-zinc-950 sm:text-base/7 dark:text-white">
                                Crear un enlace nuevo
                            </h3>
                            <x-fieldset>
                                <x-fieldset.field-group>
                                    <x-fieldset.field>
                                        <x-fieldset.label>URL de destino</x-fieldset.label>
                                        <x-input wire:model="url" id="url" type="text" name="url" placeholder="{{ url('/') }}" required />
                                        @error('url')
                                            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                        @enderror
                                    </x-fieldset.field>
                                </x-fieldset.field-group>
                            </x-fieldset>
                            <x-button class="w-full">Crear enlace</x-button>
                        </form>
                    </x-card>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
