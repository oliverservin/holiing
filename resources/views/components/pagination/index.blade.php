<nav aria-label="Pagination Navigation" {{ $attributes->except(['class']) }} @class([
    $attributes->get('class'),
    'flex gap-x-2',
])>
    {{ $slot }}
</nav>
