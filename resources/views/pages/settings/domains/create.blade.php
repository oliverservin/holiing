<?php

use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Laravel\Folio\middleware;
use function Livewire\Volt\uses;

use App\Livewire\InteractsWithNotifications;

uses(InteractsWithNotifications::class);

middleware('auth');

name('settings.domains.create');

state(['domain' => '']);

rules(['domain' => ['required', 'string', 'max:255', 'regex:/^(?!-)([A-Za-z0-9-]{1,63}(?<!-)\.)+[A-Za-z]{2,6}$/']]);

$store = function () {
    $validated = $this->validate();

    auth()->user()->currentTeam->domains()->create([
        'name' => $validated['domain'],
        'public_domain' => false,
    ]);

    session()->flash('flash.notification', 'Tu doominio ha sido agregado.');

    $this->redirect(route('settings.domains.index'), navigate: true);
};

?>

<x-app-layout>
    <x-slot:header>
        <x-auth-navbar />
    </x-slot:header>
    <x-slot:subheader>
        <x-settings-navbar />
    </x-slot:subheader>
    @volt('pages.settings.domains.create')
        <x-container>
            <div class="flex justify-between items-end">
                <div>
                    <h5 class="text-sm font-bold mb-2">
                        <a href="{{ route('settings.domains.index') }}" wire:navigate class="underline">Dominios</a>
                    </h5>
                    <h1 class="text-[44px] font-extrabold tracking-tight leading-[1.15]">Agregar dominio</h1>
                </div>
            </div>
            <div class="mt-6 pb-20">
                <div class="p-8 bg-zinc-50">
                    <div class="max-w-lg">
                        <form wire:submit="store" class="w-full space-y-8">
                            <x-fieldset>
                                <x-fieldset.field-group>
                                    <x-fieldset.field>
                                        <x-fieldset.label>Nombre de dominio</x-fieldset.label>
                                        <x-input wire:model="domain" id="domain" type="text" name="domain" placeholder="holi.ing" required />
                                        @error('domain')
                                            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                        @enderror
                                    </x-fieldset.field>
                                </x-fieldset.field-group>
                            </x-fieldset>
                            <x-button>Agregar dominio</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </x-container>
    @endvolt
</x-app-layout>
