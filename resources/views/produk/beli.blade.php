@extends('layout')

@section('title', 'Menu Produk')

@section('content')

<div class="container mb-3">

    @if($error = Session::get('error'))
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
                <div class="card-header">
                    <h4>Checkout</h4>
                </div>

                <div class="card-body">

                    <form method="post" action="{{url('proses_checkout')}}">
                        @csrf

                        @if($user->nomor_telepon == '' || $user->user->name == '')
                        <div class="alert alert-warning text-center" role="alert">
                            Lengkapi profile Anda untuk membeli suatu produk.
                        </div>
                        @endif

                        <input type="hidden" name="id" value="{{ $produk->id  }}">
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                autocomplete="off" value="{{ $produk->nama  }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" autocomplete="off"
                                value="{{ $produk->deskripsi }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="qty">Qty</label>
                            <input type="text" class="form-control" id="qty" name="qty" autocomplete="off" value="1"
                                readonly>
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" autocomplete="off"
                                value="{{ number_format($produk->harga, 0, ',', '.') }}" readonly>
                        </div>

                        <a href="{{url('/menu_produk')}}" class="btn btn-danger mt-3 me-3">Kembali</a>

                        @if($user->nomor_telepon != '' && $user->user->name != '')
                        <button type="submit" name="proses_checkout"
                            class="btn btn-success mt-3 float-right">Checkout</button>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection