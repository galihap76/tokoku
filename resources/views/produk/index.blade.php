@extends('layout')

@section('title', 'Menu Produk')

@section('content')

<div class="container">

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

    @elseif($error = Session::get('error'))
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
        icon: "error",
        title: "{{ $error }}"
        });
    </script>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="ml-4">
                    <div class="row mt-3">
                        <div class="col">
                            <h5 class="text-primary">Menu Produk</h5>
                        </div>
                    </div>

                    @if (Auth::user()->role_id == 1)
                    <div class="row mt-3">
                        <div class="col">
                            <a href="{{ route('menu_produk.create') }}" class="btn btn-success mb-3"><i
                                    class="bi bi-plus-circle-fill"></i> Tambah</a>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped text-center" id="table-1">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal Buat</th>
                                    <th>Tanggal Ubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @php
                                $no = 1;
                                @endphp

                                @foreach((Auth::user()->role_id == 1 ? $semuaProduk : $produkCustomer) as $item)

                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>{{ (Auth::user()->role_id == 1 ? $item->nama : $item->nama_produk) }}</td>
                                    <td>{{ (Auth::user()->role_id == 1 ? $item->deskripsi : $item->deskripsi_produk) }}
                                    </td>
                                    <td>Rp {{ number_format(Auth::user()->role_id == 1 ? $item->harga :
                                        $item->harga_produk, 0, ',', '.') }}</td>
                                    <td>

                                        @if(Auth::user()->role_id == 1)
                                        <span
                                            class="{{ $item->status == 'tersedia' ? 'badge badge-success' : ($item->status == 'masih dalam pengembangan' ? 'badge badge-warning' : 'badge badge-danger') }}">
                                            {{ $item->status == 'tersedia' ? ucfirst($item->status) :
                                            ($item->status == 'masih dalam pengembangan' ? 'Dalam Pengembangan' :
                                            'Tidak
                                            Tersedia') }}
                                        </span>

                                        @else
                                        <span
                                            class="{{ $item->status_produk == 'tersedia' ? 'badge badge-success' : ($item->status_produk == 'masih dalam pengembangan' ? 'badge badge-warning' : 'badge badge-danger') }}">
                                            {{ $item->status_produk == 'tersedia' ? ucfirst($item->status_produk) :
                                            ($item->status_produk == 'masih dalam pengembangan' ? 'Dalam Pengembangan' :
                                            'Tidak
                                            Tersedia') }}
                                        </span>
                                        @endif
                                    </td>

                                    <td>{{ (Auth::user()->role_id == 1 ? $item->created_at : $item->tanggal_buat) }}
                                    </td>
                                    <td>{{ (Auth::user()->role_id == 1 ? $item->updated_at : $item->tanggal_ubah) }}
                                    </td>
                                    <td>
                                        @if (Auth::user()->role_id == 1)
                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('menu_produk.edit', $item->id) }}"
                                                    class="btn btn-warning text-white mb-2"><i
                                                        class="bi bi-pen-fill"></i>
                                                    Update</a>
                                            </div>
                                        </div>

                                        <div class="row mt-1 mb-1">
                                            <div class="col">
                                                <form action="{{ route('menu_produk.destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger mb-2"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"><i
                                                            class="bi bi-trash-fill"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('menu_produk.show', $item->id) }}"
                                                    class="btn btn-info text-white mb-2"><i class="bi bi-eye-fill"></i>
                                                    Lihat</a>
                                            </div>
                                        </div>

                                        @else
                                        <div class="row">

                                            @if($item->status_beli == 'pending' || $item->status_beli == 'deny')
                                            <div class="col">
                                                <a href="{{ route('metode_pembayaran', $item->order_id) }}"
                                                    class="btn btn-danger"><i
                                                        class="bi bi-credit-card-fill mx-1"></i>Selesaikan
                                                    Pembayaran
                                                </a>
                                            </div>

                                            @elseif($item->status_beli != 'success')
                                            <div class="col">
                                                <a href="{{ route('beli', $item->id_produk) }}"
                                                    class="btn btn-primary text-white mb-2"><i
                                                        class="bi bi-bag-fill"></i>
                                                    Beli</a>

                                                <a href="{{ route('menu_produk.show', $item->id_produk) }}"
                                                    class="btn btn-info text-white mb-2"><i class="bi bi-eye-fill"></i>
                                                    Lihat</a>
                                            </div>
                                            @endif

                                            @if($item->status_beli == 'success')
                                            <div class="col">
                                                <a href="{{ route('download_produk', $item->id_produk) }}"
                                                    class="btn btn-success text-white"><i class="bi bi-download"></i>
                                                    Unduh</a>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection