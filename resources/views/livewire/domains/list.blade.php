<?php

use App\Models\Domain;
use Spatie\Dns\Dns;

use function Livewire\Volt\on;
use function Livewire\Volt\state;

$getDomains = fn () => $this->domains = auth()->user()->currentTeam->domains()->latest()->get();

state(['domains' => $getDomains, 'validating' => null]);

on(['domain-created' => $getDomains]);

$validateDomain = function (Domain $domain) {
    $this->validating = $domain;

    $dns = new Dns();

    $dnsRecords = $dns->getRecords($domain->name, ['A', 'CNAME']);

    $validRecord = collect($dnsRecords)->first(fn($record) => $record->ip() === '66.241.124.101');

    if($validRecord) {
        $domain->validated_at = now();

        $domain->save();
    }

    $this->getDomains();
};

?>

<div class="space-y-4">
    @foreach($domains as $domain)
        <div wire:key="{{ $domain->id }}" class="border rounded p-4">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between">
                    <div>
                        <a href="https://{{ $domain->name }}" class="text-xl font-semibold">{{ $domain->name }}</a>
                    </div>
                    @unless ($domain->validated_at)
                        <div>
                            <x-button wire:click="validateDomain({{ $domain->id }})" outline>Verificar</x-button>
                        </div>
                    @endunless
                </div>
                <div class="flex gap-4">
                    @if ($domain->validated_at)
                        <x-badge color="blue">Configuración válida</x-badge>
                    @else
                        <x-badge color="yellow">Verificación pendiente</x-badge>
                    @endif
                </div>
                @unless ($domain->validated_at)
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
                @endunless
            </div>
        </div>
    @endforeach
</div>
