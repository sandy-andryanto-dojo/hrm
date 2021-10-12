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
                        Detail Data
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
                    <h4>Detail Akses</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('roles.create') }}" class="btn btn-success btn-create-data btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Data
                    </a>
                    <a href="{{ route('roles.edit',['category'=>$data->id]) }}"
                        class="btn btn-info btn-edit-data btn-sm">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap is-detail">
                <tr>
                    <td width="200">Nama Akses</td>
                    <td width="50">:</td>
                    <td>{{ $data->name }}</td>
                </tr>
                <tr>
                    <td>Hak Akses</td>
                    <td>:</td>
                    <td>
                        <div class="row">
                            @php $i = 0; $actions = array("view","add","edit","delete"); @endphp
                            @foreach($permissions as $p)
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
                                        <label class="{{ str_contains($perm->name, 'delete') ? 'text-danger' : '' }}" for="perm{{ $perm->id }}">
                                            <i class="fa fa-{{ $per_found == 1 ? 'check' : 'ban' }}"></i>&nbsp;{{ \App\Helpers\AppHelper::ToSentence($perm->name) }}
                                        </label> 
                                    </div>
                                @endforeach
                                <div class="clearfix"></div>
                                <hr>
                            @php $i++; @endphp
                            @endforeach
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection