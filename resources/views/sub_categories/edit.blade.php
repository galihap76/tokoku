@extends('layout')

@section('title', 'Edit Sub Kategori Produk - ' . env('APP_NAME'))

@section('content')

<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="bi-pencil-square" style="font-size: 25px;"></i></div>
                        Edit Sub Kategori
                    </h1>
                    <div class="page-header-subtitle">Tokoku - Edit Sub Kategori Produk</div>
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
                    <div class="card-header">Form Edit Sub Kategori Produk</div>
                    <div class="card-body">

                        @if($success = Session::get('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ $success }}
                        </div>
                        @endif

                        <div class="sbp-preview">
                            <div class="sbp-preview-content">
                                <form method="post" action="{{ route('categories-submenu.update', $submenu->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Nama --}}
                                    <div class="mb-3">
                                        <label for="name" class="mb-2">Nama</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                                            type="text" maxlength="100" name="name" autocomplete="off"
                                            value="{{ old('name', $submenu->name) }}" required />
                                        @error('name')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Label --}}
                                    <div class="mb-3">
                                        <label for="label" class="mb-2">Label</label>
                                        <textarea class="form-control @error('label') is-invalid @enderror" id="label"
                                            name="label" rows="2"
                                            required>{{ old('label', $submenu->label) }}</textarea>
                                        @error('label')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div class="mb-3">
                                        <label for="description" class="mb-2">Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" rows="3"
                                            required>{{ old('description', $submenu->description) }}</textarea>
                                        @error('description')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Upload Thumbnail --}}
                                    <div class="mb-3">
                                        <label for="thumbnail" class="mb-2">Upload Thumbnail</label>
                                        @if($submenu->thumbnail)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$submenu->thumbnail) }}" alt="Thumbnail"
                                                class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                        @endif
                                        <input type="file" name="thumbnail"
                                            class="form-control mb-3 @error('thumbnail') is-invalid @enderror">
                                        @error('thumbnail')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                        <small class="text-muted">* Kosongkan jika tidak ingin mengubah
                                            thumbnail.</small>
                                    </div>

                                    {{-- Link Drive --}}
                                    <div class="mb-3">
                                        <label for="drive" class="mb-2">Link Drive (opsional)</label>
                                        <input type="text" name="drive"
                                            class="form-control @error('drive') is-invalid @enderror"
                                            value="{{ old('drive', $submenu->drive) }}">
                                        @error('drive')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Harga --}}
                                    <div class="mb-3">
                                        <label for="price" class="mb-2">Harga</label>
                                        <input type="number" name="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price', $submenu->price) }}" required>
                                        @error('price')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Stok --}}
                                    <div class="mb-3">
                                        <label for="stock" class="mb-2">Stok</label>
                                        <input type="number" name="stock"
                                            class="form-control @error('stock') is-invalid @enderror"
                                            value="{{ old('stock', $submenu->stock) }}" required>
                                        @error('stock')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="mb-3">
                                        <label for="status" class="mb-2">Status</label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror"
                                            required>
                                            <option value="public" {{ old('status', $submenu->status) == 'public' ?
                                                'selected' : '' }}>Public</option>
                                            <option value="draft" {{ old('status', $submenu->status) == 'draft' ?
                                                'selected' : '' }}>Draft</option>
                                        </select>
                                        @error('status')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Kategori Induk --}}
                                    <div class="mb-3">
                                        <label for="category_id" class="mb-2">Kategori Induk</label>
                                        <select name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $submenu->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <p class="mt-2 text-danger"><i class="bi bi-exclamation-octagon-fill"></i> {{
                                            ucfirst($message) }}</p>
                                        @enderror
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="mt-4 mb-2 clearfix">
                                        <button type="submit" class="btn btn-warning float-end ms-3">Update</button>
                                        <a href="{{ route('categories-submenu.index') }}"
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