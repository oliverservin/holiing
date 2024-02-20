@props(['column', 'sortCol', 'sortAsc'])

<button wire:click="sortBy('{{ $column }}')" {{ $attributes->merge(['class' => 'flex items-center gap-2 group']) }}>
    {{ $slot }}

    @if ($sortCol === $column)
        <div>
            @if ($sortAsc)
                <x-icon.arrow-long-up class="size-4" />
            @else
                <x-icon.arrow-long-down class="size-4" />
            @endif
        </div>
    @else
        <div class="opacity-0 group-hover:opacity-100">
            <x-icon.arrows-up-down class="size-4" />
        </div>
    @endif
</button>
