@extends('auth.layout')

@section('title', 'Lupa Password - Tokoku')

@section('content')

<div class="card card-primary">

    <div class="card-body">
        <h4 class="text-center text-primary mb-3">Lupa Password</h4>

        @if(session()->has('status'))
        <div class="alert alert-success text-center" role="alert">
            {{session()->get('status')}}
        </div>
        @endif

        <form method="POST" action="{{route('password.email')}}">
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
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Kirim
                </button>
            </div>

        </form>
    </div>
</div>

<div class="text-muted text-center mb-3">
    <a href="{{url('/login')}}">Kembali Login</a>
</div>
@endsection