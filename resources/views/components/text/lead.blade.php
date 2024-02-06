<p {{ $attributes->merge([
    'class' => 'text-zinc-500 dark:text-zinc-400 text-base'
]) }}>
    {{ $slot }}
</p>
