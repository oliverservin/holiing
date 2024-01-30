<div {{ $attributes->except(['class']) }} @class([
    $attributes->get('class'),
    'col-span-full grid grid-cols-[1fr,auto] gap-x-12 px-3.5 pb-1 pt-2 text-sm/5 font-medium text-zinc-500 sm:px-3 sm:text-xs/5 dark:text-zinc-400'
])>
    {{ $slot }}
</div>
