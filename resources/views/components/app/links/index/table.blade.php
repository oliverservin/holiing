<x-app.section>
    <x-app.links.index.search />

    <x-table>
        <x-table.head>
            <x-table.row>
                <x-table.header>Enlace</x-table.header>
                <x-table.header>
                    <x-app.links.index.sortable column="date" :$sortCol :$sortAsc>
                        <div>Fecha</div>
                    </x-app.links.index.sortable>
                </x-table.header>
                <x-table.header>
                    <x-app.links.index.sortable column="clics" :$sortCol :$sortAsc>
                        <div>Clics</div>
                    </x-app.links.index.sortable>
                </x-table.header>
                <x-table.header>
                    <x-app.links.index.sortable column="last_clicked" :$sortCol :$sortAsc>
                        <div>Último clic</div>
                    </x-app.links.index.sortable>
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
                                <x-badge.button
                                    x-data
                                    @click="
                                        navigator.clipboard.writeText('{{ 'https://' . $shortLink->domain->name . '/' . $shortLink->hashid }}');
                                        $dispatch('notify', { content: 'Copiado al portapapeles.' });
                                "
                                >
                                    <x-icon.16.solid.document-duplicate class="size-3.5" />
                                </x-badge.button>
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
                        <x-badge.button href="{{ route('app.links.analytics', ['shortLink' => $shortLink]) }}">
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
                            <x-app.links.index.row-dropdown :$shortLink />
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
</x-app.section>
