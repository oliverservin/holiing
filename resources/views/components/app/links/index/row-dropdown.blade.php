@props(['shortLink'])

<div x-data="{ menuOpen: false }">
    <x-dropdown x-model="menuOpen">
        <x-dropdown.button size="sm" plain aria-label="Más opciones">
            <x-icon.16.solid.ellipsis-vertical class="size-4" />
        </x-dropdown.button>
        <x-dropdown.menu>
            <x-dropdown.item
                wire:click="delete({{ $shortLink->id }})"
                wire:confirm="¿Estás seguro de que deseas eliminar este enlace?"
                x-on:click="menuOpen = false"
            >
                Eliminar
            </x-dropdown.item>
        </x-dropdown.menu>
    </x-dropdown>
</div>
