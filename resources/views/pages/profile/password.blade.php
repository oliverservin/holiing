<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

middleware('auth');

name('profile.password');

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

    $this->dispatch('password-updated');
};

?>

<x-app-layout>
    <x-slot:header>
        <x-auth-navbar />
    </x-slot:header>
    <x-slot:subheader>
        <x-settings-navbar />
    </x-slot:subheader>
    @volt('pages.profile.password')
        <x-container>
            <div class="max-w-xl mx-auto pt-16 pb-20">
                <x-card>
                    <form wire:submit="updatePassword" class="w-full space-y-8">
                        <h3 class="text-lg/7 font-semibold tracking-[-0.015em] text-zinc-950 sm:text-base/7 dark:text-white">
                            Cambiar contraseña
                        </h3>
                        <x-fieldset>
                            <x-fieldset.field-group>
                                <x-fieldset.field>
                                    <x-fieldset.label>Contraseña actual</x-fieldset.label>
                                    <x-input wire:model="current_password" id="update_password_current_password" type="password" name="current_password" autocomplete="current-password" />
                                    @error('current_password')
                                        <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                    @enderror
                                </x-fieldset.field>

                                <x-fieldset.field>
                                    <x-fieldset.label>Contraseña nueva</x-fieldset.label>
                                    <x-input wire:model="password" id="update_password_password" type="password" name="update_password_password" autocomplete="new-password" />
                                    @error('password')
                                        <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                    @enderror
                                </x-fieldset.field>

                                <x-fieldset.field>
                                    <x-fieldset.label>Confirmar contraseña</x-fieldset.label>
                                    <x-input wire:model="password_confirmation" id="update_password_password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" />
                                    @error('password_confirmation')
                                        <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                    @enderror
                                </x-fieldset.field>
                            </x-fieldset.field-group>
                        </x-fieldset>
                        <x-button class="w-full">Guardar</x-button>
                    </form>
                </x-card>
            </div>
        </x-container>
    @endvolt
</x-app-layout>
