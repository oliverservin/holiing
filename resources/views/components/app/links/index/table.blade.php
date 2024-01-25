<x-table>
    <x-table.head>
        <x-table.row>
            <x-table.header>Enlace</x-table.header>
            <x-table.header>Fecha</x-table.header>
            <x-table.header>Clics</x-table.header>
            <x-table.header>Último clic</x-table.header>
        </x-table.row>
    </x-table.head>

    <x-table.body>
        @foreach ($shortLinks as $shortLink)
            <x-table.row>
                <x-table.cell>
                    <div>
                        <div class="flex gap-2">
                            <h3 class="text-base font-semibold">
                                <a href="{{ 'https://' . $shortLink->domain->name . '/' . $shortLink->hashid }}">{{ $shortLink->domain->name . '/' . $shortLink->hashid }}</a>
                            </h3>
                            <button
                                x-data="{ copied: false, timeout: null }"
                                @click="
                                    navigator.clipboard.writeText('{{ url('/' . $shortLink->hashid) }}');
                                    clearTimeout(timeout);
                                    copied = true;
                                    timeout = setTimeout(() => { copied = false }, 1000);"
                                class="text-xs text-gray-600 font-semibold flex items-center gap-1.5"
                            >
                                <svg x-show="! copied" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M5.5 3.5A1.5 1.5 0 0 1 7 2h2.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 1 .439 1.061V9.5A1.5 1.5 0 0 1 12 11V8.621a3 3 0 0 0-.879-2.121L9 4.379A3 3 0 0 0 6.879 3.5H5.5Z" />
                                    <path d="M4 5a1.5 1.5 0 0 0-1.5 1.5v6A1.5 1.5 0 0 0 4 14h5a1.5 1.5 0 0 0 1.5-1.5V8.621a1.5 1.5 0 0 0-.44-1.06L7.94 5.439A1.5 1.5 0 0 0 6.878 5H4Z" />
                                </svg>
                                <span x-text="copied ? 'Copiado' : ''"></span>
                            </button>
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
                    {{ $shortLink->clicksForHumans() }}
                </x-table.cell>
                <x-table.cell class="text-zinc-500">
                    {{ $shortLink->lastClickedForHumans() }}
                </x-table.cell>
            </x-table.row>
        @endforeach
    </x-table.body>
</x-table>
