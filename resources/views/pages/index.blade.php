<x-layouts.marketing>
    <x-slot:header>
        <x-header />
    </x-slot:header>
    <x-container>
        <div class="pt-16 pb-20 border-b border-zinc-100">
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
    <x-container>
        <div class="pt-16 pb-20">
            <p class="text text-xl font-semibold text-indigo-600">Pago único, sin suscripción.</p>
            <h2 class="text-[40px] font-bold">Comprar Holiing</h2>
            <p class="text-zinc-500 mt-4 text-xl max-w-3xl">
                Dos planes sencillos, cada uno con 30 días de prueba gratuita. No necesitas tarjeta de crédito.
            </p>
            <div class="mt-12 grid lg:grid-cols-2 gap-8">
                <div class="p-12 border border-zinc-200 rounded-lg shadow-lg">
                    <p class="text-sm font-semibold text-indigo-600">Básico</p>
                    <h5 class="text-[32px] font-bold tracking-tight mt-2">$490 <span class="text-sm">MXN/año</span></h5>
                    <p class="text-zinc-500">Hasta 1,000 clics/mes</p>
                    <ul class="list-disc ml-5 mt-8 text-zinc-500">
                        <li>Enlaces ilimitados</li>
                    </ul>
                    <div class="flex mt-16">
                        <a href="{{ route('register') }}" class="bg-zinc-950 hover:bg-zinc-800 text-white px-6 h-12 flex items-center justify-center font-medium rounded-full">Pruébalo gratis</a>
                    </div>
                </div>
                <div class="p-12 border border-zinc-200 rounded-lg">
                    <p class="text-sm font-semibold text-indigo-600">Pro</p>
                    <h5 class="text-[32px] font-bold tracking-tight mt-2">$790 <span class="text-sm">MXN/año</span></h5>
                    <p class="text-zinc-500">Hasta 50,000 clics/mes</p>
                    <ul class="list-disc ml-5 mt-8 text-zinc-500">
                        <li>Enlaces ilimitados</li>
                    </ul>
                    <div class="flex mt-16">
                        <a href="{{ route('register') }}" class="bg-zinc-950 hover:bg-zinc-800 text-white px-6 h-12 flex items-center justify-center font-medium rounded-full">Pruébalo gratis</a>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
    <x-slot:footer>
        <x-footer />
    </x-slot:footer>
</x-layouts.marketing>
