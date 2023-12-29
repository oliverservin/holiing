<x-layouts.marketing>
    <x-slot:header>
        <x-container>
            <div class="h-20 flex items-center justify-between border-b border-zinc-100">
                <div>
                    <a href="{{ url('/') }}" class="bg-black h-7 w-20 flex items-center justify-center rounded">
                        <span class="uppercase font-semibold text-white text-xs tracking-wide">Holiing</span>
                    </a>
                </div>
                <div>
                    <x-button href="{{ route('dashboard') }}" outline>Dashboard</x-button>
                </div>
            </div>
        </x-container>
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
        <x-container>
            <div class="mt-16 pb-24">
                <div class="flex justify-between">
                    <div>
                        <a href="{{ url('/') }}" class="bg-black h-7 w-20 flex items-center justify-center rounded">
                            <span class="uppercase font-semibold text-white text-xs tracking-wide">Holiing</span>
                        </a>
                        <p class="text-sm mt-3 text-zinc-500">
                            © {{ date('Y') }} Holiing. Todos los derechos reservados.
                        </p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="https://twitter.com/oliverservin_" class="text-zinc-900 hover:text-zinc-800">
                            <span class="sr-only">Twitter</span>
                            <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                            </svg>
                        </a>
                        <a href="https://github.com/oliverservin/holiing" class="text-zinc-900 hover:text-zinc-800">
                            <span class="sr-only">GitHub</span>
                            <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </x-container>
    </x-slot:footer>
</x-layouts.marketing>
