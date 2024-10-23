<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Home</title>
</head>

<body>
    <div class="bg-white" x-data="{ isOpen: false }">
        <header class="absolute inset-x-0 top-0 z-50">
            <x-navbar></x-navbar>
            <x-mobile-menu>/</x-mobile-menu>
        </header>


        <!-- Konten Utama -->
        <main class="pt-20"> <!-- Margin top ditambahkan agar tidak terhalang navbar -->
            <div class="container mx-auto px-4">
                @yield('content') <!-- Tempat untuk konten dari halaman lain, seperti login -->
            </div>
        </main>

        <!-- Flash Messages (Opsional) -->
        @if (session('status'))
            <div class="bg-green-500 text-white p-4 rounded-md text-center">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <!-- Scripts (jika ada tambahan script untuk halaman tertentu) -->
    @stack('scripts')

</body>

</html>
