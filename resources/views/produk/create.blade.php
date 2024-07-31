@extends('layout')

@section('title', 'Tambah Produk')

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
            <div class="card shadow p-3 mb-5 bg-white rounded mt-3">

                <div class="ml-4">
                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <h5 class="text-primary">Tambah Produk</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <form method="post" action="{{ route('menu_produk.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mr-3">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control border border-primary" id="nama" name="nama"
                                        autocomplete="off" value="{{old('nama')}}">
                                </div>

                                @if ($errors->has('nama'))
                                <p class="mt-3" style="font-size: 15px; color:red;"><i
                                        class="bi bi-exclamation-octagon-fill"></i>
                                    {{ucfirst($errors->first('nama'))}}
                                </p>
                                @endif

                                <div class="form-group mr-3">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input type="text" class="form-control border border-primary" id="deskripsi"
                                        name="deskripsi" autocomplete="off" value="{{old('deskripsi')}}">
                                </div>

                                @if ($errors->has('deskripsi'))
                                <p class="mt-3" style="font-size: 15px; color:red;"><i
                                        class="bi bi-exclamation-octagon-fill"></i>
                                    {{ucfirst($errors->first('deskripsi'))}}
                                </p>
                                @endif

                                <div class="form-group mr-3">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control border border-primary" id="harga"
                                        name="harga" autocomplete="off" value="{{old('harga')}}">
                                </div>

                                @if ($errors->has('harga'))
                                <p class="mt-3" style="font-size: 15px; color:red;"><i
                                        class="bi bi-exclamation-octagon-fill"></i>
                                    {{ucfirst($errors->first('harga'))}}
                                </p>
                                @endif

                                <div class="form-group mr-3">
                                    <label for="status">Status</label>
                                    <select class="form-control border border-primary" id="status" name="status">
                                        <option selected value="">- Pilih Status -</option>

                                        <option value="tersedia" @if(old('status')=="tersedia" ) {{ 'selected' }}
                                            @endif>Tersedia</option>

                                        <option value="masih dalam pengembangan"
                                            @if(old('status')=="masih dalam pengembangan" ) {{ 'selected' }} @endif>
                                            Masih
                                            Dalam Pengembangan</option>

                                        <option value="tidak tersedia" @if(old('status')=="tidak tersedia" )
                                            {{ 'selected' }} @endif>Tidak Tersedia</option>

                                    </select>
                                </div>

                                @if ($errors->has('status'))
                                <p class="mt-3" style="font-size: 15px; color:red;"><i
                                        class="bi bi-exclamation-octagon-fill"></i>
                                    {{ucfirst($errors->first('status'))}}
                                </p>
                                @endif

                                <div class="form-group mr-3">
                                    <label for="file">Upload file ZIP</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="file" id="file"
                                            value="{{old('file')}}">
                                        <label class="custom-file-label border border-primary">Choose
                                            file...</label>
                                    </div>
                                </div>

                                @if ($errors->has('file'))
                                <p class="mt-3" style="font-size: 15px; color:red;"><i
                                        class="bi bi-exclamation-octagon-fill"></i>
                                    {{ucfirst($errors->first('file'))}}
                                </p>
                                @endif

                                <hr />

                                <button type="submit" class="btn btn-primary mr-3">Tambah</button>
                                <a href="{{url('menu_produk')}}" class="btn btn-danger">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection