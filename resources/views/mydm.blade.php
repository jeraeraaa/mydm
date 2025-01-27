<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@yield('meta_description', 'Default Description')">

    <link rel="icon" href="{{ asset('assets/img/mydmlogo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('assets/img/mydmlogo.png') }}" type="image/png">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>@yield('title', 'myDM')</title>
</head>

<body>
    <div class="bg-white" x-data="{ isOpen: false }">
        <header class="fixed inset-x-0 top-0 z-50">
            <x-navbar></x-navbar>
            <x-mobile-menu></x-mobile-menu>
        </header>

        <main>
            <div>
                <h1>@yield('title')</h1>
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
