@props(['size' => 'md', 'outline' => false])

<?php

$classes = [
    $attributes->get('class'),

    // Base
    'relative isolate inline-flex items-center justify-center gap-x-2 rounded-lg border font-medium',

    // Sizing
    'py-2.5 px-5 text-sm/[20px]' => $size === 'md',
    'py-1.5 px-3 text-sm/[18px]' => $size === 'sm',

    // Focus
    'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0070F3] dark:focus-visible:outline-[#6CAFFF]',

    // Disabled
    'disabled:opacity-40',

    // Default style
    'bg-black dark:bg-white/80 border-black dark:border-white/80 text-white dark:text-black/80 hover:bg-black/80 dark:hover:bg-white disabled:hover:bg-black disabled:dark:hover:bg-white/80' => ! $outline,

    // Outline style
    'border-black/15 dark:border-white/15 text-black dark:text-white/80 hover:bg-black/5 dark:hover:bg-white/5 disabled:hover:bg-transparent disabled:dark:hover:bg-transparent' => $outline,
];

?>

@if ($attributes->has('href') && ! empty($attributes->get('href')))
    <x-link {{ $attributes->except(['class']) }} @class($classes)>
        {{ $slot }}
    </x-link>
@else
    <button {!! $attributes->except(['class']) !!} @class($classes)>
        {{ $slot }}
    </button>
@endif
