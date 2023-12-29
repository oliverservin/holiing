<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32">
    <link rel="icon" href="/favicon-16x16.png" type="image/png" sizes="16x16">

    @vite(['resources/css/app.css', 'resources/app/app.js'])

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
</head>
<body class="font-sans h-screen flex flex-col">
    <header>
        {{ $header ?? '' }}
    </header>
    <main class="flex-1">
        {{ $slot }}
    </main>
    <footer>
        {{ $footer ?? '' }}
    </footer>
</body>
</html>