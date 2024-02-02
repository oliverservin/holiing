<?php

use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Laravel\Folio\middleware;
use function Livewire\Volt\uses;

use App\Livewire\InteractsWithNotifications;

uses(InteractsWithNotifications::class);

middleware('auth');

name('app.settings.domains.create');

state([
    'domain' => '',
    'landing_page' => '',
]);

rules([
    'domain' => ['required', 'string', 'max:255', 'regex:/^(?!-)([A-Za-z0-9-]{1,63}(?<!-)\.)+[A-Za-z]{2,6}$/'],
    'landing_page' => ['string', 'max:255'],
]);

$store = function () {
    $validated = $this->validate();

    auth()->user()->currentTeam->domains()->create([
        'name' => $validated['domain'],
        'landing_page' => $validated['landing_page'],
        'public_domain' => false,
    ]);

    session()->flash('flash.notification', 'Tu dominio ha sido agregado.');

    $this->redirect(route('app.settings.domains.index'), navigate: true);
};

?>

<x-layouts.app>
    @volt('pages.app.settings.domains.create')
        <div>
            <x-app.settings.header />

            <x-main>
                <x-container>
                    <x-section>
                        <div class="space-y-0.5">
                            <x-heading.h1>Configuración</x-heading.h1>
                            <x-text.lead>Gestiona la configuración de tu cuenta.</x-text.lead>
                        </div>

                        <x-divider />

                        <x-app.settings.nav />

                        <div class="max-w-2xl">
                            <x-section>
                                <div class="space-y-0.5">
                                    <x-heading.h2>Agregar dominio</x-heading.h2>
                                    <x-text>Crea enlaces cortos utilizando dominios personalizados.</x-text>
                                </div>

                                <x-divider />

                                <form wire:submit="store" class="space-y-8">
                                    <x-field.group>
                                        <x-field>
                                            <x-field.label for="domain">Nombre de dominio</x-field.label>
                                            <x-input-kube wire:model="domain" id="domain" type="text" name="domain" :invalid="$errors->has('domain')" placeholder="holi.ing" required />
                                            @error('domain')
                                                <x-field.error-message>{{ $message }}</x-field.error-message>
                                            @enderror
                                            <x-field.description>
                                                El nombre de dominio que deseas agregar.
                                            </x-field.description>
                                        </x-field>

                                        <x-field>
                                            <x-field.label for="landing_page">Página de landing</x-field.label>
                                            <x-input-kube wire:model="landing_page" id="landing_page" type="text" name="landing_page" :invalid="$errors->has('landing_page')" placeholder="https://tudominio.com" required />
                                            @error('landing_page')
                                                <x-field.error-message>{{ $message }}</x-field.error-message>
                                            @enderror
                                            <x-field.description>
                                                La página a la que serán redirigidos tus usuarios cuando visiten tu dominio.
                                            </x-field.description>
                                        </x-field>
                                    </x-field.group>

                                    <x-button.kube>Agregar dominio</x-button.kube>
                                </form>
                            </x-section>
                        </div>
                    </x-section>
                </x-container>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
