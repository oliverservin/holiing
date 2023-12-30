<?php

use App\Models\Domain;
use App\HashIdGenerator;
use App\Models\ShortLink;

use Illuminate\Validation\Rule;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\middleware;
use Illuminate\Contracts\Database\Query\Builder;

middleware(['auth']);

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

    $this->dispatch('toast', message: 'Contraseña actualizada correctamente.');

    $this->redirect(route('dashboard'), navigate: true);
}

?>

<x-app-layout>
    <x-slot:header>
        <x-auth-navbar />
    </x-slot:header>
    @volt('pages.links.create')
        <div>
            <x-container>
                <div class="flex items-center h-16">
                    <a href="{{ route('dashboard') }}" class="group flex font-semibold text-sm leading-6 text-zinc-700 hover:text-zinc-900 dark:text-zinc-200 dark:hover:text-white">
                        <svg viewBox="0 -9 3 24" class="overflow-visible mr-3 text-zinc-400 w-auto h-6 group-hover:text-zinc-600 dark:group-hover:text-zinc-300">
                            <path d="M3 0L0 3L3 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Regresar
                    </a>
                </div>
            </x-container>
            <x-container>
                <div class="max-w-xl mx-auto pt-16 pb-20">
                    <x-card>
                        <form wire:submit="store" class="w-full space-y-8">
                            <h3 class="text-lg/7 font-semibold tracking-[-0.015em] text-zinc-950 sm:text-base/7 dark:text-white">
                                Crear un enlace nuevo
                            </h3>
                            <x-fieldset>
                                <x-fieldset.field-group>
                                    <x-fieldset.field>
                                        <x-fieldset.label>URL de destino</x-fieldset.label>
                                        <x-input wire:model="url" id="url" type="text" name="url" placeholder="{{ url('/') }}" required />
                                        @error('url')
                                            <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                                        @enderror
                                    </x-fieldset.field>
                                    <div class="hidden grid-cols-1 gap-8 sm:grid-cols-3 sm:gap-4">
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
                            <x-button class="w-full">Crear enlace</x-button>
                        </form>
                    </x-card>
                </div>
            </x-container>
        </div>
    @endvolt
</x-app-layout>
