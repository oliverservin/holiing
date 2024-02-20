@props(['href', 'active' => false])

<x-link
    href="{{ $href }}"
    @class([
        'flex items-center py-2 text-sm',
        'text-zinc-950 dark:text-white' => ! $active,
        'text-zinc-500 dark:text-zinc-400' => $active,
    ])
>
    {{ $slot }}
</x-link>
