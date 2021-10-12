@extends('layouts.core')
@section('title') Dashboard @endsection

@section('script')
    <script src="{{ asset('assets/core/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/app/js/dashboards.js') }}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Dashboard</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li class="active">
                    Dashboard Utama
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">

    <div class="col-md-2">
        <div class="card-box widget-box-two widget-two-success">
            <i class="mdi mdi-account-multiple widget-two-icon"></i>
            <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Pegawai">Pegawai</p>
                <h2 class="text-white"><span  id="employee">0</span></h2>
                <h1></h1>
                <br>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-md-2">
        <div class="card-box widget-box-two widget-two-danger">
            <i class="mdi mdi-hospital-building widget-two-icon"></i>
            <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Divisi">Divisi</p>
                <h2 class="text-white"><span  id="division">0</span></h2>
                <h1></h1>
                <br>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-md-2">
        <div class="card-box widget-box-two widget-two-primary">
            <i class="mdi mdi-account-card-details widget-two-icon"></i>
            <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Lowongan">Lowongan</p>
                <h2 class="text-white"><span  id="vacancy">0</span></h2>
                <h1></h1>
                <br>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-md-2">
        <div class="card-box widget-box-two widget-two-info">
            <i class="mdi mdi-autorenew widget-two-icon"></i>
            <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Mutasi">Mutasi</p>
                <h2 class="text-white"><span  id="mutation">0</span></h2>
                <h1></h1>
                <br>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-md-2">
        <div class="card-box widget-box-two widget-two-purple">
            <i class="mdi mdi-account-check widget-two-icon"></i>
            <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Promosi">Promosi</p>
                <h2 class="text-white"><span  id="promotion">0</span></h2>
                <h1></h1>
                <br>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-md-2">
        <div class="card-box widget-box-two widget-two-warning">
            <i class=" mdi mdi-account-off widget-two-icon"></i>
            <div class="wigdet-two-content text-white">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Pensiun">Pensiun</p>
                <h2 class="text-white"><span  id="retired">0</span></h2>
                <h1></h1>
                <br>
            </div>
        </div>
    </div><!-- end col -->

    <div class="clearfix"></div>
    <div class="col-md-4">
        <div class="card-box">
            <h4 class="header-title m-t-0">Permohonan Cuti  {{ $period }}</h4>
            <p class="text-muted font-13 m-b-10"></p> 
            <canvas id="chart_cuti"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <h4 class="header-title m-t-0">Permohonan Dinas  {{ $period }}</h4>
            <p class="text-muted font-13 m-b-10"></p> 
            <canvas id="chart_dinas"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <h4 class="header-title m-t-0">Permohonan Lembur  {{ $period }}</h4>
            <p class="text-muted font-13 m-b-10"></p> 
            <canvas id="chart_lembur"></canvas>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="header-title m-t-0">Grafik Jumlah Pegawai</h4>
            <p class="text-muted font-13 m-b-10"></p>   
            <canvas id="chart_employee"></canvas>
        </div>
    </div>

   
    

</div>

@endsection