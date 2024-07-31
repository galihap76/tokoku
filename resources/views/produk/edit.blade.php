@extends('layout')

@section('title', 'Update Produk')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="card shadow p-3 mb-5 bg-white rounded mt-3">

                <div class="ml-4">
                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <h5 class="text-primary">Update Produk</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <form method="post" action="{{ route('menu_produk.update', $data->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group mr-3">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control border border-primary" id="nama" name="nama"
                                        autocomplete="off" value="{{$data->nama}}">
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
                                        name="deskripsi" autocomplete="off" value="{{$data->deskripsi}}">
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
                                        name="harga" autocomplete="off" value="{{$data->harga}}">
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
                                        <option selected value="{{$data->status}}">{{ucwords($data->status)}}</option>

                                        @php
                                        $statusData = [
                                        'tersedia',
                                        'masih dalam pengembangan',
                                        'tidak tersedia'
                                        ];
                                        @endphp

                                        @foreach($statusData as $item)
                                        @if($item != $data->status)
                                        <option value="{{$item}}">{{ucwords($item)}}</option>
                                        @endif
                                        @endforeach

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
                                        <input type="file" class="custom-file-input" name="file" id="file">
                                        <label class="custom-file-label border border-primary">{{ $data->file }}</label>
                                    </div>
                                </div>

                                <i>* Kosongkan jika tidak mengupload</i>

                                <hr />

                                <button type="submit" class="btn btn-primary mr-3">Update</button>
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