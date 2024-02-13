@props([
    'links' => [
        ['Configuración', '/app/settings/domains', false],
    ],
])

<nav class="flex gap-6">
    @foreach ($links as [$label, $url, $active])
        <x-app.nav.item :href="$url" :$active>{{ $label }}</x-app.nav.item>
    @endforeach
</nav>
