@props([
    'links' => [
        ['Dominios', route('settings.domains.index'), request()->is('settings/domains')],
        ['Contraseña', route('profile.password'), request()->is('profile/password')],
    ],
])

<nav class="flex gap-6">
    @foreach ($links as [$label, $url, $active])
        <x-nav.item :href="$url" :$active>{{ $label }}</x-nav.item>
    @endforeach
</nav>
