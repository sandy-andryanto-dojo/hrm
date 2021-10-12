@extends('layouts.core')
@section('title') Detail Pegawai @endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Detail Pegawai</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li class="active">
                    Profil Pengguna
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
         @include('layouts.alert')
    </div>
    <div class="clearfix"></div>
    <div class="col-md-2">
        <div class="card-box">
            @include('core.profiles.image')
        </div>
    </div>
    <div class="col-md-10 profiles">
        <div class="card-box">
            <ul class="nav nav-tabs tabs-bordered nav-justified">
                <li class="active">
                    <a href="#tab1" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Detail Pegawai</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>1]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Biodata</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>2]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Pengalaman</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>3]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Riwayat Pendidikan</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>4]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Keahlian</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>5]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Kemampuan Bahasa</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>6]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Lampiran</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <table class="table table-striped table-colored table-info dt-responsive nowrap">
                        <tr>
                            <td width="200">NIK</td>
                            <td width="50">:</td>
                            <td>{{ $data->employee_number }}</td>
                        </tr>
                        <tr>
                            <td>Nama Pegawai</td>
                            <td>:</td>
                            <td>{{ $data->User ? $data->User->UserProfile->first_name." ".$data->User->UserProfile->last_name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Posisi</td>
                            <td>:</td>
                            <td>{{ $data->Position ? $data->Position->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Divisi</td>
                            <td>:</td>
                            <td>{{ $data->Division ? $data->Division->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Nama Atasan</td>
                            <td>:</td>
                            <td>{{ $data->Division && $data->Division->Superior ? $data->Division->Superior->first_name."  ".$data->Division->Superior->last_name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Tipe Pegawai</td>
                            <td>:</td>
                            <td>{{ $data->EmployeeType ? $data->EmployeeType->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Gabung</td>
                            <td>:</td>
                            <td>{{ $data->join_date }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Awal Kontrak</td>
                            <td>:</td>
                            <td>{{ $data->start_contract_date ? $data->start_contract_date : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Akhir Kontrak</td>
                            <td>:</td>
                            <td>{{ $data->end_contract_date ? $data->end_contract_date : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Profesi</td>
                            <td>:</td>
                            <td>{{ $data->Job ? $data->Job->name : "-" }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection