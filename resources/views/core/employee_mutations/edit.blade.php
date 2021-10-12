@extends('layouts.core')
@section('title') Mutasi Pegawai @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_mutations.js') }}"></script>
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
            <h4 class="page-title"> Mutasi Pegawai</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li>
                    <a href="{{ route('employee_mutations.index') }}"> Mutasi Pegawai</a>
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
                    <h4>Form Mutasi Pegawai</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_mutations.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::model($data, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'FormSubmit','route' => ['employee_mutations.update', $data->id] ,'enctype'=>'multipart/form-data']) !!}
                <div class="form-group {{ $errors->has('employee_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama Pegawai <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <select name="employee_id" id="employee_id">
                            <option value="{{ $data->employee_id }}" selected>{{ $data->Employee->employee_number }} - {{ $data->Employee ? $data->Employee->User->UserProfile->first_name." ".$data->Employee->User->UserProfile->last_name : "-" }}</option>
                        </select>
                        @if ($errors->has('employee_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('employee_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('division_from_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Divisi Asal <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" readonly="readonly" id="division_from_name" value="{{ $data->DivisionFrom ? $data->DivisionFrom->name : "-" }}" class="form-control" />
                        <input type="hidden" readonly="readonly" id="division_from_id" name="division_from_id" value="{{ $data->DivisionFrom ? $data->DivisionFrom->id : "" }}" class="form-control" />
                        @if ($errors->has('division_from_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('division_from_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('division_target_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Divisi Tujuan <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        {!! Form::select('division_target_id', $divisions->pluck('name','id'), null, ['id'=>'division_target_id','class'=>'select2', 'placeholder'=>'-- Pilih Divisi Tujuan --']) !!}
                        @if ($errors->has('division_target_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('division_target_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('reason') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Keterangan</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="reason" id="reson" rows="5">{{ $data->reason }}</textarea>
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