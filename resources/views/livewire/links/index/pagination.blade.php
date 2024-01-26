@if ($paginator->hasPages())
    <x-pagination>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <x-pagination.previous type="button" disabled>
                Anterior
            </x-pagination.previous>
        @else
            @if(method_exists($paginator,'getCursorName'))
                <x-pagination.previous type="button" dusk="previousPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled">
                    Anterior
                </x-pagination.previous>
            @else
                <x-pagination.previous type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}">
                    Anterior
                </x-pagination.previous>
            @endif
        @endif


        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            @if(method_exists($paginator,'getCursorName'))
                <x-pagination.next type="button" dusk="nextPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled">
                    Siguiente
                </x-pagination.next>
            @else
                <x-pagination.next type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}">
                    Siguiente
                </x-pagination.next>
            @endif
        @else
            <x-pagination.next type="button" disabled>
                Siguiente
            </x-pagination.next>
        @endif
    </x-pagination>
@endif
