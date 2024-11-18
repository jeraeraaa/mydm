<nav class="absolute inset-x-0 top-0 z-50 bg-white shadow-md flex items-center justify-between p-6 lg:px-8"
    aria-label="Global">
    <div class="flex lg:flex-1">
        <a href="/" class="-m-1.5 p-1.5">
            <span class="sr-only">Dharmayana</span>
            <img class="h-12 w-auto" src="/assets/img/logos/dm.png" alt="Logo Dharmayana">
        </a>
    </div>

    <div class="flex lg:hidden">
        <button @click="isOpen=true" type="button"
            class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Open main menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <div class="hidden lg:flex lg:gap-x-12">
        <a href="/"
            class="text-sm font-semibold leading-6 {{ Request::is('/') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">Home</a>
        <a href="/about"
            class="text-sm font-semibold leading-6 {{ Request::is('about') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">About</a>
        <a href="{{ route('frontend-kegiatan.index') }}"
            class="text-sm font-semibold leading-6 {{ Request::is('frontend-kegiatan') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">
            Kegiatan
        </a>


        @auth
            @if (
                (Auth::user()->role && Auth::user()->role->name === 'anggota') ||
                    Auth::user()->role->name === 'super_user' ||
                    Auth::user()->role->name === 'admin' ||
                    Auth::user()->role->name === 'inventaris')
                <!-- Link khusus untuk pengguna dengan role 'anggota' -->
                <a href="/frontend-peminjaman/alat"
                    class="text-sm font-semibold leading-6 {{ Request::is('frontend-peminjaman/alat*') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">
                    Alat
                </a>
            @endif
        @endauth

        @auth
            @if (
                (Auth::user()->role && Auth::user()->role->name === 'super_user') ||
                    Auth::user()->role->name === 'admin' ||
                    Auth::user()->role->name === 'inventaris')
                <a href={{ route('dashboard') }}
                    class="text-sm font-semibold leading-6 {{ Request::is('dashboard*') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">
                    Dashboard
                </a>
            @endif
        @endauth


        <a href="/contact"
            class="text-sm font-semibold leading-6 {{ Request::is('contact') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">Contact</a>
    </div>

    <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        @auth
            @if (
                (Auth::user()->role && Auth::user()->role->name === 'anggota') ||
                    Auth::user()->role->name === 'super_user' ||
                    Auth::user()->role->name === 'admin' ||
                    Auth::user()->role->name === 'inventaris')
                <!-- Icon Keranjang (Cart) -->
                <a href="/frontend-peminjaman/cart" class="flex items-center">
                    <img src="{{ asset('assets/img/cart.png') }}" alt="Keranjang" class="h-8 w-8">
                    <span id="cart-count" class="ml-1 text-sm font-semibold text-orange-500">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>
                <a href="/profil"
                    class="text-sm font-semibold leading-6 {{ Request::is('profil') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">Profil</a>
            @endif
        @endauth
        @guest
            <a href="{{ route('login') }}"
                class="text-sm font-semibold leading-6 {{ Request::is('login') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">Log
                in</a>
            <a href="{{ route('register') }}"
                class="ml-4 text-sm font-semibold leading-6 {{ Request::is('register') ? 'bg-orange-500 text-white rounded-full px-4 py-2' : 'text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2' }}">Register</a>
        @else
            <a href="{{ route('logout') }}"
                class="text-sm font-semibold leading-6 text-orange-500 hover:bg-orange-500 hover:text-white rounded-full px-4 py-2"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest
    </div>
</nav>
