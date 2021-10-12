<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $data->employee_number }}</title>


    <link href="{{ asset('assets/core/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/core/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <!-- Plugins -->
    @yield('stylesheet')


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js does not work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body onload='window.print();'>


    <section class="content content_content" style="width: 70%; margin: auto;">
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-users"></i> Slip Gaji Periode {{ $month_name }} {{ $year }} 
                        <small class="pull-right">Tanggal Cetak : {{ now() }}</small>
                    </h2>
                </div><!-- /.col -->
            </div>
            <!-- info row -->
            @php 
               $mn = (int)$month > 9 ? $month : "0".$month;
               $totalDays =  \Carbon\Carbon::parse($year."-".$mn."-01")->daysInMonth;
               $firstDate = $year."-".$mn."-01";
               $lastDate = $year."-".$mn."-".$totalDays;
            @endphp
            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col text-left">
                    <address>
                        <strong>
                            Nama Perusahaan : {{ \App\Helpers\AppHelper::getSetting('nama-perusahaan') }} 
                        </strong>
                        <br>
                        <strong>
                            Tanggal Periode : {{ $firstDate }} s/d {{ $lastDate }}
                        </strong>
                        <br>
                        <strong>
                            Divisi : {{ $data->Division ? $data->Division->name : "-" }} 
                        </strong>
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-6 invoice-col text-left">
                    <address>
                        <strong>
                            No Pegawai : {{ $data->employee_number }}
                        </strong>
                        <br>
                        <strong>
                            Nama Pegawai : {{ $data->User->UserProfile->first_name." ".$data->User->UserProfile->last_name }}
                        </strong>
                        <br>
                        <strong>
                            Posisi : {{ $data->Position ? $data->Position->name : "-" }}
                        </strong>
                    </address>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-6 table-responsive">
                    <table class="table table-striped table-colored table-info dt-responsive nowrap">
                        <tr class="">
                            <td colspan="3">
                                <strong># DETAIL PENDAPATAN</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Gaji Pokok</td>
                            <td>:</td>
                            <td>{{ number_format($data->Position->month_salary ? $data->Position->month_salary : 0, 2, ',', '.') }}</td>
                        </tr>
                        @foreach($allowances as $a)
                        <tr>
                            <td>{{ $a["name"] }}</td>
                            <td>:</td>
                            <td>{{ number_format($a["cost"], 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="success">
                            <td>
                                <strong>TOTAL</strong>
                            </td>
                            <td>:</td>
                            <td><strong>{{ number_format($totalAllowances + $data->Position->month_salary, 2, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div><!-- /.col -->
                <div class="col-xs-6 table-responsive">
                    <table class="table table-striped table-colored table-info dt-responsive nowrap">
                        <tr class="">
                            <td colspan="3">
                                <strong># DETAIL POTONGAN</strong>
                            </td>
                        </tr>
                        @foreach($cuts as $c)
                        <tr>
                            <td>{{ $c["name"] }}</td>
                            <td>:</td>
                            <td>{{ number_format($c["cost"], 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr class="success">
                            <td>
                                <strong>TOTAL</strong>
                            </td>
                            <td>:</td>
                            <td><strong>{{ number_format($totalCuts, 2, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div>
                <h1></h1>
                <div class="col-md-12">
                    <table class="table table-striped table-colored table-info dt-responsive nowrap text-center">
                        <tr class="">
                            <td colspan="3">
                                <strong># GAJI BERSIH = IDR {{ number_format($takeHome, 2, ',', '.') }} (PENDAPATAN - POTONGAN)</strong>
                            </td>
                        </tr>
                        <tr class="">
                            <td colspan="3"><strong><i>TERBILANG : {{ strtoupper(\App\Helpers\AppHelper::terbilang($takeHome)) }} RUPIAH</i></strong></td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.row -->
           
           
          

        </section>
    </section>

    <script src="{{ asset('assets/core/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/core/js/bootstrap.min.js') }}"></script>
    @yield('script')

</body>

</html>