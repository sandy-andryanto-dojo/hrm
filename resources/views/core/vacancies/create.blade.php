@extends('layouts.core')
@section('title') Lowongan @endsection

@section('script')
    <script src="{{ asset('assets/app/js/vacancies.js') }}"></script>
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
            <h4 class="page-title"> Lowongan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Perekrutan</a>
                </li>
                <li>
                    <a href="{{ route('vacancies.index') }}"> Lowongan</a>
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
                    <h4>Form Lowongan</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('vacancies.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'vacancies.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama Lowongan <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('name') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('type_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Tipe Pegawai <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        {!! Form::select('type_id', $types->pluck('name','id'), null, ['id'=>'type','class'=>'select2', 'placeholder'=>'-- Pilih Tipe Pegawai --']) !!}
                        @if ($errors->has('type_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('type_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('job_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Pekerjaan <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        {!! Form::select('job_id', $jobs->pluck('name','id'), null, ['id'=>'type','class'=>'select2', 'placeholder'=>'-- Pilih Pekerjaan --']) !!}
                        @if ($errors->has('job_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('job_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('position_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Posisi <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        {!! Form::select('position_id', $position->pluck('name','id'), null, ['id'=>'type','class'=>'select2', 'placeholder'=>'-- Pilih Posisi --']) !!}
                        @if ($errors->has('position_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('position_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('division_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Divisi <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        {!! Form::select('division_id', $division->pluck('name','id'), null, ['id'=>'type','class'=>'select2', 'placeholder'=>'-- Pilih Divisi --']) !!}
                        @if ($errors->has('division_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('division_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Tanggal Mulai <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input-datepicker" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        @if ($errors->has('start_date'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('start_date') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Tanggal Akhir <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input-datepicker" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @if ($errors->has('end_date'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('end_date') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Lokasi <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}">
                        @if ($errors->has('location'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('location') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('min_salary') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Gaji Minimal <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input_money" id="min_salary" name="min_salary" value="{{ old('min_salary') }}">
                        @if ($errors->has('min_salary'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('min_salary') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('max_salary') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Gaji Maksimal <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input_money" id="max_salary" name="max_salary" value="{{ old('max_salary') }}">
                        @if ($errors->has('max_salary'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('max_salary') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Deskripsi </label>
                    <div class="col-md-10">
                        <textarea class="summernote" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('description') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('is_closed') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-10">
                        <div class="radio radio-inline radio-primary">
                            <input id="status1" type="radio" name="is_closed" value="0">
                            <label for="status1">
                                Aktif
                            </label>
                        </div>
                        <div class="radio radio-inline radio-primary">
                            <input id="status2" type="radio" name="is_closed" value="1">
                            <label for="status2">
                                Tidak Aktif
                            </label>
                        </div>
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