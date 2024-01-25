@props(['color' => 'zinc'])

@if ($attributes->has('href'))
    <x-link {{ $attributes->except(['class']) }} @class([
        $attributes->get('class'),
        'group relative inline-flex rounded-md focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500'
    ])>
        <x-badge :color="$color">
            {{ $slot }}
        </x-badge>
    </x-link>
@else
    <button {{ $attributes->except(['class']) }} @class([
        $attributes->get('class'),
        'group relative inline-flex rounded-md focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500'
    ])>
        <x-badge :color="$color">
            {{ $slot }}
        </x-badge>
    </button>
@endif
