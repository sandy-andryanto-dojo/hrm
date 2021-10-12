@extends('layouts.core')
@section('title') Penggajian @endsection

@section('script')
    <script src="{{ asset('assets/app/js/payrolls.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div id="variables" class="hidden">
    <div class="month">{{ $month }}</div>
    <div class="year">{{ $year }}</div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Penggajian</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Master Data</a>
                </li>
                <li class="active">
                     Penggajian
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
                    <h4>Daftar Penggajian Pegawai Periode {{ $month_name }} {{ $year }}</h4>
                </div>
                <div class="pull-right">
                    <a href="javasript:vodi(0);" class="btn btn-sm btn-primary" id="btn-filter">
                        <i class="fa fa-calendar"></i>&nbsp; Pilih Periode
                    </a>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Divisi</th>
                            <th>Posisi</th>
                            <th>Tipe</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Potongan</th>
                            <th>Gaji Bersih</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form class="form" id="form-filter">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Form Pencarian</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="month">Pilih Bulan</label>
                        <select class="form-control select2" id="month" name="month">
                            @php $months = \App\Helpers\AppHelper::Months();  @endphp
                            @for($i = 1; $i <= 12; $i++)
                                @php $selected = $month == $i ? "selected" : ""; @endphp
                                <option value="{{ $i }}" {{ $selected }}>{{ $months[$i] }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">Pilih Tahun</label>
                        <input type="number" class="form-control" name="year" id="year" min="1900" max="{{ date('Y') }}" value="{{ $year }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm waves-effect waves-light btn-block">
                        <i class="fa fa-search"></i>&nbsp; Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection