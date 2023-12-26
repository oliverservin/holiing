@props(['disabled'])

<div
    data-slot="description"
    {{ isset($disabled) ? 'data-disabled' : '' }}
    {{ $attributes->merge(['class' =>
        'text-base/6 text-zinc-500 data-[disabled]:opacity-50 sm:text-sm/6 dark:text-zinc-400'
    ]) }}
>
    {{ $slot }}
</div>
