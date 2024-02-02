<p {{ $attributes->merge([
    'class' => 'text-black/60 dark:text-white/60 text-base'
]) }}>
    {{ $slot }}
</p>
