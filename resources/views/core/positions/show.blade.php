@extends('layouts.core')
@section('title') Posisi @endsection

@section('script')
    <script src="{{ asset('assets/app/js/positions.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

{{ Form::open(['method' => $form['method'],'id'=>'form-delete', 'route' =>  $form['route']]) }}
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title"> Posisi</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Organisasi</a>
                </li>
                <li>
                    <a href="{{ route('positions.index') }}"> Posisi</a>
                </li>
                <li class="active">
                    Detail Data
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
                    <h4>Detail Posisi</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('positions.create') }}" class="btn btn-success btn-create-data btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Data
                    </a>
                    <a href="{{ route('positions.edit',['category'=>$data->id]) }}"
                        class="btn btn-info btn-edit-data btn-sm">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('positions.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">Kode</td>
                    <td width="50">:</td>
                    <td>{{ $data->code }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $data->name }}</td>
                </tr>
                <tr>
                    <td>Gaji Per Jam</td>
                    <td>:</td>
                    <td>{{ number_format($data->hour_salary, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Gaji Bulanan</td>
                    <td>:</td>
                    <td>{{ number_format($data->month_salary, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>:</td>
                    <td>{{ $data->description }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection