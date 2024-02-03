@props(['href', 'disabled' => false])

<span class="flex grow basis-0 justify-end">
    <x-button :href="$href ?? null" size="sm" :disabled="$disabled" plain aria-label="Previous page" {{ $attributes }}>
        {{ $slot->isEmpty() ? 'Next' : $slot }}
        <svg class="stroke-current size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <path
                d="M13.25 8L2.75 8M13.25 8L10.75 10.5M13.25 8L10.75 5.5"
                strokeWidth={1.5}
                strokeLinecap="round"
                strokeLinejoin="round"
            />
        </svg>
    </x-button>
</span>
