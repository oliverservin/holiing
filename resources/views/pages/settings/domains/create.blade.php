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

    session()->flash('flash.notification', 'Tu dominio ha sido agregado.');

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
            <x-page-heading>
                <x-slot name="breadcrumb">
                    <x-subtitle>
                        <x-link href="{{ route('settings.domains.index') }}" class="underline">Dominios</x-link>
                    </x-subtitle>
                </x-slot>
                <x-h1>Agregar dominio</x-h1>
            </x-page-heading>
            <div class="mt-6 pb-20">
                <div class="p-8 bg-zinc-50">
                    <form wire:submit="store" class="w-full max-w-lg space-y-8">
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
        </x-container>
    @endvolt
</x-app-layout>
