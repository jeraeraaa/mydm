<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <!-- Sidebar Header -->
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <img src="../assets/img/mydmlogo.png" class="navbar-brand-img h-100" alt="myDM Logo">
            <span class="ms-3 font-weight-bold">myDM Dashboard</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">

    <!-- Sidebar Content -->
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @auth
                <!-- Admin and Super User Menu -->
                @if (Auth::user()->role && (Auth::user()->role->name === 'super_user' || Auth::user()->role->name === 'admin'))
                    <li class="nav-item mt-2">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Admin</h6>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('ketua-umum') ? 'active' : '' }}" href="{{ url('ketua-umum') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-tie {{ Request::is('ketua-umum') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Daftar Ketua Umum</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('inventaris') ? 'active' : '' }}" href="{{ url('inventaris') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-box-open {{ Request::is('inventaris') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Daftar Inventaris</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('anggota') ? 'active' : '' }}" href="{{ url('anggota') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-users {{ Request::is('anggota') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Manajemen Anggota</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role && Auth::user()->role->name === 'super_user')
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('role') ? 'active' : '' }}" href="{{ url('role') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-cog {{ Request::is('role') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Manajemen Roles</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role && (Auth::user()->role->name === 'super_user' || Auth::user()->role->name === 'admin'))
                    <!-- Activities Menu -->
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Activities</h6>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('kategori-kegiatan') ? 'active' : '' }}"
                            href="{{ url('kategori-kegiatan') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-tags {{ Request::is('kategori-kegiatan') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Kategori Kegiatan</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('kegiatan') ? 'active' : '' }}" href="{{ url('kegiatan') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-calendar-alt {{ Request::is('kegiatan') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Daftar Kegiatan</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('detail-kegiatan') ? 'active' : '' }}"
                            href="{{ url('detail-kegiatan') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-file-alt {{ Request::is('detail-kegiatan') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Detail Kegiatan</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('pembicara') ? 'active' : '' }}" href="{{ url('pembicara') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-microphone {{ Request::is('pembicara') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Pembicara</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('materi') ? 'active' : '' }}" href="{{ url('materi') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-book {{ Request::is('materi') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Materi</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('absensi') ? 'active' : '' }}" href="{{ url('absensi') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-clipboard-list {{ Request::is('absensi') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Absensi</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('pengunjung') ? 'active' : '' }}"
                            href="{{ url('pengunjung') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-user-friends {{ Request::is('pengunjung') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Pengunjung</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role &&
                        (Auth::user()->role->name === 'super_user' ||
                            Auth::user()->role->name === 'admin' ||
                            Auth::user()->role->name === 'inventaris'))
                    <!-- Items Menu -->
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Items</h6>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('alat') ? 'active' : '' }}" href="{{ url('alat') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-tools {{ Request::is('alat') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Manajemen Alat</span>
                        </a>
                    </li>

                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('backend-alat/status-peminjaman') ? 'active' : '' }}"
                            href="{{ url('backend-alat/status-peminjaman') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-hourglass-half {{ Request::is('backend-alat/status-peminjaman') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Status Peminjaman</span>
                        </a>
                    </li>

                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('peminjam-eksternal') ? 'active' : '' }}"
                            href="{{ url('peminjam-eksternal') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-user-circle {{ Request::is('peminjam-eksternal') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Peminjam Eksternal</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role && Auth::user()->role->name === 'super_user')
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('backend-alat/persetujuan') ? 'active' : '' }}"
                            href="{{ url('backend-alat/persetujuan') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-check-circle {{ Request::is('backend-alat/persetujuan') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Persetujuan Peminjaman</span>
                        </a>
                    </li>

                    <!-- New Menu -->
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">New Menu</h6>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('program-studi') ? 'active' : '' }}"
                            href="{{ url('program-studi') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-graduation-cap {{ Request::is('program-studi') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Program Studi</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('fakultas') ? 'active' : '' }}" href="{{ url('fakultas') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-university {{ Request::is('fakultas') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Fakultas</span>
                        </a>
                    </li>
                    <li class="nav-item pb-2">
                        <a class="nav-link {{ Request::is('bph') ? 'active' : '' }}" href="{{ url('bph') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-sitemap {{ Request::is('bph') ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">BPH</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidenav-footer mx-3">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background"
                style="background-image: url('../assets/img/curved-images/white-curved.jpeg')"></div>
            <div class="card-body text-start p-3 w-100">
                <div
                    class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                    <i class="ni ni-diamond text-dark text-gradient text-lg top-0"></i>
                </div>
                <div class="docs-info">
                    <h6 class="text-white up mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold">Please check our docs</p>
                    <a href="/documentation/getting-started/overview.html" target="_blank"
                        class="btn btn-white btn-sm w-100 mb-0">Documentation</a>
                </div>
            </div>
        </div>
    </div>
</aside>
