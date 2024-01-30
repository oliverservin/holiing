<div
    data-slot="label"
    {{ $attributes->except(['class']) }} @class([
    $attributes->get('class'),
    'col-start-2 row-start-1'
])>
    {{ $slot }}
</div>
