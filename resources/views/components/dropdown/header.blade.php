<div
    {{ $attributes->except(['class']) }}
    @class([
        $attributes->get('class'),
        'col-span-5 px-3.5 pb-1 pt-2.5 sm:px-3',
    ])
>
    {{ $slot }}
</div>
