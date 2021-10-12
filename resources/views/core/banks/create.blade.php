@extends('layouts.core')
@section('title') Bank @endsection

@section('script')
    <script src="{{ asset('assets/app/js/banks.js') }}"></script>
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
            <h4 class="page-title"> Bank</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Master Data</a>
                </li>
                <li>
                    <a href="{{ route('banks.index') }}"> Bank</a>
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
                    <h4>Form Bank</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('banks.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'banks.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('name') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Negara </label>
                    <div class="col-md-10">
                        {!! Form::select('country_id', $countries->pluck('name','id'), null, ['id'=>'type','class'=>'select2', 'placeholder'=>'-- Pilih Negara --']) !!}
                        @if ($errors->has('country_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('country_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Deskripsi </label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
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