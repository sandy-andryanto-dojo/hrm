@extends('layouts.core')
@section('title') Permohonan Pinjaman @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_loans.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div class="hidden">
    <div id="employee_id">{{ $employee_id }}</div>
    <div id="manager_id">{{ $manager_id }}</div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Permohonan Pinjaman</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Permohonan</a>
                </li>
                <li class="active">
                     Permohonan Pinjaman
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @include('layouts.alert')
        <div class="card-box">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>Daftar Permohonan Pinjaman</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_loans.create') }}" class="btn btn-success btn-sm btn-create-data">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Baru
                    </a>
                    <a href="{{ route('employee_loans.show', ['id'=>0]) }}" class="btn btn-warning btn-sm btn-detail">
                        <i class="fa fa-download"></i>&nbsp;Unduh
                    </a>
                </div>
            </div>
            <hr>
            <ul class="nav nav-tabs tabs-bordered nav-justified">
                <li class="active">
                    <a href="#tab1" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Riwayat Permohonan</span>
                    </a>
                </li>
                <li class="">
                    <a href="#tab2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Konfirmasi Permohonan {!! $pending > 0 ? "(<span class='notif'>".$pending."</span>)" : "" !!} </span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h1></h1>
                    <div class="table-responsive">
                        <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Total</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <h1></h1>
                    <div class="table-responsive">
                        <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table-approve">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Pegawai</th>
                                    <th>Nama Pegawai</th>
                                    <th>Total</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('core.employee_loans.approval')

@endsection