<x-fieldset.label
    @click="$refs.toggle.click(); $refs.toggle.focus()"
    {{ $attributes }}
>
    {{ $slot }}
</x-fieldset.label>
