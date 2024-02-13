@props([
    'links' => [
        ['Tarifas', '/', request()->is('tarifas')],
        ['Changelog', '/changelog', request()->is('changelog')],
        ['App', '/app/dashboard', false],
    ],
])

<nav class="flex gap-6">
    @foreach ($links as [$label, $url, $active])
        <a
            href="{{ $url }}"
            @class([
                'group flex items-center py-2 text-sm text-zinc-950 dark:text-white',
                'font-semibold' => $active,
            ])
        >
            <span class="relative flex py-0.5">
                {{ $label }}
                <span
                    @class([
                        'absolute inset-x-0 bottom-0 h-0.5 bg-zinc-950/10 opacity-0 group-hover:opacity-100 dark:bg-white/10',
                        'opacity-100' => $active,
                        'opacity-0' => ! $active,
                    ])
                ></span>
            </span>
        </a>
    @endforeach
</nav>
