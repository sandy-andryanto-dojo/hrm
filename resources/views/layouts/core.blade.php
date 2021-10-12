<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('') }}">
        <meta name="api-token" content={!! json_encode(Auth::guard("api")->tokenById(Auth::User()->id)) !!}>
        @yield('meta')

        <!-- App favicon -->
        <link rel="icon" href="{{ asset('assets/auth/favicon.png') }}" type="image/x-icon" />
        <!-- App title -->
        <title>{{ config('app.name', 'Laravel Project') }} - @yield('title')</title>

        <!-- Plugins css -->
        <link href="{{ asset('assets/core/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/core/plugins/switchery/switchery.min.css') }}">
        <link href="{{ asset('assets/core/plugins/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/plugins/cropper/cropper.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/plugins/cropper/main.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/core/plugins/bootstrap-sweetalert/sweet-alert.css') }}" rel="stylesheet" />

        <!-- DataTables -->
        <link href="{{ asset('assets/core/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/core/plugins/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/core/plugins/datatables/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/core/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/core/plugins/datatables/scroller.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/core/plugins/datatables/dataTables.colVis.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/core/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/core/plugins/datatables/fixedColumns.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Jquery filer css -->
        <link href="{{ asset('assets/core/plugins/jquery.filer/css/jquery.filer.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/core/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet" />

        <!-- Clock Picker -->
        <link href="{{ asset('assets/core/plugins/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">

        <!-- Summernote css -->
        <link href="{{ asset('assets/core/plugins/summernote/summernote.css') }}" rel="stylesheet" />


        <!-- App css -->
        <link href="{{ asset('assets/core/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/core/css/responsive.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/app/css/custom.css') }}" rel="stylesheet" type="text/css" />
        @yield('stylesheets')

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js does not work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('assets/core/js/modernizr.min.js') }}"></script>
        

    </head>


    <body class="fixed-left">
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
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

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            @include('layouts.core-top-bar')
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.core-left-bar')
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        @yield('content')
                    </div> <!-- container -->
                </div> <!-- content -->
                <footer class="footer text-right">
                    {{ date('Y') }} © {{ config('app.name', 'Laravel Project') }}.
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->

        <div id="template-notif" class="hidden">
            <li>
                <a href="#" target="_blank" class="user-list-item">
                    <div class="icon bg-info">
                        <i class="mdi mdi-comment"></i>
                    </div>
                    <div class="user-desc">
                        <span class="name"></span>
                        <span class="time"></span>
                    </div>
                </a>
            </li>
        </div>

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
        <script src="{{ asset('assets/core/plugins/switchery/switchery.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script> 
        <script src="{{ asset('assets/core/plugins/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/cropper/cropper.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/cropper/main.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/core/plugins/bootstrap-sweetalert/sweet-alert.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/core/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/core/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.bootstrap.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/buttons.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.scroller.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.colVis.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/numeral.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/jquery.filer/js/jquery.filer.min.js') }}"></script>
        <script src="{{ asset('assets/core/plugins/summernote/summernote.min.js') }}"></script>


        <!-- App js -->
        <script src="{{ asset('assets/core/js/jquery.core.js') }}"></script>
        <script src="{{ asset('assets/core/js/jquery.app.js') }}"></script>
        <script src="{{ asset('assets/app/js/a1034.core.js') }}"></script>
        @yield('script')
    </body>
</html>