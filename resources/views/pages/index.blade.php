<x-layouts.marketing>
    <x-slot:header>
        <x-marketing.header />
    </x-slot>
    <x-container>
        <div class="border-b border-zinc-100 pb-20 pt-16">
            <div class="grid grid-cols-12">
                <div class="col-span-7">
                    <h1 class="text-7xl font-extrabold leading-[1.1] tracking-tight">
                        <span class="text-indigo-600">Holiing</span>
                        <br />
                        Enlaces Cortos
                    </h1>
                    <p class="mt-4 text-xl font-medium text-zinc-500">
                        Plataforma de código abierto para crear y gestionar fácilmente enlaces cortos. Holiing es la alternativa en español a Bitly.
                    </p>
                    <div class="mt-12 flex gap-4">
                        <a
                            href="{{ route('register') }}"
                            class="flex h-12 items-center rounded-full bg-zinc-950 px-6 font-medium text-white hover:bg-zinc-800"
                        >
                            Comenzar
                        </a>
                        <a
                            href="https://github.com/oliverservin/holiing"
                            class="flex h-12 items-center rounded-full bg-zinc-200 px-6 font-medium text-zinc-950 hover:bg-zinc-300"
                        >
                            Ver en Github
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
    <x-container>
        <div class="pb-20 pt-16">
            <p class="text text-xl font-semibold text-indigo-600">Pago único, sin suscripción.</p>
            <h2 class="text-[40px] font-bold">Comprar Holiing</h2>
            <p class="mt-4 max-w-3xl text-xl text-zinc-500">Dos planes sencillos, cada uno con 30 días de prueba gratuita. No necesitas tarjeta de crédito.</p>
            <div class="mt-12 grid gap-8 lg:grid-cols-2">
                <div class="rounded-lg border border-zinc-200 p-12 shadow-lg">
                    <p class="text-sm font-semibold text-indigo-600">Básico</p>
                    <h5 class="mt-2 text-[32px] font-bold tracking-tight">
                        $490
                        <span class="text-sm">MXN/año</span>
                    </h5>
                    <p class="text-zinc-500">Hasta 1,000 clics/mes</p>
                    <ul class="ml-5 mt-8 list-disc text-zinc-500">
                        <li>Enlaces ilimitados</li>
                    </ul>
                    <div class="mt-16 flex">
                        <a
                            href="{{ route('register') }}"
                            class="flex h-12 items-center justify-center rounded-full bg-zinc-950 px-6 font-medium text-white hover:bg-zinc-800"
                        >
                            Pruébalo gratis
                        </a>
                    </div>
                </div>
                <div class="rounded-lg border border-zinc-200 p-12">
                    <p class="text-sm font-semibold text-indigo-600">Pro</p>
                    <h5 class="mt-2 text-[32px] font-bold tracking-tight">
                        $790
                        <span class="text-sm">MXN/año</span>
                    </h5>
                    <p class="text-zinc-500">Hasta 50,000 clics/mes</p>
                    <ul class="ml-5 mt-8 list-disc text-zinc-500">
                        <li>Enlaces ilimitados</li>
                    </ul>
                    <div class="mt-16 flex">
                        <a
                            href="{{ route('register') }}"
                            class="flex h-12 items-center justify-center rounded-full bg-zinc-950 px-6 font-medium text-white hover:bg-zinc-800"
                        >
                            Pruébalo gratis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
    <x-slot:footer>
        <x-marketing.footer />
    </x-slot>
</x-layouts.marketing>
