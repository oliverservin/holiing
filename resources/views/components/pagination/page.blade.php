@props(['href', 'current' => false])

<x-button
    size="sm"
    :href="$href ?? null"
    plain
    aria-label="Page {{ $slot }}"
    :aria-current="$current ? 'page' : null"
    @class([
        'min-w-[2.25rem] before:absolute before:-inset-px before:rounded-lg',
        'before:bg-black/5 dark:before:bg-white/5' => $current,
    ])
>
    <span class="-mx-0.5">
        {{ $slot }}
    </span>
</x-button>
