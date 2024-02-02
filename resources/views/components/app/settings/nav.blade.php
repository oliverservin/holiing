@props([
    'links' => [
        ['Dominios', route('app.settings.domains.index'), request()->is('app/settings/domains')],
        ['Contraseña', route('app.profile.password'), request()->is('app/profile/password')],
    ]
])

<nav class="flex gap-6">
    @foreach($links as [$label, $url, $active])
        <x-link href="{{ $url }}" @class([
                'flex items-center py-2 text-sm',
                'text-black dark:text-white/80' => ! $active,
                'text-black/60 dark:text-white/60' => $active,
            ])
        >
            {{ $label }}
        </x-link>
    @endforeach
</nav>
