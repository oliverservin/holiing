<?php

use function Livewire\Volt\on;
use function Livewire\Volt\state;

$getDomains = fn () => $this->domains = auth()->user()->currentTeam->domains()->latest()->get();

state(['domains' => $getDomains]);

on(['domain-created' => $getDomains]);

?>

<div class="space-y-4">
    @foreach($domains as $domain)
        <div class="border rounded p-4">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between">
                    <div>
                        <a href="https://{{ $domain->name }}" class="text-xl font-semibold">{{ $domain->name }}</a>
                    </div>
                    <div>
                        <x-button outline>Verificar</x-button>
                    </div>
                </div>
                <div class="flex gap-4">
                    <x-badge color="yellow">Verificación pendiente</x-badge>
                </div>
                <div class="border-t border-zinc-200 pt-5">
                    <x-text>Para configurar tu dominio <x-text.code>{{ $domain->name }}</x-text.code>, configura el siguiente registro CNAME en tu proveedor de DNS:</x-text>
                    <div class="flex gap-4 mt-5 text-sm">
                        <div class="flex flex-col gap-2">
                            <div class="font-medium text-zinc-500 dark:text-zinc-400">Type</div>
                            <div>CNAME</div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="font-medium text-zinc-500 dark:text-zinc-400">Name</div>
                            <div>@</div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="font-medium text-zinc-500 dark:text-zinc-400">Value</div>
                            <div>links.holiing.com</div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="font-medium text-zinc-500 dark:text-zinc-400">TTL</div>
                            <div>86400</div>
                        </div>
                    </div>
                    <x-text class="mt-5">Nota: para el TTL, si <x-text.code>86400</x-text.code> no está disponible, establece el valor más alto posible. Además, la propagación de dominios puede tardar entre 1 y 12 horas.</x-text>
                </div>
            </div>
        </div>
    @endforeach
</div>
