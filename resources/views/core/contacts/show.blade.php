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

{{ Form::open(['method' => $form['method'],'id'=>'form-delete', 'route' =>  $form['route']]) }}
{{ Form::close() }}

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
                    <h4>Detail Kontak Person</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('contacts.create') }}" class="btn btn-success btn-create-data btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Data
                    </a>
                    <a href="{{ route('contacts.edit',['category'=>$data->id]) }}"
                        class="btn btn-info btn-edit-data btn-sm">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('contacts.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">Nama</td>
                    <td width="50">:</td>
                    <td>{{ $data->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>{{ $data->email }}</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td>:</td>
                    <td>{{ $data->phone }}</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td>:</td>
                    <td>{{ $data->website }}</td>
                </tr>
                <tr>
                    <td>Kode Pos</td>
                    <td>:</td>
                    <td>{{ $data->postal_code }}</td>
                </tr>
                <tr>
                    <td>Alamat Lengkap</td>
                    <td>:</td>
                    <td>{{ $data->address }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection