@extends('layout')

@section('title', 'Lihat Screenshots Produk')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="ml-4">
                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <h5 class="text-primary">Screenshots Produk</h5>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card-body mx-auto ">
                            <div id="carouselExampleIndicators3" class="carousel slide mb-4" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators3" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators3" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators3" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    @foreach($getFiles as $index => $img)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('assets/' . $folderExtract . '/' . $img) }}"
                                            class="rounded mx-auto d-block w-100" alt="screenshots">
                                    </div>
                                    @endforeach

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>


                            <a href="{{url('/menu_produk')}}" class="btn btn-danger">Kembali</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection