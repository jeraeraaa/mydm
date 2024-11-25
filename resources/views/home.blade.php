@extends('mydm')
@section('title', 'Home - myDM')
@section('content')
    <main class="relative isolate px-6 pt-28 lg:px-8 bg-gray-50">
        <!-- Hero -->
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid -->
            <div class="grid lg:grid-cols-7 gap-6 items-center">
                <!-- Branding Section -->
                <div class="lg:col-span-3 text-center lg:text-left">
                    <h1 class="text-3xl font-bold sm:text-4xl md:text-5xl lg:text-6xl text-gray-800">
                        Welcome to Dharmayana!
                    </h1>
                    <p class="mt-6 text-lg text-gray-800 text-justify sm:text-center lg:text-left">
                        KMB Dharmayana Untar adalah sebuah wadah organisasi yang bersifat kekeluargaan dan keagamaan bagi
                        seluruh umat Buddha di Universitas Tarumanagara.
                    </p>
                    <div class="mt-6 lg:mt-12 flex justify-center lg:justify-start items-center space-x-4">
                        <img class="h-12 w-auto" src="/assets/img/logos/untar.png" alt="Logo Untar">
                        <img class="h-12 w-auto" src="/assets/img/logos/dm.png" alt="Logo Dharmayana">
                    </div>
                    <p class="mt-4 text-sm text-gray-600">Powered by Dharmayana Untar</p>
                </div>
                <!-- Hero Image -->
                <div class="lg:col-span-4 mt-10 lg:mt-0 flex justify-center">
                    <img class="max-w-full rounded-xl shadow-lg" src="/assets/img/fotodm.jpeg" alt="Kegiatan Dharmayana">
                </div>
            </div>

            <!-- End Grid -->
        </div>
        <!-- End Hero -->

        <!-- Our Activities Section -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Title -->
            <div class="max-w-2xl text-center mx-auto mb-10 lg:mb-14">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Kegiatan Dharmayana</h2>
                <p class="mt-1 text-gray-600">Beragam kegiatan Dharmayana untuk mendukung pengembangan diri, kebersamaan,
                    dan semangat Dharma.</p>
            </div>
            <!-- End Title -->

            <!-- Program Kerja -->
            <div class="mb-10 lg:mb-14">
                <h3 class="text-xl font-semibold mb-6">Program Kerja</h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Dharmayana's Welcoming Party -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/dwp.jpeg" alt="Welcoming Party">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Dharmayana's Welcoming Party</h4>
                            <p class="text-sm text-gray-600 mt-2">Dharmayana’s Welcoming Party adalah program kerja yang
                                bertujuan menyambut mahasiswa baru Buddhis Universitas Tarumanagara sekaligus memperkenalkan
                                Dharmayana sebagai wadah pembinaan dan kegiatan mahasiswa Buddhis.
                            </p>
                        </div>
                    </div>
                    <!-- Darmadhista -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/dd.jpeg" alt="Darmadhista">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Darmadhista</h4>
                            <p class="text-sm text-gray-600 mt-2">Darmadhista adalah program kerja yang bertujuan mempererat
                                tali persaudaraan dan membina hubungan antara mahasiswa baru Buddhis yang menjadi anggota
                                Dharmayana dengan para pengurus dan aktivis organisasi. </p>
                        </div>
                    </div>
                    <!-- Pindapata dan Sangha Dana -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/kathina.jpeg"
                            alt="Pindapata dan Sangha Dana">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Pindapata dan Sangha Dana</h4>
                            <p class="text-sm text-gray-600 mt-2">Pindapata dan Sangha Dana di Bulan Kathina merupakan
                                program kerja yang dilaksanakan untuk memperingati salah satu hari besar agama Buddha, yaitu
                                Hari Suci Kathina. Perayaan ini menandai berakhirnya masa Vassa, sebuah periode penting
                                dalam tradisi agama Buddha di mana para anggota Sangha menjalani kewajiban selama tiga
                                bulan. </p>
                        </div>
                    </div>
                    <!-- Latihan Kepemimpinan -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/lk.jpeg"
                            alt="Latihan Kepemimpinan">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Latihan Kepemimpinan</h4>
                            <p class="text-sm text-gray-600 mt-2">Latihan Kepemimpinan (LK) merupakan salah satu program
                                kerja unggulan yang dirancang untuk mengembangkan jiwa kepemimpinan anggota Dharmayana
                                dengan pendekatan yang berlandaskan ajaran Buddha Dharma. </p>
                        </div>
                    </div>
                    <!-- Pekan Penghayatan Dhamma -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/ppd.jpeg"
                            alt="Pekan Penghayatan Dhamma">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Pekan Penghayatan Dhamma</h4>
                            <p class="text-sm text-gray-600 mt-2">Pekan Penghayatan Dhamma dirancang sebagai sarana untuk
                                meningkatkan pemahaman, keyakinan, dan disiplin diri melalui praktik ajaran Buddha Dharma.
                                Kegiatan PPD meliputi meditasi, pelatihan menjalankan atthasila, serta sesi mendengarkan
                                ajaran Dharma dari para pembimbing.</p>
                        </div>
                    </div>
                    <!-- Metta Day -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/md.jpeg" alt="Metta Day">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Metta Day</h4>
                            <p class="text-sm text-gray-600 mt-2">Metta Day merupakan program kerja yang diselenggarakan
                                sebagai perwujudan cinta kasih universal (Metta), sesuai dengan ajaran Buddha. “Metta”
                                berasal dari bahasa Pali yang berarti cinta kasih, yang tidak hanya ditujukan kepada
                                individu dengan keyakinan, ras, atau latar belakang ekonomi yang sama tetapi juga kepada
                                seluruh makhluk hidup. </p>
                        </div>
                    </div>
                    <!-- Buddhist Camp -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/bc.jpeg" alt="Buddhist Camp">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Buddhist Camp</h4>
                            <p class="text-sm text-gray-600 mt-2">Buddhist Camp dirancang sebagai pengalaman unik yang
                                mengombinasikan konsep camping dengan nilai-nilai Buddhis, bertujuan memberikan manfaat
                                holistik bagi pribadi, komunitas, dan lingkungan.</p>
                        </div>
                    </div>
                    <!-- Dharmayana Buddhist Festival -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/dbf.jpeg"
                            alt="Dharmayana Buddhist Festival">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Dharmayana Buddhist Festival</h4>
                            <p class="text-sm text-gray-600 mt-2">Acara tahunan yang diselenggarakan oleh Dharmayana
                                Universitas Tarumanagara untuk memperingati Hari Tri Suci Waisak, sekaligus merayakan Hari
                                Ulang Tahun (HUT) Dharmayana dan HUT Berita Dharmayana. </p>
                        </div>
                    </div>
                    <!-- Berita Dharmayana -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/bd1.jpeg"
                            alt="Berita Dharmayana ">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Berita Dharmayana </h4>
                            <p class="text-sm text-gray-600 mt-2">Berita Dharmayana berperan sebagai media komunikasi dan
                                informasi untuk menyebarkan Buddha Dharma. Majalah ini dirancang untuk mendukung misi
                                Dharmayana dalam mempromosikan solidaritas dan toleransi umat beragama yang berlandaskan
                                Pancasila.</p>
                        </div>
                    </div>
                </div>

                <!-- Proker -->
                {{-- <div class="mt-12 text-center">
                    <a class="py-3 px-4 inline-flex items-center gap-x-1 text-sm font-medium rounded-full border border-gray-300 bg-white text-orange-500 shadow-md hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-orange-50 disabled:opacity-50 disabled:pointer-events-none"
                        href="#">
                        Read more
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div> --}}
                <!-- end-->


            </div>
            <!-- End Program Kerja -->


            <!-- Kegiatan Sehari-hari -->
            <div class="mb-10 lg:mb-14">
                <h3 class="text-xl font-semibold mb-6">Kegiatan Sehari-hari</h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card 1 -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/kbk.jpeg" alt="Dhammaclass">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Dhammaclass</h4>
                            <p class="text-sm text-gray-600 mt-2">Kelas reguler untuk mempelajari ajaran Buddha.</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/vt.jpeg" alt="Chanting">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">Volunteers</h4>
                            <p class="text-sm text-gray-600 mt-2">Kegiatan relawan untuk membantu kegiatan keagamaan.</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition">
                        <img class="w-full h-48 object-cover rounded-t-xl" src="/assets/img/sport.jpeg" alt="DM-Sport">
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-gray-800">DM-Sport</h4>
                            <p class="text-sm text-gray-600 mt-2">Kegiatan olahraga untuk menjaga kesehatan tubuh atau
                                bermain bersama.</p>
                        </div>
                    </div>
                </div>

                <!-- kegiatan -->
                {{-- <div class="mt-12 text-center">
                    <a class="py-3 px-4 inline-flex items-center gap-x-1 text-sm font-medium rounded-full border border-gray-300 bg-white text-orange-500 shadow-md hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:bg-orange-50 disabled:opacity-50 disabled:pointer-events-none"
                        href="#">
                        Read more
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                </div> --}}
                <!-- end-->
            </div>

        </div>
        <!-- End Our Activities Section -->


        <!-- FAQ -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Title -->
            <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Frequently Ask Questions</h2>
                <p class="mt-1 text-gray-600">Hal-hal yang sering ditanyakan terkait Dharmayana.</p>
            </div>

            <div class="max-w-5xl mx-auto">
                <!-- Grid -->
                <div class="grid sm:grid-cols-2 gap-6 md:gap-12">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Siapa saja yang dapat bergabung ke dalam Dharmayana?
                        </h3>
                        <p class="mt-2 text-gray-600">
                            Seluruh sivitas buddhis yang berada dalam Universitas Tarumanagara merupakan anggota
                            dari Dharmayana ya! Jadi Dharmayana sangat menyambut kedatangan kaliam semua.
                        </p>
                    </div>
                    <!-- End Col -->

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Apakah menjadi anggota biasa berarti menjadi pengurus/panitia Dharmayana?
                        </h3>
                        <p class="mt-2 text-gray-600">
                            Bukan ya. Tapi selama kamu sivitas aktif buddhis di Universitas Tarumanagara, kamu
                            dapat mendaftar menjadi pengurus ataupun panitia.
                        </p>
                    </div>
                    <!-- End Col -->

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Apa saja kegiatan Dharmayana?
                        </h3>
                        <p class="mt-2 text-gray-600">
                            Kegiatan di Dharmayana pastinya bertujuan untuk menambah pengetahuan tentang Buddha Dharma.
                            Contohnya seperti Puja Bakti, Dhamma Class. Selain itu, ada juga kegiatan untuk menambah
                            wawasan,
                            melatih kepemimpinan, meningkatkan solidaritas, dan menampung minat serta bakat anggota
                            Dharmayana.
                        </p>
                    </div>
                    <!-- End Col -->

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Apa saja kepengurusan Dharmayana?
                        </h3>
                        <p class="mt-2 text-gray-600">
                            Badan Pengurus Harian Dharmayana terdiri dari 6 divisi. Divisinya terdiri dari Bakti,
                            Hubungan Masyarakat (HuMas), Inventaris, Perpustakaan, Pendidikan, dan Kesehatan (PusDiKes),
                            Bakat dan Minat (BaNat), dan Multimedia.
                        </p>
                    </div>
                    <!-- End Col -->

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Apakah ada majalah di Dharmayana Untar?
                        </h3>
                        <p class="mt-2 text-gray-600">
                            Tentu saja ada. Apabila ada yang tertarik seputar majalah, kalian bisa bergabung ke tim
                            Berita Dharmayana.
                        </p>
                    </div>
                    <!-- End Col -->

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Apakah boleh hanya menjadi panitia program kerja saja?
                        </h3>
                        <p class="mt-2 text-gray-600">
                            Bisa. Kamu bisa bergabung sebagai panitia program kerja saja. Tapi, kamu harus
                            mendaftar terlebih dahulu serta memenuhi syarat dan ketentuan yang telah ditetapkan oleh
                            panitia.
                        </p>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Grid -->
            </div>
        </div>
        <!-- End FAQ -->


        <!-- Grid -->
        <!-- Our Sponsors -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Our Sponsors</h2>
                <p class="mt-1 text-gray-600">Kami berterima kasih kepada sponsor yang telah mendukung kegiatan
                    Dharmayana.</p>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-8 my-8 md:my-16">
                {{-- <!-- Sponsor 1 -->
            <a class="shrink-0 transition hover:-translate-y-1">
                <img class="h-24 object-contain mx-auto" src="/assets/img/sanus.jpg" alt="Sponsor 1 Logo">
            </a> --}}

                <!-- Sponsor 2 -->
                <a class="shrink-0 transition hover:-translate-y-1">
                    <img class="h-24 object-contain mx-auto" src="/assets/img/cdm.png" alt="Sponsor 2 Logo">
                </a>

                <!-- Sponsor 3 -->
                <a class="shrink-0 transition hover:-translate-y-1">
                    <img class="h-24 object-contain mx-auto" src="/assets/img/mef.png" alt="Sponsor 3 Logo">
                </a>

                <!-- Sponsor 4 -->
                <a class="shrink-0 transition hover:-translate-y-1">
                    <img class="h-24 object-contain mx-auto" src="/assets/img/dextone.png" alt="Sponsor 4 Logo">
                </a>

                <!-- Sponsor 5 -->
                <a class="shrink-0 transition hover:-translate-y-1">
                    <img class="h-24 object-contain mx-auto" src="/assets/img/sinde.png" alt="Sponsor 5 Logo">
                </a>

                <!-- Sponsor 6 -->
                <a class="shrink-0 transition hover:-translate-y-1">
                    <img class="h-24 object-contain mx-auto" src="/assets/img/sponsor6.jpeg" alt="Sponsor 6 Logo">
                </a>
            </div>

            <!-- End Sponsors Grid -->
        </div>


        <!-- Apa Kata Mereka -->
        {{-- <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Title -->
            <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
                <h2 class="text-2xl font-bold md:text-4xl md:leading-tight">Apa Kata Mereka</h2>
                <p class="mt-1 text-gray-600">Testimoni dari mereka yang telah menjadi bagian dari Dharmayana.</p>
            </div>
            <!-- End Title -->

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Testimoni 1 -->
                <div class="flex flex-col rounded-xl p-4 md:p-6 bg-white border border-gray-200">
                    <div class="flex items-center gap-x-4">
                        <img class="rounded-full w-20 h-20"
                            src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                            alt="Avatar">
                        <div class="grow">
                            <h3 class="font-medium text-gray-800">David Forren</h3>
                            <p class="text-xs uppercase text-gray-500">Pengusaha</p>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-500">
                        "Pengalaman saya sangat luar biasa! Tim ini benar-benar memberikan yang terbaik."
                    </p>
                </div>
                <!-- End Testimoni 1 -->

                <!-- Testimoni 2 -->
                <div class="flex flex-col rounded-xl p-4 md:p-6 bg-white border border-gray-200">
                    <div class="flex items-center gap-x-4">
                        <img class="rounded-full w-20 h-20"
                            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                            alt="Avatar">
                        <div class="grow">
                            <h3 class="font-medium text-gray-800">Amil Evara</h3>
                            <p class="text-xs uppercase text-gray-500">Desainer UI/UX</p>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-500">
                        "Sangat membantu, layanan yang diberikan memenuhi ekspektasi saya sepenuhnya."
                    </p>
                </div>
                <!-- End Testimoni 2 -->

                <!-- Testimoni 3 -->
                <div class="flex flex-col rounded-xl p-4 md:p-6 bg-white border border-gray-200">
                    <div class="flex items-center gap-x-4">
                        <img class="rounded-full w-20 h-20"
                            src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80"
                            alt="Avatar">
                        <div class="grow">
                            <h3 class="font-medium text-gray-800">Ebele Egbuna</h3>
                            <p class="text-xs uppercase text-gray-500">Konsultan</p>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-500">
                        "Saya tidak bisa lebih puas lagi dengan hasil yang diberikan!"
                    </p>
                </div>
                <!-- End Testimoni 3 -->
            </div>
            <!-- End Grid -->
        </div> --}}
        <!-- End Apa Kata Mereka -->

    </main>

    <x-footers></x-footers>
@endsection
