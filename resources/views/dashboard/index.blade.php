@extends('layout')

@section('title', 'Dashboard')

@section('content')

@if($success = Session::get('success'))
<script>
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
    title: "{{ $success }}"
    });
</script>
@endif

<div class="container">
    <div class="row">
        @if(Auth::user()->role_id == 1)

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="bi bi-person-fill fa-2x text-white"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Order Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_order_hari_ini }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-dark">
                    <i class="bi bi-cash fa-2x text-white"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Penjualan Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        {{$total_penjualan_hari_ini}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="bi bi-basket-fill fa-2x text-white"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Barang Terjual Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        {{ $total_barang_terjual_hari_ini }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @if(Auth::user()->role_id == 1)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Nama Order Hari Ini</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th>Nama Customer</th>
                                    <th>Invoice</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp

                                @foreach($nama_order_hari_ini as $user)
                                @foreach($user->order_details as $order)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                </tr>
                                @endforeach
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection