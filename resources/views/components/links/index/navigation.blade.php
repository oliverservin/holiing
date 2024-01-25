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
