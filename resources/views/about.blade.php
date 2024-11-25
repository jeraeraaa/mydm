@extends('mydm')
@section('title', 'About - myDM')
@section('content')

    <main class="relative isolate px-6 pt-28 lg:px-8 bg-gray-50">
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-10 mx-auto">
            <!-- Grid -->
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
                <div class="lg:col-span-7">
                    <!-- Grid -->
                    <div class="grid grid-cols-12 gap-2 sm:gap-6 items-center lg:-translate-x-10">
                        <div class="col-span-4">
                            <img class="rounded-xl" src="/assets/img/foto2.jpeg" alt="Foto1">
                        </div>
                        <!-- End Col -->

                        <div class="col-span-3">
                            <img class="rounded-xl" src="/assets/img/foto3.jpg" alt="MBD">
                        </div>
                        <!-- End Col -->

                        <div class="col-span-5">
                            <img class="rounded-xl" src="/assets/img/bd71.jpeg" alt="MBDD">
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Grid -->
                </div>
                <!-- End Col -->

                <div class="mt-5 sm:mt-10 lg:mt-0 lg:col-span-5">
                    <div class="space-y-6 sm:space-y-8">
                        <!-- Title -->
                        <div class="space-y-2 md:space-y-4">
                            <h2 class="font-bold text-3xl lg:text-4xl text-gray-800">
                                Keluarga Mahasiswa Buddhis Dharmayana
                            </h2>
                            <p class="text-gray-500">
                                KMB Dharmayana Untar adalah sebuah wadah organisasi yang bersifat kekeluargaan dan keagamaan
                                bagi
                                seluruh umat Buddha di
                                Universitas Tarumanagara. Dharmayana dalam pengamalan Buddha Dharma, tidak bernaung pada
                                suatu
                                aliran atau sekte manapun, bukan
                                pula merupakan sekte baru.
                            </p>
                        </div>
                        <!-- End Title -->

                        <!-- List -->
                        <ul class="space-y-2 sm:space-y-4">
                            <li class="flex gap-x-3">
                                <span
                                    class="mt-0.5 size-5 flex justify-center items-center rounded-full bg-blue-50 text-blue-600">
                                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </span>
                                <div class="grow">
                                    <span class="text-sm sm:text-base text-gray-500">
                                        <span class="font-bold">Dharma</span> – Kebenaran atau ajaran
                                    </span>
                                </div>
                            </li>
                            <li class="flex gap-x-3">
                                <span
                                    class="mt-0.5 size-5 flex justify-center items-center rounded-full bg-blue-50 text-blue-600">
                                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                </span>
                                <div class="grow">
                                    <span class="text-sm sm:text-base text-gray-500">
                                        <span class="font-bold">Yana</span> – Kendaraan atau kereta
                                    </span>
                                </div>
                            </li>
                        </ul>
                        <!-- End List -->
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Features -->


        <div class="max-w-screen-lg px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="max-w-4xl mx-auto">
                <!-- Vision Section -->
                <div class="grid gap-12">
                    <div>
                        <h2 class="text-3xl text-gray-800 font-bold lg:text-4xl text-center">
                            Our Vision
                        </h2>
                        <p class="mt-3 text-gray-800 text-center">
                            Dharmayana Universitas Tarumanagara bertujuan untuk:
                        </p>
                    </div>
                    <!-- End Vision Section -->

                    <!-- Features Section -->
                    <div class="space-y-6 lg:space-y-10">
                        <!-- Feature 1 -->
                        <div class="flex gap-x-5 sm:gap-x-8">
                            <svg class="shrink-0 mt-2 size-6 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M12 3v3M12 18v3M3 12h3M18 12h3M5.636 5.636l2.121 2.121M16.243 16.243l2.121 2.121M5.636 18.364l2.121-2.121M16.243 7.757l2.121-2.121" />
                            </svg>
                            <div class="grow">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                    Buddha Dharma
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    Melayani umat Buddha dalam menghayati, mengamalkan, dan melaksanakan Buddha Dharma.
                                </p>
                            </div>
                        </div>
                        <!-- End Feature 1 -->

                        <!-- Feature 2 -->
                        <div class="flex gap-x-5 sm:gap-x-8">
                            <svg class="shrink-0 mt-2 size-6 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            <div class="grow">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                    Kehidupan dan Kerukunan Beragama
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    Meningkatkan kehidupan dan kerukunan beragama di lingkungan Universitas Tarumanagara.
                                </p>
                            </div>
                        </div>
                        <!-- End Feature 2 -->

                        <!-- Feature 3 -->
                        <div class="flex gap-x-5 sm:gap-x-8">
                            <svg class="shrink-0 mt-2 size-6 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M6 22V10M12 22V6M18 22V14" />
                            </svg>
                            <div class="grow">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                    Tri Dharma Perguruan Tinggi
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    Menunjang dan menyukseskan Tri Dharma Perguruan Tinggi.
                                </p>
                            </div>
                        </div>
                        <!-- End Feature 3 -->
                    </div>
                    <!-- End Features Section -->
                </div>
            </div>

        </div>

        <div class="max-w-screen-lg px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="max-w-4xl mx-auto">
                <!-- Mision Section -->
                <div class="grid gap-12">
                    <div>
                        <h2 class="text-3xl text-gray-800 font-bold lg:text-4xl text-center">
                            Our Mision
                        </h2>
                        <p class="mt-3 text-gray-800 text-center">
                            Untuk mencapai tujuannya, Dharmayana Universitas Tarumanagara berusaha antara lain:
                        </p>
                    </div>
                    <!-- End Mision Section -->

                    <!-- Features Section -->
                    <div class="space-y-6 lg:space-y-10">
                        <!-- Feature 1 -->
                        <div class="flex gap-x-5 sm:gap-x-8">
                            <svg class="shrink-0 mt-2 size-6 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M6 4h10v16H6a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                <path d="M10 8h4M12 6v4" />
                            </svg>
                            <div class="grow">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                    Pemahaman, Penghayatan dan Pengamalan Buddha Dharma
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    Membina pemahaman, penghayatan dan pengamalan Buddha Dharma bagi seluruh anggota
                                    Dharmayana
                                    di Universitas Tarumanagara.
                                </p>
                            </div>
                        </div>
                        <!-- End Feature 1 -->

                        <!-- Feature 2 -->
                        <div class="flex gap-x-5 sm:gap-x-8">
                            <img class="shrink-0 mt-2" src="assets/img/family.png" alt="Logo Kegiatan Sosial Keagamaan"
                                width="24" height="24" style="object-fit: contain;" />
                            <div class="grow">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                    Hubungan Persaudaraan yang Harmonis
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    Membina hubungan persaudaraan yang harmonis antara segenap unsur sivitas akademika
                                    yang beragama Buddha melalui kegiatan-kegiatan keagamaan.
                                </p>
                            </div>
                        </div>
                        <!-- End Feature 2 -->

                        <!-- Feature 3 -->
                        <div class="flex gap-x-5 sm:gap-x-8">
                            <img class="shrink-0 mt-2" src="assets/img/love.png" alt="Logo Kegiatan Sosial Keagamaan"
                                width="24" height="24" style="object-fit: contain;" />
                            </svg>
                            <div class="grow">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                    Hubungan dan Kerja Sama Berdasarkan Cinta Kasih
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    Mengadakan hubungan dan kerja sama berdasarkan cinta kasih dengan seluruh unsur sivitas
                                    akademika Universitas Tarumanagara.
                                </p>
                            </div>
                        </div>
                        <!-- End Feature 3 -->

                        <!-- Feature 4 -->
                        <div class="flex gap-x-5 sm:gap-x-8">
                            <img class="shrink-0 mt-2" src="assets/img/social.png" alt="Logo Kegiatan Sosial Keagamaan"
                                width="24" height="24" style="object-fit: contain;" />
                            <div class="grow">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                                    Kegiatan Sosial Keagamaan
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    Melaksanakan kegiatan-kegiatan sosial keagamaan lainnya.
                                </p>
                            </div>
                        </div>

                        <!-- End Feature 4 -->
                    </div>
                    <!-- End Features Section -->
                </div>
            </div>
        </div>

        <div class="max-w-5xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Title -->
            <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Our Team</h2>
                <p class="mt-1 text-gray-600">BPH Inti-Koordinator Dharmayana Untar</p>
            </div>
            <!-- End Title -->

            <!-- Grid -->
            <div>
                <!-- Row 1: 5 Members -->
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-8">
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/ketum.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Juvinto</h3>
                            <p class="text-sm text-gray-600">Ketua Umum</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/wakil1.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Bernardo Jati W.</h3>
                            <p class="text-sm text-gray-600">Wakil Ketua Umum 1</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/wakil2.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Amelia Aurora</h3>
                            <p class="text-sm text-gray-600">Wakil Ketua Umum 1</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/sekum.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Melinda Gloria</h3>
                            <p class="text-sm text-gray-600">Sekretaris Umum</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/bendum.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Tannia</h3>
                            <p class="text-sm text-gray-600">Bendahara Umum</p>
                        </div>
                    </div>
                </div>

                <!-- Row 2: 6 Members -->
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-8 mt-10">
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/bakti.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Metta Angellina</h3>
                            <p class="text-sm text-gray-600">Koor. Bakti</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/humas.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Griselda Y.</h3>
                            <p class="text-sm text-gray-600">Koor. HuMas</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/inven.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Hanna Padma</h3>
                            <p class="text-sm text-gray-600">Koor. Inventaris</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/pusdi.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Shevina V.</h3>
                            <p class="text-sm text-gray-600">Koor. PusDiKes</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/banat.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Michelle P. M.</h3>
                            <p class="text-sm text-gray-600">Koor. BaNat</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <img class="rounded-full w-24 h-24 mx-auto object-cover" src="assets/img/mulmed.jpeg"
                            alt="Avatar">
                        <div class="mt-2 sm:mt-4">
                            <h3 class="font-medium text-gray-800">Vinny Angelina</h3>
                            <p class="text-sm text-gray-600">Koor. Multimedia</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Grid -->
        </div>





    </main>

    <x-footers></x-footers>
@endsection
