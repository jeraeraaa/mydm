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

    </div>

</body>

</html>
