@props(['anchor' => 'bottom'])

<div
    x-menu:items
    items
    x-anchor.{{ $anchor }}.offset.8="document.getElementById($id('alpine-menu-button'))"
    {{ $attributes->except('class') }}
    @class([
        $attributes->get('class'),

        // Anchor positioning
        '[--anchor-gap:theme(spacing.2)] [--anchor-padding:theme(spacing.3)] data-[anchor~=end]:[--anchor-offset:4px] data-[anchor~=start]:[--anchor-offset:-4px]',

        // Base styles
        'isolate w-max rounded-xl p-1 z-10',

        // Invisible border that is only visible in `forced-colors` mode for accessibility purposes
        'outline outline-1 outline-transparent focus:outline-none',

        // Handle scrolling when menu won't fit in viewport
        'overflow-y-auto',

        // Popover background
        'bg-white/75 backdrop-blur-xl dark:bg-zinc-800/75',

        // Shadows
        'shadow-lg ring-1 ring-zinc-950/10 dark:ring-inset dark:ring-white/10',

        // Define grid at the menu level if subgrid is supported
        'supports-[grid-template-columns:subgrid]:grid supports-[grid-template-columns:subgrid]:grid-cols-[auto_1fr_1.5rem_0.5rem_auto]'
    ])
>
    {{ $slot }}
</div>
