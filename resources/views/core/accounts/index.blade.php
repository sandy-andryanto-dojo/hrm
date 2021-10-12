@extends('layouts.core')
@section('title') Pengaturan Akun @endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Pengaturan Akun</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li class="active">
                    Akun Pengguna
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
                    <h4>Edit Akun</h4>
                </div>
                <div class="pull-right"></div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'accounts.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Username <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="username" name="username" value="{{ $data->username }}">
                        @if ($errors->has('username'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('username') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Email <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $data->email }}">
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
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $data->phone }}">
                        @if ($errors->has('phone'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('phone') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Kata Sandi</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" name="password" id="password" value="" >
                        @if ($errors->has('password'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('password') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Konfirmasi Kata Sandi</label>
                    <div class="col-md-10">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" >
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('password_confirmation') }}</small>
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