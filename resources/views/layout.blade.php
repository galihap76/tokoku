<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    {{--
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" /> --}}
    <script data-search-pseudo-elements defer
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .owl-prev,
        .owl-next {
            display: none;
        }
    </style>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
        id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i
                data-feather="menu"></i></button>
        <!-- Navbar Brand-->
        <!-- * * Tip * * You can use text or an image for your navbar brand.-->
        <!-- * * * * * * When using an image, we recommend the SVG format.-->
        <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ asset('/dashboard') }}">{{ env('APP_NAME') }}</a>

        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ms-auto">

            <!-- User Dropdown-->
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><img class="img-fluid"
                        src="{{ asset('storage/' . Auth::user()->profile_picture )}}" /></a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="{{ asset('storage/' . Auth::user()->profile_picture )}}" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">{{ Auth::user()->name }}</div>
                            <div class="dropdown-user-details-email">{{ Auth::user()->email }}</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item mb-3" href="{{ url('/account') }}">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Account
                    </a>

                    <a class="dropdown-item" href="{{ url('/logout') }}">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">

                        <!-- Sidenav Menu Heading (Core)-->
                        <div class="sidenav-menu-heading">Dashboard</div>
                        <!-- Sidenav Accordion (Dashboard)-->
                        <a class="nav-link collapsed {{ Request::path() == 'dashboard' ? 'active' : '' }}"
                            href="{{ url('/dashboard') }}">
                            <div class="nav-link-icon"><i class="bi-speedometer2"></i></div>
                            Dashboard
                        </a>

                        <div class="sidenav-menu-heading">Manajemen Produk</div>

                        @if(Auth::user()->role == 'admin')
                        <!-- Sidenav Accordion (Management Laporan)-->
                        <a class="nav-link collapsed {{ Request::segment(1) == 'categories-menu' ? 'active' : '' }}"
                            href="{{ url('/categories-menu') }}">
                            <div class="nav-link-icon"><i class="bi bi-tags-fill"></i></div>
                            Menu Kategori
                        </a>
                        @endif

                        {{--
                        <!-- Management Laporan -->
                        <div class="sidenav-menu-heading">Manajemen Laporan</div>

                        @if(Auth::user()->role == 'admin')
                        <!-- Sidenav Accordion (Management Laporan)-->
                        <a class="nav-link collapsed {{ Request::path() == 'manage-reports' || Request::segment(1) == 'find-reference' 
                        || Request::segment(1) == 'manage-anonymous-reports' ? 'active' : '' }}"
                            href="{{ url('/manage-reports') }}">
                            <div class="nav-link-icon"><i class="bi bi-gear-fill"></i></div>
                            Kelola Semua Laporan
                        </a>
                        @endif

                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
                        <a class="nav-link collapsed {{ Request::path() == 'list-submitted-reports' ? 'active' : '' }}"
                            href="{{ url('/list-submitted-reports') }}">
                            <div class="nav-link-icon"><i class="bi bi-clipboard2-data-fill"></i></div>
                            Laporan Terkirim
                        </a>

                        <a class="nav-link collapsed {{ Request::path() == 'list-valid-reports' ? 'active' : '' }}"
                            href="{{ url('/list-valid-reports') }}">
                            <div class="nav-link-icon"><i class="bi bi-clipboard-check-fill"></i></div>
                            Laporan Valid
                        </a>

                        <a class="nav-link collapsed {{ Request::path() == 'list-invalid-reports' ? 'active' : '' }}"
                            href="{{ url('/list-invalid-reports') }}">
                            <div class="nav-link-icon"><i class="bi bi-clipboard-x-fill"></i></div>
                            Laporan Tidak Valid
                        </a>

                        <a class="nav-link collapsed {{ Request::path() == 'list-pending-reports' ? 'active' : '' }}"
                            href="{{ url('/list-pending-reports') }}">
                            <div class="nav-link-icon"><i class="bi bi-clipboard2-minus-fill"></i></div>
                            Laporan Pending
                        </a>

                        @if(Auth::user()->role == 'admin')
                        <a class="nav-link collapsed {{ Request::path() == 'list-anonymous-reports' ? 'active' : '' }}"
                            href="{{ url('/list-anonymous-reports') }}">
                            <div class="nav-link-icon"><i class="bi bi-incognito"></i></div>
                            Laporan Anonim
                        </a>
                        @endif

                        @if(Auth::user()->role == 'user')
                        <a class="nav-link collapsed {{ Request::path() == 'list-advanced-verification-reports' ? 'active' : '' }}"
                            href="{{ url('/list-advanced-verification-reports') }}">
                            <div class="nav-link-icon"><i class="bi bi-clipboard2-pulse-fill"></i></div>
                            Laporan Verifikasi Lanjutan
                        </a>
                        @endif
                        @endif

                        @if(Auth::user()->role == 'admin')
                        <!-- Manajemen Kategori -->
                        <div class="sidenav-menu-heading">Manajemen Kategori</div>

                        <!-- Sidenav Accordion (Manajemen Kategori)-->
                        <a class="nav-link collapsed {{ Request::segment(1) == 'manage-categories' ? 'active' : '' }}"
                            href="{{ url('/manage-categories') }}">
                            <div class="nav-link-icon"><i class="bi bi-exclamation-circle"></i></div>
                            Kelola Kategori
                        </a>

                        <!-- Manajemen Artikel -->
                        <div class="sidenav-menu-heading">Manajemen Artikel</div>

                        <!-- Sidenav Accordion (Manajemen Artikel)-->
                        <a class="nav-link collapsed {{ Request::path() == 'articles' ? 'active' : '' }}"
                            href="{{ url('/articles') }}">
                            <div class="nav-link-icon"><i class="bi-journal-richtext"></i></div>
                            Kelola Artikel
                        </a>

                        @elseif(Auth::user()->role == 'user')

                        <div class="sidenav-menu-heading">Pelaporan Hoaks</div>

                        <!-- Sidenav Accordion (Pelaporan Haoks)-->
                        <a class="nav-link collapsed {{ Request::path() == 'report-hoax' ? 'active' : '' }}"
                            href="{{ url('/report-hoax') }}">
                            <div class="nav-link-icon"><i class="bi-pencil-square"></i></div>
                            Laporkan Hoaks
                        </a>

                        <!-- Sidenav Accordion (Riwayat Pelaporan)-->
                        <a class="nav-link collapsed {{ Request::path() == 'report-history' ? 'active' : '' }}"
                            href="{{ url('/report-history') }}">
                            <div class="nav-link-icon"><i class="bi bi-clock-history"></i></div>
                            Riwayat Laporan
                        </a>
                        @endif --}}

                    </div>
                </div>

                <!-- Sidenav Footer-->
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">Telah Login : </div>
                        <div class="sidenav-footer-title">{{ Auth::user()->name }}</div>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    @if(Request::path() == 'dashboard' && Auth::user()->role == 'admin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    @endif

    @if(Request::path() == 'categories-menu')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/datatables/datatables-simple-demo.js') }}"></script>

    <script>
        function replaceStr(str) {
            return str.replace(/-/g, ' ') // Ganti '-' dengan spasi
        }

        function btnDeleteCategories(name, id){
            let form_id = `.form-id-${id}`;
            let selector_class_form_id = document.querySelector(form_id);
            let nameReplace = replaceStr(name);

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: `Hapus kategori ${nameReplace}.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    selector_class_form_id.submit();
                }
            });
        }

    </script>
    @endif

</body>

</html>