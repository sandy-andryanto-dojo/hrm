@extends('layouts.core')
@section('title') Perusahaan @endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Profil Perusahaan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li class="active">
                    Profil Perusahaan
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
         @include('layouts.alert')
    </div>
    <div class="clearfix"></div>
    <div class="col-md-2">
        <div class="card-box">
            @include('core.companies.image')
        </div>
    </div>
    <div class="col-md-10">
        <div class="card-box">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>Edit Profil Perusahaan</h4>
                </div>
                <div class="pull-right"></div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'companies.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <div class="form-group {{ $errors->has('nama-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Nama Perusahaan</label>
                    <div class="col-sm-10">
                       <input type="text" class="form-control"  name="nama-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('nama-perusahaan') }}" />
                       @if ($errors->has('nama-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('nama-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('npwp-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">NPWP</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="npwp-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('npwp-perusahaan') }}" />
                       @if ($errors->has('nama-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('npwp-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('kodepos-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Kode Pos</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control"  name="kodepos-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('kodepos-perusahaan') }}" />
                        @if ($errors->has('kodepos-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('kodepos-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('email-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control"  name="email-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('email-perusahaan') }}" />
                       @if ($errors->has('email-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('email-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('telepon-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Nomor Telepon</label>
                    <div class="col-sm-10">
                      <input type="tel" class="form-control" name="telepon-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('telepon-perusahaan') }}" />
                       @if ($errors->has('telepon-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('telepon-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('alamat-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Alamat Perusahaan</label>
                    <div class="col-sm-10">
                       <textarea class="form-control" rows="5" name="alamat-perusahaan" >{{ \App\Helpers\AppHelper::getSetting('alamat-perusahaan') }}</textarea>
                       @if ($errors->has('alamat-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('alamat-perusahaan') }}</small>
                            </span>
                       @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('provinsi-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Provinsi</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="provinsi-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('provinsi-perusahaan') }}" />
                       @if ($errors->has('provinsi-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('provinsi-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('kota-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Kabupaten / Kota</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="kota-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('kota-perusahaan') }}" />
                       @if ($errors->has('kota-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('kota-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('kecamatan-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Kecamatan</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="kecamatan-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('kecamatan-perusahaan') }}" />
                        @if ($errors->has('kecamatan-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('kecamatan-perusahaan') }}</small>
                            </span>
                        @endif
                    </div>
                 </div>
                 <div class="form-group {{ $errors->has('kelurahan-perusahaan') ? ' has-error' : '' }}">
                    <label for="" class="col-sm-2 control-label">Keluarahan</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="kelurahan-perusahaan" value="{{ \App\Helpers\AppHelper::getSetting('kelurahan-perusahaan') }}" />
                       @if ($errors->has('kelurahan-perusahaan'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('kelurahan-perusahaan') }}</small>
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