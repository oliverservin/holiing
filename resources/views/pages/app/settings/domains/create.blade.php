<?php

use App\Livewire\InteractsWithNotifications;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

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

            <x-app.main>
                <x-container>
                    <x-app.section>
                        <div class="space-y-0.5">
                            <x-app.heading.h1>Configuración</x-app.heading.h1>
                            <x-text.lead>Gestiona la configuración de tu cuenta.</x-text.lead>
                        </div>

                        <x-separator />

                        <x-app.settings.nav />

                        <div class="max-w-2xl">
                            <x-app.section>
                                <div class="space-y-0.5">
                                    <x-app.heading.h2>Agregar dominio</x-app.heading.h2>
                                    <x-text>Crea enlaces cortos utilizando dominios personalizados.</x-text>
                                </div>

                                <x-separator />

                                <form wire:submit="store" class="space-y-8">
                                    <x-fieldset.field-group>
                                        <x-fieldset.field>
                                            <x-fieldset.label for="domain">Nombre de dominio</x-fieldset.label>
                                            <x-input
                                                wire:model="domain"
                                                id="domain"
                                                type="text"
                                                name="domain"
                                                :invalid="$errors->has('domain')"
                                                placeholder="holi.ing"
                                                required
                                            />
                                            @error('domain')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror

                                            <x-fieldset.description>El nombre de dominio que deseas agregar.</x-fieldset.description>
                                        </x-fieldset.field>

                                        <x-fieldset.field>
                                            <x-fieldset.label for="landing_page">Página de landing</x-fieldset.label>
                                            <x-input
                                                wire:model="landing_page"
                                                id="landing_page"
                                                type="text"
                                                name="landing_page"
                                                :invalid="$errors->has('landing_page')"
                                                placeholder="https://tudominio.com"
                                                required
                                            />
                                            @error('landing_page')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror

                                            <x-fieldset.description>
                                                La página a la que serán redirigidos tus usuarios cuando visiten tu dominio.
                                            </x-fieldset.description>
                                        </x-fieldset.field>
                                    </x-fieldset.field-group>

                                    <x-button>Agregar dominio</x-button>
                                </form>
                            </x-app.section>
                        </div>
                    </x-app.section>
                </x-container>
            </x-app.main>
        </div>
    @endvolt
</x-layouts.app>
