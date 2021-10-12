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

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Pemberitahuan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li class="active">
                    Pemberitahuan
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
                    <h4>Pemberitahuan</h4>
                </div>
                <div class="pull-right"></div>
            </div>
            <hr>
            <ul class="nav nav-tabs tabs-bordered nav-justified">
                <li class="active">
                    <a href="#tab1" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Sudah dibaca (<small class="text-read">0</small>)</span>
                    </a>
                </li>
                <li class="">
                    <a href="#tab2" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Belum dibaca (<small class="text-unread">0</small>)</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h1></h1>
                    <div class="table-responsive">
                        <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Terkirim</th>
                                    <th>Subjek</th>
                                    <th>Nama Pengirim</th>
                                    <th>Isi Pesan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                     <h1></h1>
                     <div class="table-responsive">
                        <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Terkirim</th>
                                    <th>Subjek</th>
                                    <th>Nama Pengirim</th>
                                    <th>Isi Pesan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection