<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32">
    <link rel="icon" href="/favicon-16x16.png" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

    <script defer type="module">
        import { useHover, useFocus } from '/alpine-hooks.js'

        document.addEventListener('alpine:init', () => {
            Alpine.plugin(useHover)
            Alpine.plugin(useFocus)
        })
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/anchor@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/ui@3.13.3-beta.4/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css'])
</head>
<body class="font-sans bg-white dark:bg-zinc-900 text-zinc-950 dark:text-white">
    {{ $slot }}

    <x-support-bubble />

    <x-app.notifications />
</body>
</html>
