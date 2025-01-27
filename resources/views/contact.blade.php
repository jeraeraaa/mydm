@extends('mydm')
@section('title', 'Contact - myDM')
@section('content')
    <main class="relative isolate px-6 pt-8 lg:px-8 bg-gray-50">
        <!-- Contact -->
        <div class="max-w-7xl px-4 lg:px-6  py-12 lg:py-24 mx-auto">
            <div class="mb-6 sm:mb-10 max-w-3xl text-center mx-auto">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Contact Us</h2>
                </h2>
                <p class="text-gray-600 mt-3">Jika ada pertanyaan, jangan ragu untuk menghubungi kami melalui informasi di
                    bawah ini.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 lg:items-center gap-6 md:gap-8 lg:gap-12">
                <!-- Image Section -->
                <div class="aspect-w-16 aspect-h-6 lg:aspect-h-14 overflow-hidden bg-gray-100 rounded-2xl">
                    <img class="group-hover:scale-105 group-focus:scale-105 transition-transform duration-500 ease-in-out object-cover rounded-2xl"
                        src="/assets/img/dwpp.jpeg" alt="Gambar Kontak">
                </div>
                <!-- End Image Section -->

                <!-- Contact Details -->
                <div class="space-y-8 lg:space-y-16">
                    <!-- Address -->
                    <div>
                        <h3 class="mb-5 font-semibold text-black">
                            Alamat Kami
                        </h3>
                        <div class="flex gap-4">
                            <svg class="shrink-0 size-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <div class="grow">
                                <p class="text-sm text-gray-600">
                                    Sekretariat Dharmayana
                                </p>
                                <address class="mt-1 text-black not-italic">
                                    Jl. Letjen S. Parman No.1, Kampus 1 Universitas Tarumanagara<br>
                                    Gedung M , Lantai 2, Grogol Petamburan, Jakarta Barat 11440
                                </address>
                            </div>
                        </div>
                    </div>
                    <!-- End Address -->

                    <!-- Contacts -->
                    <div>
                        <h3 class="mb-5 font-semibold text-black">
                            Informasi Kontak
                        </h3>
                        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6 md:gap-8 lg:gap-12">
                            <!-- Email -->
                            <div class="flex gap-4">
                                <svg class="shrink-0 size-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z">
                                    </path>
                                    <path d="m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10"></path>
                                </svg>
                                <div class="grow">
                                    <p class="text-sm text-gray-600">
                                        Email Kami
                                    </p>
                                    <p>
                                        <a class="relative inline-block font-medium text-black before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-lime-400 hover:before:bg-orange-500 focus:outline-none focus:before:bg-black"
                                            href="mailto:dharmayana_untar@yahoo.com">
                                            dharmayana_untar@yahoo.com
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <!-- End Email -->

                            <!-- Phone -->
                            <div class="flex gap-4">
                                <svg class="shrink-0 size-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                                <div class="grow">
                                    <p class="text-sm text-gray-600">
                                        Telepon Kami
                                    </p>
                                    <p>
                                        <a class="relative inline-block font-medium text-black before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-lime-400 hover:before:bg-black focus:outline-none focus:before:bg-black"
                                            href="tel:+621234567">
                                            +62 123 4567
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <!-- End Phone -->
                        </div>
                    </div>
                    <!-- End Contacts -->
                </div>
                <!-- End Contact Details -->
            </div>
        </div>
        <!-- End Contact -->
    </main>

    <x-footers></x-footers>
@endsection
