@extends('layout')

@section('title', 'Extract Screenshots')

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

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Extract Screenshots</h4>
                </div>

                <div class="card-body">

                    <!-- Pilih produk  -->
                    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#pilihProduk">
                        <i class="bi bi-cart-fill"></i> Pilih Produk
                    </button>

                    <form method="post" action="{{url('proses_extract_screenshots')}}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="produk_id" id="produk_id">

                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                autocomplete="off" readonly>
                        </div>

                        @if ($errors->has('nama_produk'))
                        <p class="mt-3" style="font-size: 15px; color:red;"><i
                                class="bi bi-exclamation-octagon-fill"></i>
                            {{ucfirst($errors->first('nama_produk'))}}
                        </p>
                        @endif

                        <label for="file">Extract ZIP / RAR yang berisi screenshots</label>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file"
                                    aria-describedby="file">
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                        </div>

                        @if ($errors->has('file'))
                        <p class="mt-3" style="font-size: 15px; color:red;"><i
                                class="bi bi-exclamation-octagon-fill"></i>
                            {{ucfirst($errors->first('file'))}}
                        </p>
                        @endif

                        <i>* Silakan pilih produk untuk menampilkan screenshots dari produk tersebut.</i>

                        <button type="submit" name="extract" class="btn btn-success mt-3 float-right">Extract</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Pilih Produk Modal -->
<div class="modal fade" id="pilihProduk" tabindex="-1" aria-labelledby="pilihProdukLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pilihProdukLabel">Pilih Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Produk</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $no = 1;
                            @endphp

                            @foreach($produk as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary"
                                        onclick="btnPilih('{{ $item->nama }}', {{ $item->id }})"
                                        data-dismiss="modal">Pilih</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>