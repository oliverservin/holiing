<x-container>
    <div class="h-20 flex items-center justify-between border-b border-zinc-100">
        <div>
            <a href="{{ route('dashboard') }}" class="bg-black h-7 w-20 flex items-center justify-center rounded">
                <span class="uppercase font-semibold text-white text-xs tracking-wide">Holiing</span>
            </a>
        </div>
        <div>
            <a href="{{ route('settings.domains.index') }}" class="font-medium text-sm">Configuración</a>
        </div>
    </div>
</x-container>
