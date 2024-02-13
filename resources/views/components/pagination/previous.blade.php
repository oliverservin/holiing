@props(['href', 'disabled' => false])

<span class="grow basis-0">
    <x-button :href="$href ?? null" :disabled="$disabled" plain aria-label="Previous page" {{ $attributes }}>
        <svg class="stroke-current" data-slot="icon" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <path d="M2.75 8H13.25M2.75 8L5.25 5.5M2.75 8L5.25 10.5" strokeWidth="{1.5}" strokeLinecap="round" strokeLinejoin="round" />
        </svg>
        {{ $slot->isEmpty() ? 'Previous' : $slot }}
    </x-button>
</span>
