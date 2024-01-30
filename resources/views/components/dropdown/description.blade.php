<div
    data-slot="description"
    {{ $attributes->except(['class']) }} @class([
    $attributes->get('class'),
    'col-span-2 col-start-2 row-start-2 text-sm/5 text-zinc-500 group-data-[focus]:text-white sm:text-xs/5 dark:text-zinc-400 forced-colors:group-data-[focus]:text-[HighlightText]'
])>
    {{ $slot }}
</div>
