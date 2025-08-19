@extends('layout')

@section('title', 'Dashboard - ' . env('APP_NAME'))

@section('content')

@if($success = Session::get('success'))
<script>
    Swal.fire({
        title: "Berhasil Login",
        text: "{{ $success }}",
        icon: "success"
    });
</script>

@elseif($verify_successfully = Session::get('verify-successfully'))
<script>
    Swal.fire({
        title: "Berhasil Verifikasi",
        text: "{{ $verify_successfully }}",
        icon: "success"
    });
</script>
@endif

<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="bi-speedometer2" style="font-size: 25px;"></i></div>
                        Dashboard
                    </h1>
                    <div class="page-header-subtitle">Tokoku - Platfrom Jual Beli Source Code</div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="container-xl px-4 mt-n10">

    @if(Auth::user()->role == 'admin')
    <!-- Example Colored Cards for Dashboard Demo-->
    <div class="row">
        <div class="col-lg-4 col-xl-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Total Order Hari Ini </div>
                            <div class="text-lg fw-bold">1</div>
                        </div>
                        <i class="bi bi-person-fill text-white-50" style="font-size: 30px;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="#">Lihat Laporan</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">
                                Total Order Bulan Ini</div>
                            <div class="text-lg fw-bold">2
                            </div>
                        </div>
                        <i class="bi bi-person-fill text-white-50" style="font-size: 30px;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="#">Lihat Laporan</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 mb-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Total Order Tahun Ini </div>
                            <div class="text-lg fw-bold">3
                            </div>
                        </div>
                        <i class="bi bi-person-fill text-white-50" style="font-size: 30px;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="#">Lihat Laporan</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(Auth::user()->role == 'admin')
    <div class="row">
        <div class="col-lg-4 col-xl-4 mb-4">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Total Pendapatan Hari Ini </div>
                            <div class="text-lg fw-bold">Rp 100.000</div>
                        </div>
                        <i class="bi bi-cash text-white-50" style="font-size: 30px;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="#">Lihat Laporan</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Total Pendapatan Bulan Ini </div>
                            <div class="text-lg fw-bold">Rp 250.000</div>
                        </div>
                        <i class="bi bi-cash text-white-50" style="font-size: 30px;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="#">Lihat Laporan</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 mb-4">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-white-75 small">Total Pendapatan Tahun Ini </div>
                            <div class="text-lg fw-bold">Rp 1.550.000</div>
                        </div>
                        <i class="bi bi-cash text-white-50" style="font-size: 30px;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-white stretched-link" href="#">Lihat Laporan</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Example Charts for Dashboard Demo-->
    @if(Auth::user()->role == 'admin')
    <div class="row">
        <div class="col mt-3">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Earnings Breakdown
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="text-gray-500" data-feather="more-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up"
                            aria-labelledby="areaChartDropdownExample">
                            <a class="dropdown-item" href="#!">Last 12 Months</a>
                            <a class="dropdown-item" href="#!">Last 30 Days</a>
                            <a class="dropdown-item" href="#!">Last 7 Days</a>
                            <a class="dropdown-item" href="#!">This Month</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">Custom Range</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection