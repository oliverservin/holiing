@props(['filters'])

<div class="flex justify-end gap-2">
    @foreach (\App\Livewire\App\Links\Analytics\Index\Range::cases() as $range)
        <x-button wire:click="$set('filters.range', '{{ $range }}')" plain :data-active="$range === $filters->range">
            {{ $range->label() }}
        </x-button>
    @endforeach
</div>
