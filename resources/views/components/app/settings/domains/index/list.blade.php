<div class="space-y-6">
    @foreach($domains as $domain)
        <div wire:key="{{ $domain->id }}" class="bg-gray-aluminum dark:bg-gray-flat rounded-md p-8">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between">
                    <div>
                        <a href="https://{{ $domain->name }}" class="text-black dark:text-white/80 font-bold text-xl/[1.3] tracking-[-0.01em]">{{ $domain->name }}</a>
                    </div>
                    @unless ($domain->validated_at)
                        <div>
                            <x-button size="sm" wire:click="validateDomain({{ $domain->id }})" outline>Validar</x-button>
                        </div>
                    @endunless
                </div>
                <div class="flex gap-4">
                    @if ($domain->validated_at)
                        <x-badge color="blue">Configuración válida</x-badge>
                        @unless ($domain->verified_at)
                            <x-badge color="yellow">Verificación pendiente</x-badge>
                        @endunless
                    @else
                        <x-badge color="yellow">Validación pendiente</x-badge>
                    @endif
                </div>
                @unless ($domain->validated_at)
                    <x-divider />
                    <div>
                        <x-text>Para configurar tu dominio <x-text.code>{{ $domain->name }}</x-text.code>, configura los siguiente registros A y AAAA con tu proveedor de DNS:</x-text>
                        <div class="flex gap-4 mt-5 text-black/60 dark:text-white/60 text-sm/[1.4]">
                            <div class="flex flex-col gap-2">
                                <div class="font-medium">Type</div>
                                <div>A</div>
                                <div>AAAA</div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="font-medium">Name</div>
                                <div>@</div>
                                <div>@</div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="font-medium">Value</div>
                                <div>66.241.125.98</div>
                                <div>2a09:8280:1::2d:d701</div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="font-medium">TTL</div>
                                <div>86400</div>
                                <div>86400</div>
                            </div>
                        </div>
                        <x-text class="mt-5">Nota: para el TTL, si <x-text.code>86400</x-text.code> no está disponible, establece el valor más alto posible. Además, la propagación de dominios puede tardar entre 1 y 12 horas.</x-text>
                    </div>
                @endunless
                @if ($domain->validated_at && ! $domain->verified_at)
                    <x-divider />

                    <div>
                        <x-text>Tu dominio ha sido configurado correctamente. Por favor, <x-text.strong>espera hasta 24 horas</x-text.strong> para que manualmente verifiquemos y activemos tu dominio. Te enviaremos una notificación por email cuando haya sido verificado.</x-text>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
