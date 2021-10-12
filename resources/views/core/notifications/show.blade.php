@extends('layouts.core')
@section('title') Pemberitahuan @endsection

@section('script')
    <script src="{{ asset('assets/app/js/notifications.js') }}"></script>
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
            <h4 class="page-title"> Pemberitahuan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li>
                    <a href="{{ route('notifications.index') }}"> Pemberitahuan</a>
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
                    <h4>Detail Pemberitahuan</h4>
                </div>
                <div class="pull-right">
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('notifications.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">Tanggal Terkirim</td>
                    <td width="50">:</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
                <tr>
                    <td>Pengirim</td>
                    <td>:</td>
                    <td>{{ $data->Sender->UserProfile->first_name." ".$data->Sender->UserProfile->last_name }}</td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>:</td>
                    <td>{{ $data->subject }}</td>
                </tr>
                <tr>
                    <td>Isi Pesan</td>
                    <td>:</td>
                    <td>{!! $data->content  !!}</td>
                </tr>
                @if(!is_null($data->link))
                <tr>
                    <td>Link</td>
                    <td>:</td>
                    <td><a href="{{ $data->link }}">{{ $data->link }}</a></td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection