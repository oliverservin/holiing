<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/app/app.js'])
</head>
<body class="bg-zinc-50 font-sans dark:bg-zinc-950">
    {{ $slot }}
</body>
</html>
