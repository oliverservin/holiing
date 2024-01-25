@props([
    'bleed' => false,
    'dense' => false,
    'grid' => false,
    'striped' => false,
])

<div class="flow-root">
    <div {{ $attributes->merge(['class' => '-mx-[--gutter] overflow-x-auto whitespace-nowrap']) }}>
        <div @class([
            'inline-block min-w-full align-middle',
            'sm:px-[--gutter]' => ! $bleed,
        ])>
            <table class="min-w-full text-left text-sm/6">
                {{ $slot }}
            </table>
        </div>
    </div>
</div>
