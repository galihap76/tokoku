@extends('layout')

@section('title', 'Tambah Kategori - ' . env('APP_NAME'))

@section('content')

<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="bi-speedometer2" style="font-size: 25px;"></i></div>
                        Tambah Kategori
                    </h1>
                    <div class="page-header-subtitle">Tokoku - Tambah Kategori Produk</div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container-xl px-4 mt-n10">
    <div class="row">
        <div class="col">

            <!-- Default Bootstrap Form Controls-->
            <div id="default">
                <div class="card mb-4">
                    <div class="card-header">Form Tambah Kategori Produk</div>
                    <div class="card-body">

                        @if($success = Session::get('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ $success }}
                        </div>
                        @endif

                        <!-- Component Preview-->
                        <div class="sbp-preview">
                            <div class="sbp-preview-content">
                                <form method="post" action="{{ route('categories-menu.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="mb-2">Nama</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                                            type="text" maxlength="100" name="name" autocomplete="off"
                                            value="{{ old('name') }}" required />

                                        @if ($errors->has('name'))
                                        <p class="mt-3" style="font-size: 15px; color:red;"><i
                                                class="bi bi-exclamation-octagon-fill"></i>
                                            {{ucfirst($errors->first('name'))}}
                                        </p>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="mb-2">Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" rows="3"
                                            required>{{ old('description') }}</textarea>

                                        @if ($errors->has('description'))
                                        <p class="mt-3" style="font-size: 15px; color:red;"><i
                                                class="bi bi-exclamation-octagon-fill"></i>
                                            {{ucfirst($errors->first('description'))}}
                                        </p>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="mb-2">Upload Gambar</label>
                                        <input type="file" name="image"
                                            class="form-control mb-3 @error('image') is-invalid @enderror">

                                        @if ($errors->has('image'))
                                        <p class="mt-3" style="font-size: 15px; color:red;"><i
                                                class="bi bi-exclamation-octagon-fill"></i>
                                            {{ucfirst($errors->first('image'))}}
                                        </p>
                                        @endif

                                        <i>* Kosongkan jika tidak ingin mengupload.</i>
                                    </div>

                                    <div class="mt-4 mb-2 clearfix">

                                        <button type="submit" class="btn btn-success float-end ms-3">Kirim</button>

                                        <a href="{{ route('categories-menu.index') }}"
                                            class="btn btn-danger float-end">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection