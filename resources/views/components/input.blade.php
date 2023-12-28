<?php

use Illuminate\Support\Arr;

$controlClasses = Arr::toCssClasses([
    // Basic layout
    'relative block w-full',

    // Background color + shadow applied to inset pseudo element, so shadow blends with border in light mode
    'before:absolute before:inset-px before:rounded-[calc(theme(borderRadius.lg)-1px)] before:bg-white before:shadow',

    // Background color is moved to control and shadow is removed in dark mode so hide `before` pseudo
    'dark:before:hidden',

    // Focus ring
    'after:pointer-events-none after:absolute after:inset-0 after:rounded-lg after:ring-inset after:ring-transparent sm:after:focus-within:ring-2 sm:after:focus-within:ring-blue-500',

    // Disabled state
    'has-[[data-disabled]]:opacity-50 before:has-[[data-disabled]]:bg-zinc-950/5 before:has-[[data-disabled]]:shadow-none',

    // Invalid state
    'before:has-[[data-invalid]]:shadow-red-500/10',
]);

$classes = Arr::toCssClasses([
    // Basic layout
    'relative block w-full appearance-none rounded-lg px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing[3])-1px)] sm:py-[calc(theme(spacing[1.5])-1px)]',

    // Typography
    'text-base/6 text-zinc-950 placeholder:text-zinc-500 sm:text-sm/6 dark:text-white',

    // Border
    'border border-zinc-950/10 data-[hover]:border-zinc-950/20 dark:border-white/10 dark:data-[hover]:border-white/20',

    // Background color
    'bg-transparent dark:bg-white/5',

    // Hide default focus styles
    'focus:outline-none',

    // Invalid state
    'data-[invalid]:border-red-500 data-[invalid]:data-[hover]:border-red-500 data-[invalid]:dark:border-red-500 data-[invalid]:data-[hover]:dark:border-red-500',

    // Disabled state
    'data-[disabled]:border-zinc-950/20 dark:data-[hover]:data-[disabled]:border-white/15 data-[disabled]:dark:border-white/15 data-[disabled]:dark:bg-white/[2.5%]',
]);

?>

<span
    data-slot="control"
    class="{{ $controlClasses }}"
>
    <input {{ $attributes->except('class') }} class="{{ $classes }}">
</span>