<?php

use Spatie\Dns\Dns;
use App\Models\User;
use App\Models\Domain;

use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Laravel\Folio\middleware;
use function Livewire\Volt\uses;

use App\Livewire\InteractsWithNotifications;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DomainVerificationRequested;

middleware('auth');

name('app.settings.domains.index');

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

<x-layouts.app>
    @volt('pages.app.settings.domains.index')
        <div>
            <x-app.settings.header />

            <x-main>
                <x-container>
                    <x-section>
                        <div class="space-y-0.5">
                            <x-heading.h1>Configuración</x-heading.h1>
                            <x-text.lead>Gestiona la configuración de tu cuenta.</x-text.lead>
                        </div>

                        <x-divider />

                        <x-app.settings.nav />

                        <div class="flex justify-between">
                            <div class="space-y-0.5">
                                <x-heading.h2>Dominios</x-heading.h2>
                                <x-text>Gestiona los dominios que puedes utilizar para crear enlaces cortos.</x-text>
                            </div>
                            <div>
                                <x-button size="sm" href="{{ route('app.settings.domains.create') }}">Agregar dominio</x-button>
                            </div>
                        </div>

                        <x-app.settings.domains.index.list :$domains />
                    </x-section>
                </x-container>
            </x-main>
        </div>
    @endvolt
</x-layouts.app>
