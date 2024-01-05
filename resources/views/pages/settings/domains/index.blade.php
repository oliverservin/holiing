<?php

use function Laravel\Folio\name;
use function Laravel\Folio\middleware;
use function Livewire\Volt\state;

use App\Livewire\InteractsWithNotifications;
use App\Models\Domain;
use App\Models\User;
use App\Notifications\DomainVerificationRequested;
use Illuminate\Support\Facades\Notification;
use Spatie\Dns\Dns;

middleware('auth');

name('settings.domains.index');

$getDomains = fn () => $this->domains = auth()->user()->currentTeam->domains()->latest()->get();

uses(InteractsWithNotifications::class);

state(['domains' => $getDomains, 'validating' => null]);

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

<x-app-layout>
    <x-slot:header>
        <x-auth-navbar />
    </x-slot:header>
    <x-slot:subheader>
        <x-settings-navbar />
    </x-slot:subheader>
    @volt('pages.settings.domains')
        <x-container>
            <div class="flex justify-between items-end">
                <div>
                    <h1 class="text-5xl font-extrabold">Dominios</h1>
                </div>
                <div>
                    <x-button href="{{ route('settings.domains.create') }}">Agregar dominio</x-button>
                </div>
            </div>
            <div class="mt-6 pb-20">
                <livewire:domains.list />
            </div>
        </x-container>
    @endvolt
</x-app-layout>
