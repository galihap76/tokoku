@extends('layout')

@section('title', 'Kategori Produk - ' . env('APP_NAME'))

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
                        <div class="page-header-icon"><i class="bi-speedometer2" style="font-size: 25px;"></i></div>
                        Kategori Produk
                    </h1>
                    <div class="page-header-subtitle">Tokoku - Daftar Kategori Produk Source Code</div>
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
                <div class="card-header">Daftar Kategori Produk Source Code</div>

                <div class="card-body">
                    <a href="{{ route('categories-menu.create') }}" class="btn btn-success mb-4"><i
                            class="bi bi-plus-circle-fill me-1"></i> Tambah</a>

                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Tanggal Dibuat</th>
                                <th>Tanggal Diupdate</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Tanggal Dibuat</th>
                                <th>Tanggal Diupdate</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @php
                            $no = 1;
                            @endphp

                            @foreach($categories as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td><img src="{{ asset('storage/' . $item->image) }}"
                                        style="width:250px; height: 250px;"></td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                <td>

                                    <div class="text-center">
                                        <a href="{{ route('categories-menu.edit', $item->id) }}"
                                            class="btn btn-warning mb-3"><i class="bi bi-pencil-fill me-1"></i>
                                            Edit Kategori</a>

                                        <form action="{{ route('categories-menu.destroy', $item->id) }}" method="post"
                                            class="form-id-{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-danger mb-3 btnDeleteCategories"
                                                onclick="btnDeleteCategories('{{ $item->name }}', '{{ $item->id }}')"><i
                                                    class="bi bi-trash-fill me-1"></i> Delete</button>
                                        </form>
                                    </div>

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
@endsection