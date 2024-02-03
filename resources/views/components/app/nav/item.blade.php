@props(['href', 'active' => false])

<x-link href="{{ $href }}" @class([
        'flex items-center py-2 text-sm',
        'text-black dark:text-white/80' => ! $active,
        'text-black/60 dark:text-white/60' => $active,
    ])
>
    {{ $slot }}
</x-link>
