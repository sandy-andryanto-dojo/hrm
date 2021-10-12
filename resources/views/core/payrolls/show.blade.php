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

{{ Form::open(['method' => 'POST','id'=>'form-approve', 'route' => 'payrolls.confirm']) }}
    <input type="hidden" name="employee_id" value="{{ $data->id }}"/>
    <input type="hidden" name="month" value="{{ $month }}"/>
    <input type="hidden" name="year" value="{{ $year }}"/>
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Penggajian</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="{{ route('payrolls.current',['month'=>$month, 'year'=>$year]) }}"> Penggajian</a>
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
    <div class="">
        @include('layouts.alert')
        <div class="card-box">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>Slip Gaji Karyawan Periode {{ $month_name }} {{ $year }}</h4>
                </div>
                <div class="pull-right">
                    <a href="javasript:vodi(0);" class="btn btn-sm btn-info" id="btn-filter-show">
                        <i class="fa fa-calendar"></i>&nbsp; Pilih Periode
                    </a>
                    @if(\Auth::User()->isAdmin())
                        <a href="{{ route('payrolls.current', ['month'=>$month, 'year'=>$year]) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                        </a>
                        <a target="_blank" href="{{ route('payrolls.print', ['month'=>$month, 'year'=>$year, 'id'=>$data->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-print"></i>&nbsp;Cetak Slip Gaji
                        </a>
                    @else
                        @if($status > 0)
                        <a target="_blank" href="{{ route('payrolls.print', ['month'=>$month, 'year'=>$year, 'id'=>$data->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-print"></i>&nbsp;Cetak Slip Gaji
                        </a>
                        @else
                        <a href="javascript:void(0);" class="btn btn-success btn-sm" id="btn-confirm">
                            <i class="fa fa-check"></i>&nbsp;Konfirmasi
                        </a>
                        @endif
                    @endif
                </div>
            </div>
            <hr>
            <div class="col-md-6">
                <table class="table table-striped table-colored table-info dt-responsive nowrap">
                    <tr class="">
                       <td colspan="3">
                           <strong># DETAIL PEGAWAI</strong>
                       </td>
                    </tr>
                    <tr>
                        <td width="200">NIK</td>
                        <td width="50">:</td>
                        <td>{{ $data->employee_number }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Gabung</td>
                        <td>:</td>
                        <td>{{ $data->join_date }}</td>
                    </tr>
                    <tr>
                        <td>Masa Kerja</td>
                        <td>:</td>
                        <td>
                            @php 
                                $date = \Carbon\Carbon::parse($data->created_at);
                                $now = \Carbon\Carbon::now();
                                $days = $date->diffInDays($now);
                                $months = $date->diffInMonths($now);
                                $years = $date->diffInYears($now);
                                if($days < 31){
                                    echo $days." Hari";
                                }else if($months < 12){
                                    echo $months." Bulan";
                                }else{
                                    echo $years." Tahun";
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Pegawai</td>
                        <td>:</td>
                        <td>{{ $data->User->UserProfile->first_name." ".$data->User->UserProfile->last_name }}</td>
                    </tr>
                    <tr>
                        <td>Status Nikah</td>
                        <td>:</td>
                        <td>{{ $data->User->UserProfile->Status ? $data->User->UserProfile->Status->name : "-" }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Anak</td>
                        <td>:</td>
                        <td>{{ (int) $data->User->UserProfile->total_child }}</td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td>:</td>
                        <td>{{ $data->Division ? $data->Division->name : "-" }}</td>
                    </tr>
                    <tr>
                        <td>Posisi</td>
                        <td>:</td>
                        <td>{{ $data->Position ? $data->Position->name : "-" }}</td>
                    </tr>
                    <tr>
                        <td>Tipe </td>
                        <td>:</td>
                        <td>{{ $data->EmployeeType ? $data->EmployeeType->name : "-" }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-striped table-colored table-info dt-responsive nowrap">
                    <tr class="">
                        <td colspan="3">
                            <strong># DETAIL ABSENSI</strong>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">Total Jam Kerja (Jam)</td>
                        <td width="50">:</td>
                        <td>{{ $totalAbsenceByHours }} / {{ $totalhours }}</td>
                    </tr>
                    <tr>
                        <td width="200">Total Kehadiran (Hari)</td>
                        <td width="50">:</td>
                        <td>{{ $totalAbsenceByDays }} / {{ $totalDays }}</td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="col-md-6">
                <table class="table table-striped table-colored table-info dt-responsive nowrap">
                    <tr class="">
                        <td colspan="3">
                            <strong># DETAIL PENDAPATAN</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td>:</td>
                        <td>{{ number_format($data->Position->month_salary ? $data->Position->month_salary : 0, 2, ',', '.') }}</td>
                    </tr>
                    @foreach($allowances as $a)
                    <tr>
                        <td>{{ $a["name"] }}</td>
                        <td>:</td>
                        <td>{{ number_format($a["cost"], 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="success">
                        <td>
                            <strong>TOTAL</strong>
                        </td>
                        <td>:</td>
                        <td><strong>{{ number_format($totalAllowances + $data->Position->month_salary, 2, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-striped table-colored table-info dt-responsive nowrap">
                    <tr class="">
                        <td colspan="3">
                            <strong># DETAIL POTONGAN</strong>
                        </td>
                    </tr>
                    @foreach($cuts as $c)
                    <tr>
                        <td>{{ $c["name"] }}</td>
                        <td>:</td>
                        <td>{{ number_format($c["cost"], 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="success">
                        <td>
                            <strong>TOTAL</strong>
                        </td>
                        <td>:</td>
                        <td><strong>{{ number_format($totalCuts, 2, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
            <hr>
            <div class="col-md-12">
                <table class="table table-striped table-colored table-info dt-responsive nowrap text-center">
                    <tr class="">
                        <td colspan="3">
                            <strong># GAJI BERSIH = (PENDAPATAN - POTONGAN)</strong>
                        </td>
                    </tr>
                    <tr class="">
                        <td colspan="3"><strong>IDR {{ number_format($takeHome, 2, ',', '.') }}</strong></td>
                    </tr>
                    <tr class="">
                        <td colspan="3"><strong>Status</strong> : {!! \App\Helpers\AppHelper::getAnnualStatus($status) !!}</td>
                    </tr>
                    <tr class="">
                        <td colspan="3"><strong><i>TERBILANG : {{ strtoupper(\App\Helpers\AppHelper::terbilang($takeHome)) }} RUPIAH</i></strong></td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form class="form" id="form-filter-show">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Form Pencarian</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid" value="{{ $data->id }}" />
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