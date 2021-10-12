@extends('layouts.core')
@section('title') Promosi Pegawai @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_promotions.js') }}"></script>
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
            <h4 class="page-title"> Promosi Pegawai</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li>
                    <a href="{{ route('employee_promotions.index') }}"> Promosi Pegawai</a>
                </li>
                <li class="active">
                    Tambah Data
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
                    <h4>Form Promosi Pegawai</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_promotions.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'employee_promotions.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <div class="form-group {{ $errors->has('employee_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama Pegawai <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <select name="employee_id" id="employee_id"></select>
                        @if ($errors->has('employee_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('employee_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('position_target_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Posisi Tujuan <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        {!! Form::select('position_target_id', $positions->pluck('name','id'), null, ['id'=>'position_target_id','class'=>'select2', 'placeholder'=>'-- Pilih Posisi Tujuan --']) !!}
                        @if ($errors->has('position_target_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('position_target_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('reason') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Keterangan</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="reason" id="reson" rows="5"></textarea>
                        @if ($errors->has('reason'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('reason') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
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