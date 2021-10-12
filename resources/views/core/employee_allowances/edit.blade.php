@extends('layouts.core')
@section('title') Tunjangan @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_allowances.js') }}"></script>
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
            <h4 class="page-title"> Tunjangan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li>
                    <a href="{{ route('employee_allowances.index') }}"> Data Tunjangan</a>
                </li>
                <li class="active">
                    @if($is_edit)
                        Edit Data
                    @else 
                        Tambah Data
                    @endif
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
                    <h4>Form Tunjangan</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_allowances.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::model($data, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'FormSubmit','route' => ['employee_allowances.update', $data->id] ,'enctype'=>'multipart/form-data']) !!}
            <div class="form-group">
                <label class="col-md-2 control-label">No Pegawai</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" readonly="readonly" value="{{ $data->employee_number }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Nama Pegawai</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" readonly="readonly" value="{{ $data->User->UserProfile->first_name." ".$data->User->UserProfile->last_name }}">
                </div>
            </div>
            @foreach($allowances as $row)
            <div class="form-group">
                <label class="col-md-2 control-label">{{ $row["name"] }}</label>
                <div class="col-md-10">
                    <input type="text" class="form-control input-cost" name="cost[]" value="{{ number_format($row["cost"], 2, ',', '.') }}">
                    <input type="hidden" class="form-control" name="type_id[]" value="{{ $row["type_id"] }}">
                </div>
            </div>
            @endforeach
            <div class="form-group">
                <label class="col-md-2 control-label"></label>
                <div class="col-md-10">
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        <i class="fa fa-save"></i>&nbsp; Simpan
                    </button>
                    <button type="reset" class="btn btn-warning waves-effect waves-light">
                        <i class="fa fa-refresh"></i>&nbsp; Reset
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection