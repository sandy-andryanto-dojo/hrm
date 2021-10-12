
<!DOCTYPE html>
@php
    $title = "Akses ditolak";
    $message = "Maaf, Anda tidak diperkenankan mengakses halaman ini oleh administrator.";
    $code = "403";
@endphp
<html class="account-pages-bg">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
        <link rel="icon" href="{{ asset('assets/auth/favicon.png') }}" type="image/x-icon" />
        <!-- App title -->
        <title>{{ config('app.name') }} - {{ $title }}</title>

        <!-- App css -->
        <link href="{{ asset('assets/core/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/responsive.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js does not work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('assets/core/js/modernizr.min.js') }}"></script>

    </head>


    <body class="bg-transparent">

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                  <div class="spinner-wrapper">
                    <div class="rotator">
                      <div class="inner-spin"></div>
                      <div class="inner-spin"></div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12 text-center">

                        <div class="wrapper-page">
                            <h1 style="font-size: 78px;"><i class="fa fa-warning"></i>&nbsp;{{ $code }}</h1>
                            <h3 class="text-uppercase text-danger">{{ $title }}</h3>
                            <p class="text-muted">{!! $message  !!}</p>

                            <a class="btn btn-success waves-effect waves-light m-t-20" href="{{ url('') }}"> Kembali Ke Beranda</a>
                        </div>

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{ asset('assets/core/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/core/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/core/js/detect.js') }}"></script>
        <script src="{{ asset('assets/core/js/fastclick.js') }}"></script>
        <script src="{{ asset('assets/core/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/core/js/waves.js') }}"></script>
        <script src="{{ asset('assets/core/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/core/js/jquery.scrollTo.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/core/js/jquery.core.js') }}"></script>
        <script src="{{ asset('assets/core/js/jquery.app.js') }}"></script>

    </body>
</html>