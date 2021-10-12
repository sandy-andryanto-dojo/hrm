@extends('layouts.core')
@section('title') Mutasi Pegawai @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_mutations.js') }}"></script>
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
            <h4 class="page-title">Mutasi Pegawai</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li class="active">
                     Mutasi Pegawai
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

{!! Form::model(null, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'form-approve','route' => ['employee_mutations.update', 0] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="eid" id="eid" />
{!! Form::close() !!}

<div class="row">
    <div class="col-md-12">
        @include('layouts.alert')
        <div class="card-box">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>Daftar Mutasi Pegawai</h4>
                </div>
                <div class="pull-right">
                    @if(\Auth::User()->isAdmin())
                    <a href="{{ route('employee_mutations.create') }}" class="btn btn-success btn-sm btn-create-data">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Baru
                    </a>
                    @endif
                    <a href="{{ route('employee_mutations.show', ['id'=>0]) }}" class="btn btn-warning btn-sm btn-detail">
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
                            <th>No Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Divisi Asal</th>
                            <th>Divisi Tujuan</th>
                            <th>Nama Atasan</th>
                            <th>Keterangan</th>
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

@endsection