<label
    {{ $attributes->merge(['class' =>
        'block text-sm font-semibold leading-5 text-black/80 dark:text-white/80'
    ]) }}
>
    {{ $slot }}
</label>
