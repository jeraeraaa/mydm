<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="{{ asset('assets/img/mydmlogo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('assets/img/mydmlogo.png') }}" type="image/png">
    <title>
        myDM Dashboard
    </title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



</head>

<body class="g-sidenav-show bg-gray-100">
    @auth
        @yield('auth')
    @endauth
    @guest
        @yield('guest')
    @endguest

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    @stack('dashboard')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages, etc. -->
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.nav-link');
            const contentContainer = document.querySelector('.main-content .container-fluid');

            // Tambahkan event listener untuk setiap link
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href'); // Gunakan 'href' sebagai URL

                    // Tambahkan class active pada sidebar
                    links.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    // Gunakan fetch untuk memuat konten
                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(data => {
                            const parser = new DOMParser();
                            const html = parser.parseFromString(data, 'text/html');
                            const newContent = html.querySelector('.container-fluid');

                            if (newContent) {
                                contentContainer.innerHTML = newContent.innerHTML;

                                // Update URL di address bar tanpa refresh
                                window.history.pushState({
                                    path: url
                                }, '', url);
                            } else {
                                console.error(
                                    'Error: Container content not found in the response.');
                            }
                        })
                        .catch(err => console.error('Error loading content:', err));
                });

                // Tambahkan efek hover pada ikon
                const iconDiv = link.querySelector('.icon');
                if (iconDiv) {
                    link.addEventListener('mouseover', () => {
                        iconDiv.style.backgroundColor = '#343a40'; // Warna gelap
                        iconDiv.style.color = 'white'; // Ikon menjadi putih
                    });
                    link.addEventListener('mouseout', () => {
                        iconDiv.style.backgroundColor = 'white'; // Warna default
                        iconDiv.style.color = 'black'; // Ikon kembali menjadi hitam
                    });
                }
            });

            // Tangani back/forward browser navigation
            window.addEventListener('popstate', function(event) {
                const currentPath = window.location.pathname;

                fetch(currentPath)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        const parser = new DOMParser();
                        const html = parser.parseFromString(data, 'text/html');
                        const newContent = html.querySelector('.container-fluid');

                        if (newContent) {
                            contentContainer.innerHTML = newContent.innerHTML;

                            // Perbarui active link pada sidebar
                            links.forEach(link => {
                                const linkUrl = link.getAttribute('href');
                                link.classList.toggle('active', linkUrl === currentPath);
                            });
                        } else {
                            console.error('Error: Container content not found in the response.');
                        }
                    })
                    .catch(err => console.error('Error handling popstate:', err));
            });
        });
    </script>

</body>

</html>
