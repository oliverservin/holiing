<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\form;

name('login');

middleware('guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirect(
        session('url.intended', RouteServiceProvider::HOME),
        navigate: true
    );

};

?>

<x-layouts.marketing>
    <x-slot:header>
        <x-marketing.header />
    </x-slot>
    @volt('pages.login')
        <form wire:submit="login" class="mx-auto w-full max-w-sm space-y-8 pb-24 pt-20">
            <x-app.heading.h1>Iniciar sesión</x-app.heading.h1>

            <x-fieldset.field-group>
                <x-fieldset.field>
                    <x-fieldset.label>Email</x-fieldset.label>
                    <x-input wire:model="form.email" id="email" type="email" name="email" required />
                    @error('form.email')
                        <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                    @enderror
                </x-fieldset.field>
                <x-fieldset.field>
                    <x-fieldset.label>Contraseña</x-fieldset.label>
                    <x-input wire:model="form.password" id="password" type="password" name="password" required />
                    @error('form.password')
                        <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                    @enderror
                </x-fieldset.field>
            </x-fieldset.field-group>

            <div>
                <div x-data class="flex items-center gap-4">
                    <x-fieldset.label x-switch:label>Recordarme</x-fieldset.label>
                    <x-switch name="remember" wire:model="form.remember" />
                </div>
            </div>

            <x-button class="w-full">Iniciar sesión</x-button>

            <x-text>
                ¿Aún no tienes una cuenta?
                <a href="{{ route('register') }}" class="font-semibold text-zinc-950 hover:text-zinc-700 dark:text-white dark:hover:text-zinc-300">
                    Regístrate
                </a>
            </x-text>
        </form>
    @endvolt

    <x-slot:footer>
        <x-marketing.footer />
    </x-slot>
</x-layouts.marketing>
