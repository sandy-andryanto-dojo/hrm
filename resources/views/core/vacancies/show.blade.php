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

{{ Form::open(['method' => $form['method'],'id'=>'form-delete', 'route' =>  $form['route']]) }}
{{ Form::close() }}

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
                    <h4>Detail Lowongan</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('vacancies.create') }}" class="btn btn-success btn-create-data btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Data
                    </a>
                    <a href="{{ route('vacancies.edit',['category'=>$data->id]) }}"
                        class="btn btn-info btn-edit-data btn-sm">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('vacancies.index') }}" class="btn btn-primary btn-sm">
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
                    <td>Tipe Pegawai</td>
                    <td>:</td>
                    <td>{{ $data->Type ? $data->Type->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>{{ $data->Job ? $data->Job->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Posisi</td>
                    <td>:</td>
                    <td>{{ $data->Position ? $data->Position->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td>:</td>
                    <td>{{ $data->Division ? $data->Division->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Tanggal Mulai</td>
                    <td>:</td>
                    <td>{{ $data->start_date ? $data->start_date : "-" }}</td>
                </tr>
                <tr>
                    <td>Tanggal Akhir</td>
                    <td>:</td>
                    <td>{{ $data->end_date ? $data->end_date : "-" }}</td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>:</td>
                    <td>{{ $data->location ? $data->location : "-" }}</td>
                </tr>
                <tr>
                    <td>Gaji Minimal</td>
                    <td>:</td>
                    <td>{{ number_format($data->min_salary, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Gaji Maksimal</td>
                    <td>:</td>
                    <td>{{ number_format($data->max_salary, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>:</td>
                    <td>{!! $data->description  !!}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    @if((int)$data->is_closed == 0)
                        <td>{!! \App\Helpers\AppHelper::statusText("success", "Aktif") !!}</td>
                    @else
                        <td>{!! \App\Helpers\AppHelper::statusText("warning", "Tidak Aktif") !!}</td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection