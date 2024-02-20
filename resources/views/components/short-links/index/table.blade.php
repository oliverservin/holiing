<x-section>
    <x-short-links.index.search />

    <x-table>
        <x-table.head>
            <x-table.row>
                <x-table.header>Enlace</x-table.header>
                <x-table.header>
                    <x-short-links.index.sortable column="date" :$sortCol :$sortAsc>
                        <div>Fecha</div>
                    </x-short-links.index.sortable>
                </x-table.header>
                <x-table.header>
                    <x-short-links.index.sortable column="clics" :$sortCol :$sortAsc>
                        <div>Clics</div>
                    </x-short-links.index.sortable>
                </x-table.header>
                <x-table.header>
                    <x-short-links.index.sortable column="last_clicked" :$sortCol :$sortAsc>
                        <div>Último clic</div>
                    </x-short-links.index.sortable>
                </x-table.header>
                <x-table.header>
                    {{-- Dropdown menus... --}}
                </x-table.header>
            </x-table.row>
        </x-table.head>
        <x-table.body>
            @foreach ($shortLinks as $shortLink)
                <x-table.row>
                    <x-table.cell>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="max-w-[140px] truncate text-base font-semibold sm:max-w-[300px] md:max-w-[360px] xl:max-w-[500px]">
                                    <a href="{{ 'https://'.$shortLink->domain->name.'/'.$shortLink->hashid }}">
                                        {{ $shortLink->domain->name.'/'.$shortLink->hashid }}
                                    </a>
                                </h3>
                                @if ($shortLink->hasExpired())
                                    <x-badge color="red">Caducado</x-badge>
                                @endif

                                <button
                                    x-data
                                    @click="
                                        navigator.clipboard.writeText('{{ 'https://'.$shortLink->domain->name.'/'.$shortLink->hashid }}');
                                        $dispatch('notify', { content: 'Copiado al portapapeles.' });
                                "
                                    class="text-zinc-950/60 hover:text-zinc-950"
                                >
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.1667 4.08329V3.79163V3.79163C1.1667 3.52076 1.1667 3.38533 1.17794 3.27125C1.28705 2.16344 2.16352 1.28697 3.27133 1.17786C3.38541 1.16663 3.52084 1.16663 3.7917 1.16663H5.60004C6.90683 1.16663 7.56022 1.16663 8.05935 1.42094C8.49839 1.64465 8.85535 2.0016 9.07905 2.44065C9.33337 2.93978 9.33337 3.59317 9.33337 4.89996V5.59996C9.33337 6.90675 9.33337 7.56014 9.07905 8.05927C8.85535 8.49832 8.49839 8.85527 8.05935 9.07898C7.56022 9.33329 6.90682 9.33329 5.60004 9.33329H3.7917C3.52084 9.33329 3.38541 9.33329 3.27133 9.32206C2.16352 9.21295 1.28705 8.33648 1.17794 7.22867C1.1667 7.11459 1.1667 6.97916 1.1667 6.70829V6.70829V6.41663M9.43059 4.66663V4.66663C10.4266 4.66663 10.9246 4.66663 11.322 4.81618C11.9508 5.05287 12.4471 5.54917 12.6838 6.17804C12.8334 6.5754 12.8334 7.0734 12.8334 8.06941V9.09996C12.8334 10.4067 12.8334 11.0601 12.5791 11.5593C12.3553 11.9983 11.9984 12.3553 11.5593 12.579C11.0602 12.8333 10.4068 12.8333 9.10004 12.8333H8.06948C7.07347 12.8333 6.57547 12.8333 6.17812 12.6837C5.54925 12.4471 5.05294 11.9507 4.81626 11.3219C4.6667 10.9245 4.6667 10.4265 4.6667 9.43052V9.43052"
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </button>
                                @if ($shortLink->comments)
                                    <x-popover class="flex items-center">
                                        <button x-popover:button class="text-zinc-950/60 hover:text-zinc-950 focus:outline-none">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M2.33341 3.49951C1.60085 4.47455 1.16675 5.68662 1.16675 7.00008C1.16675 7.8745 1.35933 8.70398 1.70423 9.4485C1.97659 10.0364 2.23438 10.5377 2.0444 11.1988C1.95302 11.5168 1.724 11.83 1.6968 12.1611C1.6657 12.5398 1.99921 12.8467 2.37404 12.7842C3.13719 12.6571 3.50452 12.0503 4.38997 12.2585C4.48593 12.2811 4.73604 12.3705 5.23624 12.5494C5.76548 12.7388 6.33545 12.8334 7.00008 12.8334C10.2217 12.8334 12.8334 10.2217 12.8334 7.00008C12.8334 3.77842 10.2217 1.16675 7.00008 1.16675C6.17046 1.16675 5.38129 1.33994 4.66675 1.65213"
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                />
                                            </svg>
                                        </button>
                                        <x-popover.panel position="top-center">
                                            <div class="rounded-lg border border-zinc-200 px-4 py-3 text-sm text-zinc-950/80 shadow-lg">
                                                {{ $shortLink->comments }}
                                            </div>
                                        </x-popover.panel>
                                    </x-popover>
                                @endif
                            </div>
                            <p class="text-sm">
                                <a href="{{ $shortLink->url }}" class="text-zinc-500 hover:text-zinc-700 hover:underline">{{ $shortLink->url }}</a>
                            </p>
                        </div>
                    </x-table.cell>
                    <x-table.cell class="text-zinc-500">
                        {{ $shortLink->dateForHumans() }}
                    </x-table.cell>
                    <x-table.cell class="text-zinc-500">
                        <x-badge.button href="{{ route('short-links.analytics', ['shortLink' => $shortLink]) }}">
                            <div class="flex items-center gap-1">
                                <x-icon.chart-bar class="size-3" />
                                {{ $shortLink->clicksForHumans() }}
                            </div>
                        </x-badge.button>
                    </x-table.cell>
                    <x-table.cell class="text-zinc-500">
                        {{ $shortLink->lastClickedForHumans() }}
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center justify-end">
                            <x-short-links.index.row-dropdown :$shortLink />
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table.body>
    </x-table>

    {{-- Pagination... --}}
    <div class="flex justify-end">
        {{ $shortLinks->links('livewire.links.index.pagination') }}
    </div>
</x-section>
