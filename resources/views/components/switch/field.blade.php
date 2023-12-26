<x-switch.field-headless
    data-slot="field"
    {{ $attributes->merge(['class' => Arr::toCssClasses([
        'grid grid-cols-[1fr_auto] items-center gap-x-8 gap-y-1 sm:grid-cols-[1fr_auto]',

        // Control layout
        '[&>[data-slot=control]]:col-start-2 [&>[data-slot=control]]:self-center',

        // Label layout
        '[&>[data-slot=label]]:col-start-1 [&>[data-slot=label]]:row-start-1 [&>[data-slot=label]]:justify-self-start',

        // Description layout
        '[&>[data-slot=description]]:col-start-1 [&>[data-slot=description]]:row-start-2',

        // With description
        '[&_[data-slot=label]]:has-[[data-slot=description]]:font-medium'
    ])]) }}
>
    {{ $slot }}
</x-switch.field-headless>
