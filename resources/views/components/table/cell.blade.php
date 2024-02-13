@aware(['bleed' => false, 'dense' => false, 'grid' => false, 'striped' => false, 'href', 'target', 'title'])

<td
    {{ $attributes->except('class') }}
    @class([
        $attributes->get('class'),
        'relative px-4 first:pl-[var(--gutter,theme(spacing.2))] last:pr-[var(--gutter,theme(spacing.2))]',
        'border-b border-zinc-950/5 dark:border-white/5' => ! $striped,
        'border-l border-l-zinc-950/5 first:border-l-0 dark:border-l-white/5' => $grid,
        'py-2.5' => $dense,
        'py-4' => ! $dense,
        'sm:first:pl-2 sm:last:pr-2' => ! $bleed,
    ])
>
    @if (isset($href))
        <x-link data-row-link href="{{ $href }}" target="{{ $target }}" aria-label="{{ $title }}" class="absolute inset-0 focus:outline-none"></x-link>
    @endif

    {{ $slot }}
</td>
