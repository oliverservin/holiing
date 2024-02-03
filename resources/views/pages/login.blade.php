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
        <x-header />
    </x-slot:header>
    @volt('pages.login')
        <form wire:submit="login" class="w-full max-w-sm space-y-8 mx-auto pt-20 pb-24">
            <x-heading.h1>Iniciar sesión</x-heading.h1>

            <x-field.group>
                <x-field>
                    <x-field.label>Email</x-field.label>
                    <x-input-kube wire:model="form.email" id="email" type="email" name="email" required />
                    @error('form.email')
                        <x-field.error-message>{{ $message }}</x-field.error-message>
                    @enderror
                </x-field>
                <x-field>
                    <x-field.label>Contraseña</x-field.label>
                    <x-input-kube wire:model="form.password" id="password" type="password" name="password" required />
                    @error('form.password')
                        <x-field.error-message>{{ $message }}</x-field.error-message>
                    @enderror
                </x-field>
            </x-field.group>

            <div>
                <div x-data class="flex items-center gap-4">
                    <x-field.label x-switch:label>Recordarme</x-field.label>
                    <x-switch name="remember" wire:model="form.remember" />
                </div>
            </div>

            <x-button class="w-full">Iniciar sesión</x-button>

            <x-text>
                ¿Aún no tienes una cuenta?
                <a
                    href="{{ route('register') }}"
                    class="font-semibold text-zinc-950 hover:text-zinc-700 dark:text-white dark:hover:text-zinc-300"
                >
                    Regístrate
                </a>
            </x-text>
        </form>
    @endvolt
    <x-slot:footer>
        <x-footer />
    </x-slot:footer>
</x-layouts.marketing>
