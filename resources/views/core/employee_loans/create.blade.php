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
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title"> Permohonan Pinjaman</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Permohonan</a>
                </li>
                <li>
                    <a href="{{ route('employee_loans.index') }}"> Permohonan Pinjaman</a>
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
                    <h4>Form Permohonan Pinjaman</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_loans.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'employee_loans.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Total Pinjaman </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="cost" id="cost" value="{{ old('cost') ? old('cost') : 0 }}" />
                        @if ($errors->has('cost'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('cost') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Alasan Pinjaman </label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="reason" name="reason" rows="5">{{ old('reason') }}</textarea>
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