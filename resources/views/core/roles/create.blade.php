@extends('layouts.core')
@section('title') Akses @endsection

@section('script')
    <script src="{{ asset('assets/app/js/roles.js') }}"></script>
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
            <h4 class="page-title">Manajemen Akses</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">Manajemen Akses</a>
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
                    <h4>Form Pengguna</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'roles.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama Akses <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('name') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('permissions') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Hak Akses <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                         <div class="col-md-5">
                            <div class="checkbox">
                                <input type="checkbox" id="checked-all"><label for="checked-all"><strong>Pilih Semua</strong></label> 
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        @php $i = 0; $actions = array("view","add","edit","delete"); @endphp
                        @foreach($permissions as $p)
                            <div class="col-md-3">
                                <div class="checkbox">
                                    <input type="checkbox" class="action" id="{{ $actions[$i] }}" />
                                    <label for="{{ $actions[$i] }}">
                                        <strong>{{ ucfirst($actions[$i]) }}</strong>
                                    </label> 
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @foreach($p as $perm)
                                @php 
                                    $per_found = null; if(isset($data)) $per_found = $data->hasPermissionTo($perm->name);
                                    $options = array();
                                    if(isset($data) && $data->name == 'Admin'){
                                        $options = ["disabled", "id"=>$perm->id, "class"=>  $actions[$i]];
                                    }else{
                                        $options = ["id"=>"perm".$perm->id,  "class"=>  $actions[$i]];
                                    }
                                @endphp
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        {!! Form::checkbox("permissions[]", $perm->name, $per_found,  $options) !!}
                                        <label class="{{ str_contains($perm->name, 'delete') ? 'text-danger' : '' }}" for="perm{{ $perm->id }}">{{ \App\Helpers\AppHelper::ToSentence($perm->name) }}</label> 
                                    </div>
                                </div>
                            @endforeach
                            <div class="clearfix"></div>
                            <hr>
                        @php $i++; @endphp
                        @endforeach
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