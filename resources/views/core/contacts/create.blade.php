@extends('layouts.core')
@section('title') Kontak Person @endsection

@section('script')
    <script src="{{ asset('assets/app/js/contacts.js') }}"></script>
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
            <h4 class="page-title"> Kontak Person</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Master Data</a>
                </li>
                <li>
                    <a href="{{ route('contacts.index') }}"> Kontak Person</a>
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
                    <h4>Form Kontak Person</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('contacts.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'contacts.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
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
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Email </label>
                    <div class="col-md-10">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('email') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nomor Telepon</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('phone') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Website</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="website" name="website" value="{{ old('website') }}">
                        @if ($errors->has('website'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('website') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('postal_code') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Kode Pos</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                        @if ($errors->has('postal_code'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('postal_code') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Alamat </label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="address" name="address" rows="5">{{ old('address') }}</textarea>
                        @if ($errors->has('address'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('address') }}</small>
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