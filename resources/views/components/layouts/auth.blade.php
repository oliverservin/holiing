<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32">
        <link rel="icon" href="/favicon-16x16.png" type="image/png" sizes="16x16">

        <!-- Scripts -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-zinc-50 font-sans dark:bg-zinc-950">
        <div class="min-h-screen flex flex-row items-center max-w-lg mx-auto px-8 pt-12 pb-24">
            {{ $slot }}
        </div>
    </body>
</html>
