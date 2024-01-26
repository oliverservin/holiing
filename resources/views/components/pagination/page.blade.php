@props(['href', 'current' => false])

<x-button
    :href="$href ?? null"
    plain
    aria-label="Page {{ $slot }}"
    :aria-current="$current ? 'page' : null"
    @class([
        'min-w-[2.25rem] before:absolute before:-inset-px before:rounded-lg',
        'before:bg-zinc-950/5 dark:before:bg-white/10' => $current,
    ])
>
    <span class="-mx-0.5">
        {{ $slot }}
    </span>
</x-button>
