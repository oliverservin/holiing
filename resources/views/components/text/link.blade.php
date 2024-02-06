<x-link
    {{ $attributes->merge(['class' => 'text-zinc-950 underline decoration-zinc-950/50 data-[hover]:decoration-zinc-950 dark:text-white dark:decoration-white/50 dark:data-[hover]:decoration-white']) }}
    x-data="{ hovering: $useHover($refs.target) }"
    x-ref="target"
    x-bind:data-hover="hovering"
>
    {{ $slot }}
</x-link>
