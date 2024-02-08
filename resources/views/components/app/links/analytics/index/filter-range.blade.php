@props(['filters'])

<div>
    @foreach (\App\Livewire\App\Links\Analytics\Index\Range::cases() as $range)
        <x-button wire:click="$set('filters.range', '{{ $range }}')" color="light">
            {{ $range->label() }}
        </x-button>
    @endforeach
</div>
