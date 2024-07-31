@extends('auth.layout')

@section('title', 'Reset Password - Tokoku')

@section('content')

<div class="card card-primary">

    <div class="card-body">
        <h4 class="text-center text-primary mb-4">Reset Password</h4>

        @if($errors->has('token') || $errors->has('email'))
        <div class="alert alert-danger text-center" role="alert">
            Proses reset password gagal di lakukan.
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request()->token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" tabindex="1" autocomplete="off">

                @if ($errors->has('password'))
                <p class="mt-3" style="font-size: 15px; color:red;"><i class="bi bi-exclamation-octagon-fill"></i>
                    {{ucfirst($errors->first('password'))}}
                </p>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation" tabindex="1" autocomplete="off">

                @if ($errors->has('password_confirmation'))
                <p class="mt-3" style="font-size: 15px; color:red;"><i class="bi bi-exclamation-octagon-fill"></i>
                    {{ucfirst($errors->first('password_confirmation'))}}
                </p>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Reset Password
                </button>
            </div>

        </form>
    </div>
</div>
@endsection