<x-container>
    <div class="h-20 flex items-center justify-between border-b border-zinc-100">
        <div>
            <x-link href="{{ route('app.dashboard') }}" class="bg-black h-7 w-20 flex items-center justify-center rounded">
                <span class="uppercase font-semibold text-white text-xs tracking-wide">Holiing</span>
            </x-link>
        </div>
        <div>
            <x-link href="{{ route('app.settings.domains.index') }}" class="font-medium text-sm">Configuración</x-link>
        </div>
    </div>
</x-container>
