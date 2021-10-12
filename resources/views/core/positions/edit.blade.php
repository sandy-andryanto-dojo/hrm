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
                    Edit Data
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
                    <h4>Form Posisi</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('positions.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::model($data, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'FormSubmit','route' => ['positions.update', $data->id] ,'enctype'=>'multipart/form-data']) !!}
            <div class="form-group {{ $errors->has('code') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Kode</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="code" name="code" value="{{ $data->code }}" readonly="readonly">
                    @if ($errors->has('code'))
                        <span class="help-block text-danger">
                            <small>{{ $errors->first('code') }}</small>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Nama <span class="text-danger">*</span> </label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                            <small>{{ $errors->first('name') }}</small>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('hour_salary') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Gaji Per Jam  <span class="text-danger">*</span> </label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="hour_salary" name="hour_salary" value="{{ number_format($data->hour_salary, 2, ',', '.') }}">
                    @if ($errors->has('hour_salary'))
                        <span class="help-block text-danger">
                            <small>{{ $errors->first('hour_salary') }}</small>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('month_salary') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Gaji Bulanan <span class="text-danger">*</span> </label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="month_salary" name="month_salary" value="{{ number_format($data->month_salary, 2, ',', '.') }}">
                    @if ($errors->has('month_salary'))
                        <span class="help-block text-danger">
                            <small>{{ $errors->first('month_salary') }}</small>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Deskripsi </label>
                <div class="col-md-10">
                    <textarea class="form-control" id="description" name="description" rows="5">{{ $data->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block text-danger">
                            <small>{{ $errors->first('description') }}</small>
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