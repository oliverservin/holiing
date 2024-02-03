@props(['invalid' => false])

<?php

$classes = [
    // Basic layout
    'relative block w-full appearance-none rounded-lg px-3 py-2.5 ring-inset border-0',

    // Typography
    'text-sm/[22px] text-black/80 dark:text-white/80 placeholder:text-black/50 dark:placeholder:text-white/50',

    // Border
    'ring-1 ring-black/15 dark:ring-white/15' => ! $invalid,

    // Background color
    'bg-white dark:bg-matte',

    // Focus
    'focus:outline-none focus:ring-2 focus:ring-[#0070F3] focus:dark:ring-[#6CAFFF]',

    // Invalid state
    'ring-1 ring-[#D3222A] dark:ring-[#EE696F]' => $invalid,

    // Disabled state
    'disabled:opacity-60',
];

?>

<input
    {{ $attributes->except('class') }}
    @class($classes)
>
