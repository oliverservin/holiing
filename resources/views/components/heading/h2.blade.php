<h2 {{ $attributes->merge([
    'class' => 'text-black dark:text-white/80 font-bold text-xl/[1.3] tracking-[-0.01em]'
]) }}>
    {{ $slot }}
</h2>
