<div class="lg:hidden" role="dialog" aria-modal="true" x-show="isOpen" @click.away="isOpen = false">
    <!-- Background backdrop -->
    <div class="fixed inset-0 z-50 bg-black opacity-25"></div>

    <div
        class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">Dharmayana</span>
                <img class="h-8 w-auto" src="/assets/img/logos/dm.png" alt="Logo Dharmayana">
            </a>
            <button @click="isOpen = false" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Close menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
                <div class="space-y-2 py-6">
                    <a href="/"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ Request::is('/') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                        Home
                    </a>
                    <a href="/about"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ Request::is('about') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                        About
                    </a>
                    <a href="{{ route('frontend-kegiatan.index') }}"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ Request::is('frontend-kegiatan*') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                        Kegiatan
                    </a>

                    @auth
                        @if (Auth::user()->role &&
                                (Auth::user()->role->name === 'anggota' ||
                                    Auth::user()->role->name === 'super_user' ||
                                    Auth::user()->role->name === 'admin' ||
                                    Auth::user()->role->name === 'inventaris'))
                            <a href="/frontend-peminjaman/alat"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ Request::is('frontend-peminjaman/alat*') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                                Alat
                            </a>
                        @endif
                        @if (Auth::user()->role &&
                                (Auth::user()->role->name === 'super_user' ||
                                    Auth::user()->role->name === 'admin' ||
                                    Auth::user()->role->name === 'inventaris'))
                            <a href="{{ route('dashboard') }}"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ Request::is('dashboard*') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                                Dashboard
                            </a>
                        @endif
                    @endauth

                    <a href="/contact"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ Request::is('contact') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                        Contact
                    </a>
                </div>

                <div class="py-6">
                    @auth
                        <div class="space-y-2">
                            <!-- Keranjang -->
                            <a href="/frontend-peminjaman/cart" class="flex items-center gap-2">
                                <img src="{{ asset('assets/img/cart.png') }}" alt="Keranjang" class="h-6 w-6">
                                <span id="cart-count" class="text-base font-semibold text-orange-500">
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                </span>
                            </a>

                            <!-- Profil -->
                            <a href="/profil/{{ Auth::user()->id_anggota }}"
                                class="flex items-center gap-2 {{ Request::is('profil/*') ? 'text-white' : 'hover:text-orange-500' }}">
                                <img class="w-8 h-8 rounded-full border-2"
                                    src="{{ file_exists(public_path('storage/foto_profil/' . Auth::user()->foto_profil)) && Auth::user()->foto_profil
                                        ? asset('storage/foto_profil/' . Auth::user()->foto_profil)
                                        : asset('assets/img/default-user.png') }}"
                                    alt="Foto Profil {{ Auth::user()->nama_anggota }}">
                                <span
                                    class="text-base font-semibold text-orange-500">{{ Auth::user()->nama_anggota }}</span>
                            </a>

                            <!-- Logout -->
                            <a href="{{ route('logout') }}"
                                class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 {{ Request::is('login') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                            Log in
                        </a>
                        <a href="{{ route('register') }}"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 {{ Request::is('register') ? 'bg-orange-500 text-white' : 'text-orange-500 hover:bg-orange-500 hover:text-white' }}">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
