<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    @if(Request::path() == '/' && Auth::user()->role_id == 1 || Request::path() == 'menu_produk' || Request::path() ==
    'produk_terjual' || Request::path() == 'bukti_pembayaran' || Request::path() == 'extract_screenshots')
    <link rel="stylesheet" href="{{asset('assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    @endif

    <!-- Sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{config('midtrans.client_key')}}">
    </script>
</head>

<body>

    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                            <img alt="image" src="{{ asset('assets/img/avatar/' . session('profile_picture'))}}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ (Auth::user()->name == "" ?
                                Auth::user()->email : Auth::user()->name ) }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" data-toggle="modal" data-target="#exampleModal"
                                class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">

                    <div class="sidebar-brand">
                        <a href="{{url('/')}}">Tokoku</a>
                    </div>

                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{url('/')}}">TK</a>
                    </div>

                    <ul class="sidebar-menu">
                        <li class="menu-header">{{ (Auth::user()->role_id == 1 ? 'Dashboard' : 'Profile') }}</li>

                        <li class="nav-item {{Request::path() == '/' || Request::path() == 'profile_customer/' . Session::get('id')
                         ? 'active' : ''}}"><a
                                href="{{ (Auth::user()->role_id == 1 ? url('/') : url('profile_customer/' . Session::get('id')))  }}"
                                class="nav-link">
                                @if(Auth::user()->role_id == 1)
                                <i class="bi bi-speedometer pl-3"></i><span>Dashboard</span></a>
                            @else
                            <i class="bi bi-person-fill pl-3"></i><span>Profile</span></a>
                            @endif

                        </li>

                        <li class="menu-header">Produk</li>

                        <li class="nav-item @if(Request::path() == 'menu_produk' 
                            || Request::path() == 'menu_produk/create'
                            || Request::segment(1) == 'beli'  || Request::segment(1) == 'metode_pembayaran' 
                            || Request::segment(1) == 'menu_produk' ) active @endif">
                            <a href="{{url('/menu_produk')}}" class="nav-link"><i class="bi bi-cart-fill pl-3"></i>
                                <span>Menu Produk</span></a>
                        </li>

                        @if(Auth::user()->role_id == 1)
                        <li class="nav-item @if(Request::path() == 'produk_terjual') active @endif"> <a
                                href="{{url('produk_terjual')}}" class="nav-link"><i
                                    class="bi bi-cart-dash-fill pl-3"></i>
                                <span>Produk Terjual</span></a></li>
                        @endif

                        @if(Auth::user()->role_id == 2)
                        <li class="menu-header">Pembayaran</li>

                        <li class="nav-item @if(Request::path() == 'bukti_pembayaran') active @endif">
                            <a href="{{url('bukti_pembayaran')}}" class="nav-link"><i
                                    class="bi bi-credit-card-fill pl-3"></i>
                                <span>Bukti Pembayaran</span></a>
                        </li>
                        @endif

                        <li class="menu-header">Pengaturan</li>
                        <li class="nav-item @if(Request::path() == 'ganti_password') active @endif">
                            <a href="{{url('ganti_password')}}" class="nav-link"><i
                                    class="bi bi-shield-lock-fill pl-3"></i>
                                <span>Ganti Password</span></a>
                        </li>

                        @if(Auth::user()->role_id == 1)
                        <li class="nav-item @if(Request::path() == 'extract_screenshots') active @endif">
                            <a href="{{url('extract_screenshots')}}" class="nav-link"><i
                                    class="bi bi-file-zip-fill pl-3"></i>
                                <span>Extract Screenshots</span></a>
                        </li>
                        @endif
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section mt-4">
                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ url('logout') }}" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{asset('assets/js/stisla.js')}}"></script>

    @if(Request::path() == '/' && Auth::user()->role_id == 1 || Request::path() == 'menu_produk' || Request::path() ==
    'produk_terjual' || Request::path() == 'bukti_pembayaran' || Request::path() == 'extract_screenshots')
    <!-- JS Libraies -->
    <script src="{{asset('assets/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    @endif

    <!-- Template JS File -->
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>

    @if(Request::path() == '/' && Auth::user()->role_id == 1 || Request::path() == 'menu_produk' || Request::path() ==
    'produk_terjual' || Request::path() == 'bukti_pembayaran' || Request::path() == 'extract_screenshots')
    <!-- Page Specific JS File -->
    <script src="{{asset('assets/js/page/modules-datatables.js')}}"></script>
    @endif

    @if(Request::path() == 'ganti_password')
    <script>
        let password_baru = document.querySelector('#password_baru');
        let konfirmasi_password_baru = document.querySelector('#konfirmasi_password_baru');
        let lihat_password = document.querySelector('#lihat_password');

        lihat_password.addEventListener('click', function(){
            if(password_baru.type == 'password' && konfirmasi_password_baru.type == 'password'){
                    password_baru.type = 'text';
                    konfirmasi_password_baru.type = 'text';
            }else{
                password_baru.type = 'password';
                konfirmasi_password_baru.type = 'password';
            }
        })

    </script>

    @elseif(Request::path() == 'extract_screenshots')
    <script>
        let produk_id = document.getElementById('produk_id');
        let nama_produk = document.getElementById('nama_produk');

        function btnPilih(namaProduk, idProduk){
            nama_produk.value = namaProduk;
            produk_id.value = idProduk;
        }
    </script>
    @endif

    @if (isset($snapToken) && isset($pathId) && Request::path() ==
    "metode_pembayaran/{$pathId}")
    <script>
        document.getElementById("pay-button").onclick = function () {
            // SnapToken acquired from previous step
            snap.pay("{{ $snapToken }}", {
                // Optional
                onSuccess: function (result) {
                    const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                            });
                            Toast.fire({
                            icon: "success",
                            title: "Pembayaran midtrans telah berhasil pada order id {{ $orderIdProduk }}."
                            });

                    setTimeout(() => {
                        window.location.href = "{{ url('bukti_pembayaran') }}";
                    }, 3000);
                },
                // Optional
                onPending: function (result) {
                    Swal.fire({
                        title: "Pending",
                        text: "Pembayaran Anda pending.",
                        icon: "warning"
                    });
                },
                // Optional
                onError: function (result) {
                    Swal.fire({
                        title: "Gagal",
                        text: "Pembayaran Anda gagal.",
                        icon: "error"
                    });
                },
            });
        };
    </script>
    @endif
</body>

</html>