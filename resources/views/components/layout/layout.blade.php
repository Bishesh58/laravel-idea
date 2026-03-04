<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Idea Forge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-background text-foreground">
    <x-layout.nav />

    <main class="mx-auto w-full max-w-7xl px-6 py-6 pb-12">
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </main>
</body>

</html>
