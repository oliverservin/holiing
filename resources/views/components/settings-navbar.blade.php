<x-container>
    <div class="h-16 flex items-center justify-between">
        <div>
            <x-link href="{{ route('app.settings.domains.index') }}" class="font-extrabold">
                Configuración
            </x-link>
        </div>
        <div class="text-sm flex gap-5">
            <x-link href="{{ route('app.settings.domains.index') }}" class="hover:underline">Dominios</x-link>
            <x-link href="{{ route('app.profile.password') }}" class="hover:underline">Contraseña</x-link>
        </div>
    </div>
</x-container>
