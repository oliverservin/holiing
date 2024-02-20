<div
    x-data
    x-popover
    {{ $attributes->except(['class']) }}
    @class([
        $attributes->get('class'),
        'relative',
    ])
>
    {{ $slot }}
</div>
