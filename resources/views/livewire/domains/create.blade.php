<?php

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state(['domain' => '']);

rules(['domain' => ['required', 'string', 'max:255', 'regex:/^(?!-)([A-Za-z0-9-]{1,63}(?<!-)\.)+[A-Za-z]{2,6}$/']]);

$store = function () {
    $validated = $this->validate();

    auth()->user()->currentTeam->domains()->create([
        'name' => $validated['domain'],
        'public_domain' => false,
    ]);

    $this->domain = '';

    $this->dispatch('domain-created');
};

?>

<div>
    <form wire:submit="store" class="w-full space-y-8">
        <x-fieldset>
            <x-fieldset.field-group>
                <x-fieldset.field>
                    <x-fieldset.label>Dominio</x-fieldset.label>
                    <x-input wire:model="domain" id="domain" type="text" name="domain" placeholder="holi.ing" required />
                    @error('domain')
                        <x-fieldset.error-message>{{ $message }}</x-fieldset.error-message>
                    @enderror
                </x-fieldset.field>
            </x-fieldset.field-group>
        </x-fieldset>
        <x-button>Agregar dominio</x-button>
    </form>
</div>
