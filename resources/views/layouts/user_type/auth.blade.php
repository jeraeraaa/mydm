@extends('layouts.dash_app')

@section('auth')
    @if (Request::is('profile'))
        <!-- Tampilan untuk halaman Profile -->
        @include('layouts.navbars.auth.sidebar')
        <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
            @include('layouts.navbars.auth.nav')
            @yield('content')
        </div>
    @else
        <!-- Tampilan untuk halaman lain -->
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
                @include('layouts.footers.auth.footer')
            </div>
        </main>
    @endif

    @include('components.fixed-plugin')
@endsection

@section('scripts')
    <script src="{{ asset('js/anggota.js') }}"></script>
@endsection
