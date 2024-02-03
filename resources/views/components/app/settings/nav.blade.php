@props([
    'links' => [
        ['Dominios', route('app.settings.domains.index'), request()->is('app/settings/domains')],
        ['Contraseña', route('app.profile.password'), request()->is('app/profile/password')],
    ]
])

<nav class="flex gap-6">
    @foreach($links as [$label, $url, $active])
        <x-app.nav.item :href="$url" :$active>{{ $label }}</x-app.nav.item>
    @endforeach
</nav>
