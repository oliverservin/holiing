<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32">
    <link rel="icon" href="/favicon-16x16.png" type="image/png" sizes="16x16">

    @vite(['resources/css/app.css', 'resources/app/app.js'])
</head>
<body class="bg-zinc-50 font-sans dark:bg-zinc-950">
    {{ $slot }}
</body>
</html>
