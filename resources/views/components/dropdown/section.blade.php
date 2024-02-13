<div
    {{ $attributes->except(['class']) }}
    @class([
        $attributes->get('class'),
        // Define grid at the section level instead of the item level if subgrid is supported
        'col-span-full supports-[grid-template-columns:subgrid]:grid supports-[grid-template-columns:subgrid]:grid-cols-[auto_1fr_1.5rem_0.5rem_auto]',
    ])
>
    {{ $slot }}
</div>
