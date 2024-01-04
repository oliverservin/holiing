<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware('auth');

name('settings.domains');

?>

<x-app-layout>
    <x-slot:header>
        <x-auth-navbar />
    </x-slot:header>
    <x-slot:subheader>
        <x-settings-navbar />
    </x-slot:subheader>
    <x-container>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-5xl font-extrabold">Dominios</h1>
            </div>
            <div>
                <x-button href="#">Agregar dominio</x-button>
            </div>
        </div>
        <div class="mt-6 pb-20">
            <livewire:domains.list />
        </div>
    </x-container>
</x-app-layout>
