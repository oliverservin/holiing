<div class="border-b border-b-zinc-950/10">
    <div class="border-b border-b-zinc-950/10">
        <x-container class="flex justify-between items-center h-[72px]">
            <div class="flex items-center gap-4">
                <x-logo />
            </div>
            <div class="flex items-center gap-4">
                <!-- Actions -->
                <div class="flex gap-4">
                    <x-button href="{{ route('app.settings.domains.index') }}" plain>
                        <x-icon.16.solid.cog-6-tooth />
                    </x-button>
                </div>
            </div>
        </x-container>
    </div>

    <x-container class="flex items-center h-16 gap-8">
        <div class="flex items-center gap-2">
            <x-button href="{{ route('app.settings.domains.index') }}" :data-active="request()->is('app/settings/domains')" plain>
                Dominios
            </x-button>

            <x-button href="{{ route('app.profile.password') }}" :data-active="request()->is('app/profile/password')" plain>
                Contraseña
            </x-button>
        </div>
    </x-container>
</div>
