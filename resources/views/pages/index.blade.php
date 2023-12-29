<x-layouts.marketing>
    <x-slot:header>
        <x-header />
    </x-slot:header>
    <x-container>
        <div class="pt-16 pb-20">
            <div class="grid grid-cols-12">
                <div class="col-span-7">
                    <h1 class="text-7xl font-extrabold tracking-tight leading-[1.1]">
                        <span class="text-indigo-600">Holiing</span>
                        <br>
                        Enlaces Cortos
                    </h1>
                    <p class=" font-medium text-zinc-500 mt-4 text-xl">
                        Plataforma de código abierto para crear y gestionar fácilmente enlaces cortos. Holiing es la alternativa en español a Bitly.
                    </p>
                    <div class="mt-12 flex gap-4">
                        <a href="{{ route('register') }}" class="bg-zinc-950 hover:bg-zinc-800 text-white px-6 h-12 flex items-center font-medium rounded-full">Comenzar</a>
                        <a href="https://github.com/oliverservin/holiing" class="bg-zinc-200 hover:bg-zinc-300 text-zinc-950 px-6 h-12 flex items-center font-medium rounded-full">Ver en Github</a>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
    <x-slot:footer>
        <x-footer />
    </x-slot:footer>
</x-layouts.marketing>
