@props(['color' => 'zinc'])

@php

$classes = 'group relative inline-flex rounded-md focus:outline-none data-[focus]:outline data-[focus]:outline-2 data-[focus]:outline-offset-2 data-[focus]:outline-blue-500';

@endphp

@if ($attributes->has('href'))
    <x-link
        x-data="{ hovering: $useHover($refs.target), focusing: $useFocus($refs.target) }"
        x-ref="target"
        x-bind:data-hover="hovering"
        x-bind:data-focus="focusing"
        {{ $attributes->except(['class']) }} @class([
        $attributes->get('class'),
        $classes
    ])>
        <x-badge :color="$color">
            {{ $slot }}
        </x-badge>
    </x-link>
@else
    <button
        x-data="{ hovering: $useHover($refs.target), focusing: $useFocus($refs.target) }"
        x-ref="target"
        x-bind:data-hover="hovering"
        x-bind:data-focus="focusing"
        {{ $attributes->except(['class']) }}
        @class([
            $attributes->get('class'),
            $classes
        ])
    >
        <x-badge :color="$color">
            {{ $slot }}
        </x-badge>
    </button>
@endif
