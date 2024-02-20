<?php

use App\Livewire\InteractsWithNotifications;
use App\Models\Domain;
use App\Models\User;
use App\Notifications\DomainVerificationRequested;
use Illuminate\Support\Facades\Notification;
use Spatie\Dns\Dns;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

middleware('auth');

name('settings.domains.index');

uses(InteractsWithNotifications::class);

$getDomains = fn () => $this->domains = auth()->user()->currentTeam->domains()->latest()->get();

state(['domains' => $getDomains, 'validating' => null]);

$validateDomain = function (Domain $domain) {
    $this->validating = $domain;

    $dns = new Dns();

    $dnsRecords = $dns->getRecords($domain->name, ['A', 'AAAA']);

    $validRecord = collect($dnsRecords)->first(function ($record) {
        if ($record->type() === 'A' && $record->ip() === '66.241.125.98') {
            return true;
        }

        if ($record->type() === 'AAAA' && $record->ipv6() === '2a09:8280:1::2d:d701') {
            return true;
        }
    });

    if ($validRecord) {
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

<x-layouts.app>
    @volt('app.settings.domains.index')
        <div>
            <x-settings.header />

            <x-main>
                <x-container>
                    <x-section>
                        <div class="space-y-0.5">
                            <x-heading.h1>Configuración</x-heading.h1>
                            <x-text.lead>Gestiona la configuración de tu cuenta.</x-text.lead>
                        </div>

                        <x-separator />

                        <x-settings.nav />

                        <div class="flex justify-between">
                            <div class="space-y-0.5">
                                <x-heading.h2>Dominios</x-heading.h2>
                                <x-text>Gestiona los dominios que puedes utilizar para crear enlaces cortos.</x-text>
                            </div>
                            <div>
                                <x-button href="{{ route('settings.domains.create') }}">Agregar dominio</x-button>
                            </div>
                        </div>

                        <x-settings.domains.index.list :$domains />
                    </x-section>
                </x-container>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
