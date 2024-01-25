<div class="border-b border-b-zinc-950/10">
    <div class="border-b border-zinc-100">
        <x-container class="flex justify-between items-center h-[72px]">
            <div class="flex items-center gap-4">
                <x-logo />
            </div>
            <div class="flex items-center gap-4">
                <!-- Actions -->
                <div class="flex gap-4">
                    <x-navigation-menu.button href="{{ route('app.settings.domains.index') }}">
                        <x-icon.cog-6-tooth class="size-5" />
                    </x-navigation-menu.button>
                </div>
            </div>
        </x-container>
    </div>

    <x-container class="flex items-center h-16 gap-8">
        <div class="flex items-center gap-1">
            <x-navigation-menu.item href="{{ route('app.settings.domains.index') }}">
                Dominios
            </x-navigation-menu.item>

            <x-navigation-menu.item href="{{ route('app.profile.password') }}">
                Contraseña
            </x-navigation-menu.item>
        </div>
    </x-container>
</div>
