@extends('layouts.core')
@section('title') Mutasi Pegawai @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_retireds.js') }}"></script>
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
            <h4 class="page-title"> Mutasi Pegawai</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li>
                    <a href="{{ route('employee_retireds.index') }}"> Mutasi Pegawai</a>
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
                    <h4>Detail Mutasi Pegawai</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_retireds.create') }}" class="btn btn-success btn-create-data btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Data
                    </a>
                    <a href="{{ route('employee_retireds.edit',['category'=>$data->id]) }}"
                        class="btn btn-info btn-edit-data btn-sm">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('employee_retireds.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">No Pegawai</td>
                    <td width="50">:</td>
                    <td>{{ $data->Employee->employee_number }}</td>
                </tr>
                <tr>
                    <td>Nama Pegawai</td>
                    <td>:</td>
                    <td>{{ $data->Employee ? $data->Employee->User->UserProfile->first_name." ".$data->Employee->User->UserProfile->last_name : "-" }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pensiun</td>
                    <td>:</td>
                    <td>{{ $data->date_retired ? $data->date_retired : "-" }}</td>
                </tr>
                <tr>
                    <td>Nama Atasan</td>
                    <td>:</td>
                    <td>{{ $data->Manager ? $data->Manager->User->UserProfile->first_name." ".$data->Manager->User->UserProfile->last_name : "-" }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>{!! \App\Helpers\AppHelper::getAnnualStatus($data->is_approved) !!}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>{{ $data->manager_notes ? $data->manager_notes : "-" }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection