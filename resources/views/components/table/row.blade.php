@props(['href', 'target', 'title'])
@aware(['striped' => false])

<tr
    {{ $attributes->except('class') }}
    @class([
        $attributes->get('class'),
        'has-[[data-row-link][data-focus]]:outline has-[[data-row-link][data-focus]]:outline-2 has-[[data-row-link][data-focus]]:-outline-offset-2 has-[[data-row-link][data-focus]]:outline-blue-500 dark:focus-within:bg-white/[2.5%]' => isset($href),
        'even:bg-zinc-950/[2.5%] dark:even:bg-white/[2.5%]' => $striped,
        'hover:bg-zinc-950/5 dark:hover:bg-white/5' => isset($href) && $striped,
        'hover:bg-zinc-950/[2.5%] dark:hover:bg-white/[2.5%]' => isset($href) && ! $striped,
    ])
>
    {{ $slot }}
</tr>
