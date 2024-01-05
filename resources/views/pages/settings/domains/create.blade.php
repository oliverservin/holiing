<?php

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware('auth');

name('settings.domains.create');

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
                <h5 class="text-sm font-bold mb-2">
                    <a href="{{ route('settings.domains.index') }}" wire:navigate class="underline">Dominios</a>
                </h5>
                <h1 class="text-[44px] font-extrabold tracking-tight leading-[1.15]">Agregar dominio</h1>
            </div>
        </div>
        <div class="mt-6 pb-20">
            <div class="p-8 bg-zinc-50">
                <div class="max-w-lg">
                    <livewire:domains.create />
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
