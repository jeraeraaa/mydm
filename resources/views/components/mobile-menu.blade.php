<div class="lg:hidden" role="dialog" aria-modal="true" x-show="isOpen" @click.away="isOpen = false">
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div class="fixed inset-0 z-50"></div>
    <div
        class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                    alt="">
            </a>
            <button @click="isOpen = false" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Close menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
                <div class="space-y-2 py-6">
                    <a href="/"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Home</a>
                    <a href="/about"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">About</a>
                    <a href="/kegiatan"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Kegiatan</a>
                    <a href="/alat"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Alat</a>
                    <a href="/absensi"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Absensi</a>
                    <a href="/kontak"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Kontak</a>
                    <a href="/profil"
                        class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Profil</a>
                </div>
                <div class="py-6">
                    <a href="/login"
                        class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Log
                        in</a>
                    <a href="/register"
                        class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-orange-500 hover:bg-orange-500 hover:text-white">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
