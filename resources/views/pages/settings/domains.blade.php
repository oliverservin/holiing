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
        <div class="max-w-xl mx-auto pt-16 pb-20">
            <livewire:domains.create />
            <div class="mt-8">
                <livewire:domains.list />
            </div>
        </div>
    </x-container>
</x-app-layout>
