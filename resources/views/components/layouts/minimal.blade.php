<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css'])
</head>
<body>
    <main class="mx-auto flex justify-center px-8 lg:px-16">
        <div class="py-12 w-full max-w-[50rem]">
            {{ $slot }}
        </div>
    </main>
</body>
</html>
