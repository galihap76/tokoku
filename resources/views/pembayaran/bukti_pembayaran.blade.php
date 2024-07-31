@extends('layout')

@section('title', 'Bukti Pembayaran')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Bukti Pembayaran {{ Auth::user()->role_id == 2 ? "Anda" : "" }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>

                                @if (Auth::user()->role_id == 2)
                                <th class="text-center">
                                    No
                                </th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Invoice</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                                @endif

                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $no = 1;
                            @endphp

                            @if(Auth::user()->role_id == 2)

                            @foreach($produk as $data)
                            @foreach($data->produk_beli as $item)

                            <tr class="text-center">
                                <td>
                                    {{$no++}}
                                </td>
                                <td>{{$data->nama}}</td>
                                <td>{{$item->order_id}}</td>
                                <td>{{ ucfirst($item->status)}}</td>
                                <td class="d-flex justify-content-center">

                                    @if($item->status == 'pending' || $item->status == 'deny')
                                    <a href="{{ route('metode_pembayaran', $item->order_id) }}"
                                        class="btn btn-danger"><i class="bi bi-credit-card-fill mx-1"></i>Selesaikan
                                        Pembayaran
                                    </a>

                                    @elseif($item->status == 'success')
                                    <a href="{{ route('download_bukti_pembayaran', $item->order_id) }}"
                                        class="btn btn-success"><i class="bi bi-file-pdf-fill mx-1"></i>Unduh
                                        Bukti</a>
                                    @endif
                                </td>
                            </tr>

                            @endforeach
                            @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection