@extends('auth.layout')

@section('title', 'Lupa Password - ' . env('APP_NAME'))

@section('content')

<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">

            <!-- Basic Lupa Password form-->
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header justify-content-center">
                    <h3 class="fw-light my-4 text-center">Lupa Password</h3>
                </div>

                <div class="card-body">

                    @if($status = Session::get('status'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ $status }}
                    </div>
                    @endif

                    <!--  Lupa password form-->
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf

                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                type="email" placeholder="Masukkan email" required autocomplete="off" />

                            @if ($errors->has('email'))
                            <p class="mt-3" style="font-size: 15px; color:red;"><i
                                    class="bi bi-exclamation-octagon-fill"></i>
                                {{ucfirst($errors->first('email'))}}
                            </p>
                            @endif
                        </div>

                        <!-- Form Group (kirim box)-->
                        <div class="mt-4 mb-0">
                            <button type="submit" class="btn btn-primary float-end forgot-password">Kirim</button>

                            <button class="btn btn-primary float-end d-none btnLoading" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                <span role="status" class="mx-1">Loading...</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <div class="small"><a href="{{ url('login') }}">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection