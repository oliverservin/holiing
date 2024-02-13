<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32" />
        <link rel="icon" href="/favicon-16x16.png" type="image/png" sizes="16x16" />

        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/anchor@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://unpkg.com/@alpinejs/ui@3.13.3-beta.4/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-zinc-50 font-sans dark:bg-zinc-950">
        <div class="mx-auto flex min-h-screen max-w-lg flex-row items-center px-8 pb-24 pt-12">
            {{ $slot }}
        </div>
    </body>
</html>
