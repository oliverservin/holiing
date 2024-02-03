<?php

use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use function Laravel\Folio\middleware;
use Illuminate\Validation\Rules\Password;
use App\Livewire\InteractsWithNotifications;
use Illuminate\Validation\ValidationException;

uses(InteractsWithNotifications::class);

middleware('auth');

name('app.profile.password');

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => ''
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
    @volt('pages.app.profile.password')
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
                                    <x-heading.h2>Cambiar contraseña</x-heading.h2>
                                    <x-text>Actualiza la contraseña utilizada para iniciar sesión en tu cuenta.</x-text>
                                </div>

                                <x-divider />

                                <form wire:submit="updatePassword" class="space-y-8">
                                    <x-field.group>
                                        <x-field>
                                            <x-field.label for="update_password_current_password">Contraseña actual</x-field.label>
                                            <x-input-kube wire:model="current_password" id="update_password_current_password" type="password" name="current_password" :invalid="$errors->has('current_password')" autocomplete="current-password" />
                                            <x-field.description>
                                                Por seguridad, antes de cambiar tu contraseña, indícanos cuál es tu contraseña actual.
                                            </x-field.description>
                                            @error('current_password')
                                                <x-field.error-message>{{ $message }}</x-field.error-message>
                                            @enderror
                                        </x-field>
                                        <x-field>
                                            <x-field.label for="update_password_password">Contraseña nueva</x-field.label>
                                            <x-input-kube wire:model="password" id="update_password_password" type="password" name="update_password_password" :invalid="$errors->has('password')" autocomplete="new-password" />
                                            <x-field.description>
                                                Elige una nueva contraseña. Asegúrate de que sea segura.
                                            </x-field.description>
                                            @error('password')
                                                <x-field.error-message>{{ $message }}</x-field.error-message>
                                            @enderror
                                        </x-field>
                                        <x-field>
                                            <x-field.label for="update_password_password_confirmation">Confirmar contraseña</x-field.label>
                                            <x-input-kube wire:model="password_confirmation" id="update_password_password_confirmation" type="password" name="password_confirmation" :invalid="$errors->has('password_confirmation')" autocomplete="new-password" />
                                            <x-field.description>
                                                Vuelve a repetir tu nueva contraseña para validarla.
                                            </x-field.description>
                                            @error('password_confirmation')
                                                <x-field.error-message>{{ $message }}</x-field.error-message>
                                            @enderror
                                        </x-field>
                                    </x-field.group>

                                    <x-button>Guardar</x-button>
                                </form>
                            </x-section>
                        </div>
                    </x-section>
                </x-container>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
