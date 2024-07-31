@extends('auth.layout')

@section('title', 'Pendaftaran - Tokoku')

@section('content')

<div class="card card-primary">
    <div class="card-body">
        <h4 class="text-center text-primary">Pendaftaran</h4>
        <form method="POST" action="{{url('proses_pendaftaran')}}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    tabindex="1" autocomplete="off" value="{{old('email')}}">

                @if ($errors->has('email'))
                <p class="mt-3" style="font-size: 15px; color:red;"><i class="bi bi-exclamation-octagon-fill"></i>
                    {{ucfirst($errors->first('email'))}}
                </p>
                @endif
            </div>

            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" tabindex="2" autocomplete="off" value="{{old('password')}}">

                @if ($errors->has('password'))
                <p class="mt-3" style="font-size: 15px; color:red;"><i class="bi bi-exclamation-octagon-fill"></i>
                    {{ucfirst($errors->first('password'))}}
                </p>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Daftar
                </button>
            </div>

            <hr />

            <div class="text-center mb-3">Atau</div>

            <div class="form-group">
                <a href="{{url('redirect')}}" class="btn btn-light btn-lg btn-block" tabindex="4">
                    <i class="bi bi-google"></i> Daftar Dengan Google
                </a>
            </div>
        </form>
    </div>
</div>

<div class="text-muted text-center mb-3">
    <a href="{{url('/login')}}">Kembali Login</a>
</div>
@endsection