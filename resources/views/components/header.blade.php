<x-container>
    <div class="h-20 flex items-center justify-between border-b border-zinc-100">
        <div>
            <a href="{{ url('/') }}" class="bg-black h-7 w-20 flex items-center justify-center rounded">
                <span class="uppercase font-semibold text-white text-xs tracking-wide">Holiing</span>
            </a>
        </div>
        <div>
            <x-button href="{{ route('app.dashboard') }}" outline>Dashboard</x-button>
        </div>
    </div>
</x-container>
