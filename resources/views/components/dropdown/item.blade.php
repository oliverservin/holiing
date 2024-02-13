@props(['href'])

<?php

$classes = [
    $attributes->get('class'),

    // Base styles
    'group cursor-default rounded-lg px-3.5 py-2.5 focus:outline-none sm:px-3 sm:py-1.5',

    // Text styles
    'text-left text-base/6 text-zinc-950 sm:text-sm/6 dark:text-white forced-colors:text-[CanvasText]',

    // Focus
    'data-[focus]:bg-blue-500 data-[focus]:text-white',

    // Disabled state
    'data-[disabled]:opacity-50',

    // Forced colors mode
    'forced-color-adjust-none forced-colors:data-[focus]:bg-[Highlight] forced-colors:data-[focus]:text-[HighlightText] forced-colors:[&>[data-slot=icon]]:data-[focus]:text-[HighlightText]',

    // Use subgrid when available but fallback to an explicit grid layout if not
    'col-span-full grid grid-cols-[auto_1fr_1.5rem_0.5rem_auto] items-center supports-[grid-template-columns:subgrid]:grid-cols-subgrid',

    // Icon
    '[&>[data-slot=icon]]:col-start-1 [&>[data-slot=icon]]:row-start-1 [&>[data-slot=icon]]:mr-2.5 [&>[data-slot=icon]]:size-5 sm:[&>[data-slot=icon]]:mr-2 [&>[data-slot=icon]]:sm:size-4',
    '[&>[data-slot=icon]]:text-zinc-500 [&>[data-slot=icon]]:data-[focus]:text-white [&>[data-slot=icon]]:dark:text-zinc-500 [&>[data-slot=icon]]:data-[focus]:dark:text-white',
];

?>

@isset($href)
    <x-link
        :href="$href"
        x-menu:item
        x-bind:data-focus="$menuItem.isActive"
        x-bind:data-disabled="$menuItem.isDisabled"
        @class($classes)
        {{ $attributes->except('class') }}
    >
        {{ $slot }}
    </x-link>
@else
    <button
        type="button"
        x-menu:item
        x-bind:data-focus="$menuItem.isActive"
        x-bind:data-disabled="$menuItem.isDisabled"
        @class($classes)
        {{ $attributes->except('class') }}
    >
        {{ $slot }}
    </button>
@endisset
