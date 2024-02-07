@aware(['bleed' => false, 'grid' => false])

<th {{ $attributes->except('class') }} @class([
    $attributes->get('class'),
    'border-b border-b-zinc-950/10 px-4 py-2 font-medium first:pl-[var(--gutter,theme(spacing.2))] last:pr-[var(--gutter,theme(spacing.2))] dark:border-b-white/10',
    'border-l border-l-zinc-950/5 first:border-l-0 dark:border-l-white/5' => $grid,
    'sm:first:pl-2 sm:last:pr-2' => ! $bleed,
])>
    {{ $slot }}
</th>
