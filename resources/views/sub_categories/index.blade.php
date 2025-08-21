@extends('layout')

@section('title', 'Menu Sub Kategori Produk - ' . env('APP_NAME'))

@section('content')

@if($success = Session::get('success'))
<script>
    Swal.fire({
        title: "Berhasil",
        text: "{{ $success }}",
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
                        <div class="page-header-icon"><i class="bi bi-tags-fill" style="font-size: 25px;"></i>
                        </div>
                        Menu Sub Kategori Produk
                    </h1>
                    <div class="page-header-subtitle">Tokoku - Daftar Menu Sub Kategori Produk Source Code</div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="container-xl px-4 mt-n10">

    <div class="row">
        <div class="col mb-4">
            <!-- Example DataTable for Dashboard Demo-->
            <div class="card mb-4">
                <div class="card-header">Sub Kategori Produk</div>

                <div class="card-body">
                    <a href="{{ route('categories-submenu.create') }}" class="btn btn-success mb-4"><i
                            class="bi bi-plus-circle-fill me-1"></i> Tambah</a>

                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @php
                            $no = 1;
                            @endphp

                            @foreach($categories as $category)
                            @foreach($category->sub_categories as $sub_category)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $sub_category->price }}</td>
                                <td>{{ $sub_category->stock }}</td>
                                <td>{{ $sub_category->status }}</td>
                                <td>{{ $sub_category->name }}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center gap-2">
                                        <a href="{{ route('categories-submenu.show', $sub_category->id) }}"
                                            class="btn btn-primary"><i class="bi bi-eye-fill me-1"></i>Lihat
                                            Lengkap</a>

                                        <a href="{{ route('categories-submenu.edit', $sub_category->id) }}"
                                            class="btn btn-warning mt-2 mb-2"><i
                                                class="bi bi-pencil-fill me-1"></i>Edit</a>

                                        <form action="{{ route('categories-submenu.destroy', $sub_category->id) }}"
                                            method="post" class="form-id-{{ $sub_category->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger w-100 btnDeleteCategories"
                                                onclick="btnDeleteSubMenuCategories('{{ $sub_category->name }}', '{{ $sub_category->id }}')">
                                                <i class="bi bi-trash-fill me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
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
@endsection