<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <meta name="base-url" content="{{ url('') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <title>{{ config('app.name', 'Laravel Project') }} - @yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('assets/auth/favicon.png') }}" type="image/x-icon" />

    <!-- Google Fonts -->
    <link href="{{ asset('assets/auth/font.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/auth/materialize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/core/css/icons.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/auth/bootstrap.css') }}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/auth/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('assets/auth/animate.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('assets/auth/style.css') }}" rel="stylesheet" />


<body class="login-page">
    <div class="login-box">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-logo">
                            <img src="{{ asset('assets/auth/logo-circle.png') }}" alt="" class="img-responsive img-circle align-center" />
                            <p>{{ config('app.name', 'Laravel Project') }}</p>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <!-- CORE PLUGIN JS -->
    <script src="{{ asset('assets/auth/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/auth/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/auth/waves.js') }}"></script>
    <script src="{{ asset('assets/auth/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/auth/auth.js') }}"></script>
</body>

</html>