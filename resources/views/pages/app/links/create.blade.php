<?php

use App\Models\Domain;
use App\HashIdGenerator;
use App\Models\ShortLink;

use Illuminate\Validation\Rule;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

use Illuminate\Contracts\Database\Query\Builder;

middleware(['auth']);

name('app.links.create');

state([
    'url' => '',
    'hashid' => '',
    'domain_id' => Domain::where('public_domain', true)->first()->id,
    'domains' => fn () => Domain::where('team_id', Auth::user()->currentTeam->id)->orWhere('public_domain', true)->latest()->get(),
]);

$store = function (HashIdGenerator $hashIdGenerator) {
    $validated = $this->validate(
        rules: [
            'url' => ['required', 'string', 'max:255'],
            'hashid' => ['nullable', Rule::unique('short_links')->where(fn (Builder $query) => $query->where('domain_id', $this->domain_id))],
            'domain_id' => ['required', 'exists:domains,id'],
        ],
        attributes: [
            'url' => 'url',
            'hashid' => 'hashid',
            'domain_id' => 'dominio',
        ]);

    if (! $validated['hashid']) {
        $validated['hashid'] = $hashIdGenerator->generate();
    }

    Auth::user()->currentTeam->links()->create($validated);

    session()->flash('flash.notification', 'Enlace creado.');

    $this->redirect(route('app.dashboard'), navigate: true);
}

?>

<x-app-layout>
    @volt('pages.app.links.create')
        <div>
            <x-links.index.navigation />

            <x-main>
                <x-section>
                    <x-container>
                        <x-page-heading>
                            <x-slot name="breadcrumb">
                                <x-subtitle>
                                    <x-link href="{{ route('app.dashboard') }}" class="underline">Dashboard</x-link>
                                </x-subtitle>
                            </x-slot>
                            <x-h1>Crear enlace</x-h1>
                        </x-page-heading>
                    </x-container>
                </x-section>

                <x-section>
                    <x-container>
                        <div class="p-8 bg-zinc-50">
                            <form wire:submit="store" class="w-full max-w-lg space-y-8">
                                <x-fieldset>
                                    <x-fieldset.field-group>
                                        <x-fieldset.field>
                                            <x-fieldset.label>URL de destino</x-fieldset.label>
                                            <x-input wire:model="url" id="url" type="text" name="url" placeholder="{{ url('/') }}" required />
                                            @error('url')
                                                <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                            @enderror
                                        </x-fieldset.field>
                                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-3 sm:gap-4">
                                            <x-fieldset.field>
                                                <x-fieldset.label>Dominio</x-fieldset.label>
                                                <x-select wire:model="domain_id" :invalid="$errors->has('domain_id')">
                                                    @foreach($domains as $domain)
                                                        <option value="{{ $domain->id }}">
                                                            {{ $domain->name }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                                @error('domain_id')
                                                    <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                                @enderror
                                            </x-fieldset.field>
                                            <x-fieldset.field class="sm:col-span-2">
                                                <x-fieldset.label>Alias</x-fieldset.label>
                                                <x-input wire:model="hashid" id="hashid" type="text" name="hashid"  />
                                                @error('hashid')
                                                    <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                                @enderror
                                            </x-fieldset.field>
                                        </div>
                                    </x-fieldset.field-group>
                                </x-fieldset>
                                <x-button>Crear enlace</x-button>
                            </form>
                        </div>
                    </x-container>
                </x-section>
            </x-main>
        </div>
    @endvolt
</x-app-layout>
