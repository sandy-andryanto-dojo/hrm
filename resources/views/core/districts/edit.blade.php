@extends('layouts.core')
@section('title') Kecamatan @endsection

@section('script')
    <script src="{{ asset('assets/app/js/districts.js') }}"></script>
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
            <h4 class="page-title"> Kecamatan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Master Data</a>
                </li>
                <li>
                    <a href="{{ route('districts.index') }}"> Kecamatan</a>
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
                    <h4>Form Kecamatan</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('districts.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::model($data, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'FormSubmit','route' => ['districts.update', $data->id] ,'enctype'=>'multipart/form-data']) !!}
                
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama Kecamatan<span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('name') }}</small>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('province_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Provinsi <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        {!! Form::select('province_id', $provinces->pluck('name','id'), $data->Regency->province_id, ['id'=>'province_id','class'=>'select2', 'placeholder'=>'-- Pilih Provinsi --']) !!}
                        @if ($errors->has('province_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('province_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('regency_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Kabupaten / Kota <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <select name="regency_id" id="regency_id">
                            <option value="{{ $data->regency_id }}" selected="selected">{{ $data->Regency->name }}</option>
                        </select>
                        @if ($errors->has('regency_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('regency_id') }}</small>
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