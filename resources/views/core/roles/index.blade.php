@extends('layouts.core')
@section('title') Akses @endsection

@section('script')
    <script src="{{ asset('assets/app/js/roles.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Akses Pengguna</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li class="active">
                    Manajemen Akses
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
                    <h4>Daftar Akses</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm btn-create-data">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Baru
                    </a>
                    <a href="{{ route('roles.show', ['id'=>0]) }}" class="btn btn-warning btn-sm btn-detail">
                        <i class="fa fa-download"></i>&nbsp;Unduh
                    </a>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Akses</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection