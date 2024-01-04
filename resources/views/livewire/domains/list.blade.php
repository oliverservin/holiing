<?php

use Spatie\Dns\Dns;
use App\Models\User;
use App\Models\Domain;
use function Livewire\Volt\on;
use function Livewire\Volt\uses;

use function Livewire\Volt\state;
use App\Livewire\InteractsWithNotifications;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DomainVerificationRequested;

$getDomains = fn () => $this->domains = auth()->user()->currentTeam->domains()->latest()->get();

uses(InteractsWithNotifications::class);

state(['domains' => $getDomains, 'validating' => null]);

on(['domain-created' => $getDomains]);

$validateDomain = function (Domain $domain) {
    $this->validating = $domain;

    $dns = new Dns();

    $dnsRecords = $dns->getRecords($domain->name, ['A', 'AAAA']);

    $validRecord = collect($dnsRecords)->first(function ($record) {
        if ($record->type() === 'A' && $record->ip() === '66.241.124.101') {
            return true;
        }

        if ($record->type() === 'AAAA' && $record->ipv6() === '2a09:8280:1::69:d0e7') {
            return true;
        }
    });

    if($validRecord) {
        $domain->validated_at = now();

        Notification::send(User::admin()->get(), new DomainVerificationRequested($domain));

        $domain->save();

        $this->notify('El dominio fue validado correctamente.');
    } else {
        $this->notifyError('El dominio no fue validado correctamente.');
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
                            <x-button wire:click="validateDomain({{ $domain->id }})" outline>Validar</x-button>
                        </div>
                    @endunless
                </div>
                <div class="flex gap-4">
                    @if ($domain->validated_at)
                        <x-badge color="blue">Configuración válida</x-badge>
                        @unless ($domain->verified_at)
                            <x-badge color="yellow">Verificación pendiente</x-badge>
                        @endunless
                    @else
                        <x-badge color="yellow">Validación pendiente</x-badge>
                    @endif
                </div>
                @unless ($domain->validated_at)
                    <div class="border-t border-zinc-200 pt-5">
                        <x-text>Para configurar tu dominio <x-text.code>{{ $domain->name }}</x-text.code>, configura los siguiente registros A y AAAA con tu proveedor de DNS:</x-text>
                        <div class="flex gap-4 mt-5 text-sm">
                            <div class="flex flex-col gap-2">
                                <div class="font-medium text-zinc-500 dark:text-zinc-400">Type</div>
                                <div>A</div>
                                <div>AAAA</div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="font-medium text-zinc-500 dark:text-zinc-400">Name</div>
                                <div>@</div>
                                <div>@</div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="font-medium text-zinc-500 dark:text-zinc-400">Value</div>
                                <div>66.241.124.101</div>
                                <div>2a09:8280:1::69:d0e7</div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="font-medium text-zinc-500 dark:text-zinc-400">TTL</div>
                                <div>86400</div>
                                <div>86400</div>
                            </div>
                        </div>
                        <x-text class="mt-5">Nota: para el TTL, si <x-text.code>86400</x-text.code> no está disponible, establece el valor más alto posible. Además, la propagación de dominios puede tardar entre 1 y 12 horas.</x-text>
                    </div>
                @endunless

                @if ($domain->validated_at && ! $domain->verified_at)
                    <div class="border-t border-zinc-200 pt-5">
                        <x-text>Tu dominio ha sido configurado correctamente. Por favor, <x-text.strong>espera hasta 24 horas</x-text.strong> para que manualmente verifiquemos y activemos tu dominio. Te enviaremos una notificación por email cuando haya sido verificado.</x-text>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
