@extends('auth.layout')

@section('title', 'Login - Tokoku')

@section('content')

<div class="card card-primary">

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

    <div class="card-body">
        <h4 class="text-center text-primary">Login</h4>

        @if($logout = Session::get('logout'))
        <div class="alert alert-success text-center" role="alert">
            {{ $logout }}
        </div>

        @elseif($status = Session::get('status'))
        <div class="alert alert-success text-center" role="alert">
            Reset password berhasil. Silakan login terlebih dahulu.
        </div>
        @endif

        <form method="POST" action="{{url('proses_login')}}">
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
                    <div class="float-right">
                        <a href="{{url('lupa_password')}}" class="text-small">
                            Lupa Password?
                        </a>
                    </div>
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
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me"
                        @if(old('remember')) checked @endif>
                    <label class="custom-control-label" for="remember-me">Remember Me</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Login
                </button>
            </div>

            <hr />

            <div class="text-center mb-3">Atau</div>

            <div class="form-group">
                <a href="{{url('redirect')}}" class="btn btn-light btn-lg btn-block" tabindex="4">
                    <i class="bi bi-google"></i> Masuk Dengan Google
                </a>
            </div>
        </form>
    </div>
</div>

<div class="mt-3 mb-3 text-muted text-center">
    Belum mendaftar? <a href="{{url('/pendaftaran')}}">Daftar</a>
</div>

@endsection