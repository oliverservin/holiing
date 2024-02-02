@props([
    'links' => [
        ['Tarifas', '/', request()->is('tarifas')],
        ['Changelog', '/changelog', request()->is('changelog')],
        ['App', '/app/dashboard', false],
    ]
])

<nav class="flex gap-6">
    @foreach($links as [$label, $url, $active])
        <a href="{{ $url }}" @class([
                'flex items-center py-2 text-sm text-black dark:text-white/80 group',
                'font-semibold' => $active,
            ])
        >
            <span class="relative flex py-0.5">
                {{ $label }}
                <span @class([
                        'absolute opacity-0 group-hover:opacity-100 inset-x-0 bottom-0 h-0.5 bg-black/10 dark:bg-white/10',
                        'opacity-100' => $active,
                        'opacity-0' => ! $active,
                    ])
                ></span>
            </span>
        </a>
    @endforeach
</nav>
