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

<x-layouts.app>
    @volt('pages.app.links.create')
        <div>
            <x-app.settings.header />

            <x-app.main>
                <x-container>
                    <x-app.section>
                        <div class="space-y-0.5">
                            <x-app.heading.h1>Crear enlace corto</x-app.heading.h1>
                            <x-text.lead>Proporciona los detalles de tu enlace y obtén un enlace corto.</x-text.lead>
                        </div>

                        <x-divider />

                        <div class="max-w-2xl">
                            <form wire:submit="store" class="space-y-8">
                                <x-field.group>
                                    <x-field>
                                        <x-field.label>URL de destino</x-field.label>
                                        <x-input wire:model="url" id="url" type="text" name="url" placeholder="{{ url('/') }}" required />
                                        @error('url')
                                            <x-field.error-message>{{ $message }}</x-field.error-message>
                                        @enderror
                                    </x-field>
                                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-3 sm:gap-4">
                                        <x-field>
                                            <x-field.label>Dominio</x-field.label>
                                            <x-select wire:model="domain_id" :invalid="$errors->has('domain_id')">
                                                @foreach($domains as $domain)
                                                    <option value="{{ $domain->id }}">
                                                        {{ $domain->name }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                            @error('domain_id')
                                                <x-field.error-message>{{ $message }}</x-field.error-message>
                                            @enderror
                                        </x-field>
                                        <x-field class="sm:col-span-2">
                                            <x-field.label>Alias</x-field.label>
                                            <x-input wire:model="hashid" id="hashid" type="text" name="hashid"  />
                                            @error('hashid')
                                                <x-field.error-message>{{ $message }}</x-field.error-message>
                                            @enderror
                                        </x-field>
                                    </div>
                                </x-field.group>

                                <x-button>Crear enlace</x-button>
                            </form>
                        </div>
                    </x-app.section>
                </x-container>
            </x-app.main>
        </div>
    @endvolt
</x-layouts.app>
