<div
    data-slot="control"
    {{ $attributes->except(['class']) }}
    @class([
        $attributes->get('class'),

        // Basic groups
        'space-y-3 [&_[data-slot=label]]:font-normal',

        // With descriptions
        'has-[[data-slot=description]]:space-y-6 [&_[data-slot=label]]:has-[[data-slot=description]]:font-medium',
    ])
    x-bind:data-checked="$switch.isChecked"
>
    {{ $slot }}
</div>
