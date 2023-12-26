@props(['disabled'])

<div
    data-slot="label"
    {{ isset($disabled) ? 'data-disabled' : '' }}
    {{ $attributes->merge(['class' =>
        'select-none text-base/6 text-zinc-950 data-[disabled]:opacity-50 sm:text-sm/6 dark:text-white'
    ]) }}
>
    {{ $slot }}
</div>
