<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>@yield('title')</title>

    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    {{--
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script data-search-pseudo-elements defer
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>

    <style>
        .containerIcon:hover {
            cursor: pointer;
        }

        .initIcons:hover {
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{asset('assets/js/script-auth.js')}}"></script>
</body>

</html>