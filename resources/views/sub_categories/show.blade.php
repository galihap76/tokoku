{{-- resources/views/sub_categories/show.blade.php --}}
@extends('layout')

@section('title', 'Detail Sub Kategori Produk - ' . env('APP_NAME'))

@section('content')

<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="bi bi-eye-fill" style="font-size: 25px;"></i></div>
                        Detail Sub Kategori
                    </h1>
                    <div class="page-header-subtitle">Tokoku - Detail Sub Kategori Produk</div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container-xl px-4 mt-n10">
    <div class="row">
        <div class="col">
            <div id="default">
                <div class="card mb-4">
                    <div class="card-header">Detail Sub Kategori Produk</div>
                    <div class="card-body">
                        <div class="sbp-preview">
                            <div class="sbp-preview-content">

                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label class="mb-2">Nama</label>
                                    <input class="form-control" type="text" value="{{ $subCategory->name }}" readonly>
                                </div>

                                {{-- Label --}}
                                <div class="mb-3">
                                    <label class="mb-2">Label</label>
                                    <textarea class="form-control" rows="2"
                                        readonly>{{ $subCategory->label }}</textarea>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="mb-3">
                                    <label class="mb-2">Deskripsi</label>
                                    <textarea class="form-control" rows="3"
                                        readonly>{{ $subCategory->description }}</textarea>
                                </div>

                                {{-- Thumbnail --}}
                                <div class="mb-3">
                                    <label class="mb-2">Thumbnail</label><br>
                                    @if($subCategory->thumbnail)
                                    <img src="{{ asset('storage/' . $subCategory->thumbnail) }}" alt="Thumbnail"
                                        class="img-fluid rounded" style="max-height:200px;">
                                    @else
                                    <p class="text-muted">Tidak ada thumbnail.</p>
                                    @endif
                                </div>

                                {{-- Link Drive --}}
                                <div class="mb-3">
                                    <label class="mb-2">Link Drive</label>
                                    <input type="text" class="form-control" value="{{ $subCategory->drive }}" readonly>
                                </div>

                                {{-- Harga --}}
                                <div class="mb-3">
                                    <label class="mb-2">Harga</label>
                                    <input type="text" class="form-control"
                                        value="Rp {{ number_format($subCategory->price, 0, ',', '.') }}" readonly>
                                </div>

                                {{-- Stok --}}
                                <div class="mb-3">
                                    <label class="mb-2">Stok</label>
                                    <input type="number" class="form-control" value="{{ $subCategory->stock }}"
                                        readonly>
                                </div>

                                {{-- Status --}}
                                <div class="mb-3">
                                    <label class="mb-2">Status</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($subCategory->status) }}"
                                        readonly>
                                </div>

                                {{-- Kategori Induk --}}
                                <div class="mb-3">
                                    <label class="mb-2">Kategori Induk</label>
                                    <input type="text" class="form-control" value="{{ $subCategory->category->name }}"
                                        readonly>
                                </div>

                                {{-- Tombol --}}
                                <div class="mt-4 mb-2 clearfix">
                                    <a href="{{ route('categories-submenu.index') }}"
                                        class="btn btn-danger float-end">Kembali</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection