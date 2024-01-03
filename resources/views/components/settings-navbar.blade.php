<x-container>
    <div class="h-16 flex items-center justify-between">
        <div>
            <a href="{{ url('/') }}" class=" font-extrabold">
                Configuración
            </a>
        </div>
        <div class="text-sm flex gap-5">
            <a href="{{ route('settings.domains') }}" class="hover:underline">Dominios</a>
            <a href="{{ route('profile.password') }}" class="hover:underline">Contraseña</a>
        </div>
    </div>
</x-container>
