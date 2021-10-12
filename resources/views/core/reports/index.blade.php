@extends('layouts.core')
@section('title') Laporan @endsection

@section('script')
    <script src="{{ asset('assets/app/js/reports.js') }}"></script>
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
            <h4 class="page-title">Provinsi</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Laporan</a>
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
            <h4>Daftar Laporan Kepegawaian</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table">
                    @for($i = 0; $i < count($reports); $i++)
                    <tr>
                        <td><strong>{{ strtoupper($reports[$i]["name"]) }}</strong></td>
                        <td>
                            @php 
                                $route = !is_null($reports[$i]["route"]) ? $reports[$i]["route"] : "javascript:void(0);";
                                $cls =  !is_null($reports[$i]["route"]) ? "" : "btn-print";
                            @endphp
                            <a href="{{ $route }}" target="_blank" data-code="{{ ($i+1) }}" class="btn btn-sm btn-success {{ $cls }} type{{ $reports[$i]["type"] }}">
                                <i class="fa fa-print"></i>&nbsp;
                            </a>
                        </td>
                    </tr>
                    @endfor
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form class="form" id="form-submit" method="POST" action="{{ route('reports.store') }}" target="_blank">
                {{ csrf_field() }}
                <input type="hidden" name="code" id="code" />
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