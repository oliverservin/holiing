<?php

use App\Livewire\InteractsWithNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses(InteractsWithNotifications::class);

middleware('auth');

name('profile.password');

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
])->attributes([
    'current_password' => 'contraseña actual',
    'password' => 'contraseña',
]);

$updatePassword = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    $this->notify('Contraseña actualizada correctamente.');
};

?>

<x-layouts.app>
    @volt('app.profile.password')
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
                                    <x-app.heading.h2>Cambiar contraseña</x-app.heading.h2>
                                    <x-text>Actualiza la contraseña utilizada para iniciar sesión en tu cuenta.</x-text>
                                </div>

                                <x-separator />

                                <form wire:submit="updatePassword" class="space-y-8">
                                    <x-fieldset.field-group>
                                        <x-fieldset.field>
                                            <x-fieldset.label for="update_password_current_password">Contraseña actual</x-fieldset.label>
                                            <x-input
                                                wire:model="current_password"
                                                id="update_password_current_password"
                                                type="password"
                                                name="current_password"
                                                :invalid="$errors->has('current_password')"
                                                autocomplete="current-password"
                                            />
                                            <x-fieldset.description>
                                                Por seguridad, antes de cambiar tu contraseña, indícanos cuál es tu contraseña actual.
                                            </x-fieldset.description>
                                            @error('current_password')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror
                                        </x-fieldset.field>
                                        <x-fieldset.field>
                                            <x-fieldset.label for="update_password_password">Contraseña nueva</x-fieldset.label>
                                            <x-input
                                                wire:model="password"
                                                id="update_password_password"
                                                type="password"
                                                name="update_password_password"
                                                :invalid="$errors->has('password')"
                                                autocomplete="new-password"
                                            />
                                            <x-fieldset.description>Elige una nueva contraseña. Asegúrate de que sea segura.</x-fieldset.description>
                                            @error('password')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror
                                        </x-fieldset.field>
                                        <x-fieldset.field>
                                            <x-fieldset.label for="update_password_password_confirmation">Confirmar contraseña</x-fieldset.label>
                                            <x-input
                                                wire:model="password_confirmation"
                                                id="update_password_password_confirmation"
                                                type="password"
                                                name="password_confirmation"
                                                :invalid="$errors->has('password_confirmation')"
                                                autocomplete="new-password"
                                            />
                                            <x-fieldset.description>Vuelve a repetir tu nueva contraseña para validarla.</x-fieldset.description>
                                            @error('password_confirmation')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror
                                        </x-fieldset.field>
                                    </x-fieldset.field-group>

                                    <x-button>Guardar</x-button>
                                </form>
                            </x-app.section>
                        </div>
                    </x-app.section>
                </x-container>
            </x-app.main>
        </div>
    @endvolt
</x-layouts.app>
