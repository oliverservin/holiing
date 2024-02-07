@aware(['disabled' => false])

<div
    data-slot="legend"
    {{ $disabled ? 'data-disabled' : '' }}
    {{ $attributes->merge(['class' => 'text-base/6 font-semibold text-zinc-950 data-[disabled]:opacity-50 sm:text-sm/6 dark:text-white']) }}
>
    {{ $slot }}
</div>
