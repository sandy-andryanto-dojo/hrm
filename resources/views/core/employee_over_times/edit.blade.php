@extends('layouts.core')
@section('title') Permohonan Lembur @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_over_times.js') }}"></script>
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
            <h4 class="page-title"> Permohonan Lembur</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Permohonan</a>
                </li>
                <li>
                    <a href="{{ route('employee_over_times.index') }}"> Permohonan Lembur</a>
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
                    <h4>Form Permohonan Lembur</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_over_times.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::model($data, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'FormSubmit','route' => ['employee_over_times.update', $data->id] ,'enctype'=>'multipart/form-data']) !!}
                <div class="form-group {{ $errors->has('request_date') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Tanggal Lembur <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input-datepicker" id="request_date" name="request_date" value="{{ $data->request_date }}">
                        @if ($errors->has('request_date'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('request_date') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('start_hour') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Waktu Mulai <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input-hour" id="start_hour" name="start_hour" value="{{ $data->start_hour }}">
                        @if ($errors->has('start_hour'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('start_hour') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('end_hour') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Waktu Selesai <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input-hour" id="end_hour" name="end_hour" value="{{ $data->end_hour }}">
                        @if ($errors->has('end_hour'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('end_hour') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Alasan Lembur </label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="reason" name="reason" rows="5">{{ $data->reason }}</textarea>
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