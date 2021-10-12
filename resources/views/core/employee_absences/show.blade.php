@extends('layouts.core')
@section('title') Absensi @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_absences.js') }}"></script>   
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
            <h4 class="page-title"> Absensi</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li>
                    <a href="{{ route('employee_absences.current', ['month'=>$month, 'year'=>$year]) }}"> Absensi</a>
                </li>
                <li class="active">
                    Detail Data
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

{!! Form::model(null, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'form-approve','route' => ['employee_absences.update', 0] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="employee_id" value="{{ $employee->id }}" />
    <input type="hidden" name="month" value="{{ $month }}" />
    <input type="hidden" name="year" value="{{ $year }}" />
{!! Form::close() !!}


<div class="row">
    <div class="col-md-12">
        @include('layouts.alert')
        <div class="card-box">
            <strong>INFORMASI PEGAWAI</strong>
            <h1></h1>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">NIK</td>
                    <td width="50">:</td>
                    <td>{{ $employee->employee_number }}</td>
                </tr>
                <tr>
                    <td>Nama Pegawai</td>
                    <td>:</td>
                    <td>{{ $employee->User ? $employee->User->UserProfile->first_name." ".$employee->User->UserProfile->last_name : "-" }}</td>
                </tr>
                <tr>
                    <td>Posisi</td>
                    <td>:</td>
                    <td>{{ $employee->Position ? $employee->Position->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td>:</td>
                    <td>{{ $employee->Division ? $employee->Division->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Nama Atasan</td>
                    <td>:</td>
                    <td>{{ $employee->Division && $employee->Division->Superior ? $employee->Division->Superior->first_name."  ".$employee->Division->Superior->last_name : "-" }}</td>
                </tr>
                <tr>
                    <td>Tipe Pegawai</td>
                    <td>:</td>
                    <td>{{ $employee->EmployeeType ? $employee->EmployeeType->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Tanggal Gabung</td>
                    <td>:</td>
                    <td>{{ $employee->join_date }}</td>
                </tr>
                <tr>
                    <td>Tanggal Awal Kontrak</td>
                    <td>:</td>
                    <td>{{ $employee->start_contract_date ? $employee->start_contract_date : "-" }}</td>
                </tr>
                <tr>
                    <td>Tanggal Akhir Kontrak</td>
                    <td>:</td>
                    <td>{{ $employee->end_contract_date ? $employee->end_contract_date : "-" }}</td>
                </tr>
                <tr>
                    <td>Profesi</td>
                    <td>:</td>
                    <td>{{ $employee->Job ? $employee->Job->name : "-" }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card-box">
            <div class="clearfix">
                <div class="pull-left">
                    <strong>INFORMASI ABSENSI PERIODE {{ strtoupper($month_name) }} {{ $year }}</strong>
                </div>
                <div class="pull-right">
                    <a href="javasript:vodi(0);" class="btn btn-sm btn-primary" id="btn-filter-show">
                        <i class="fa fa-calendar"></i>&nbsp; Pilih Periode
                    </a>
                    @if(\Auth::User()->getEmployeeId() == $employee->id && $is_approved == false)
                    <a href="{{ route('employee_absences.modify', ['month'=>$month, 'year'=>$year, 'id'=>$employee_id] ) }}" class="btn btn-sm btn-info">
                        <i class="fa fa-edit"></i>&nbsp; Edit Data
                    </a>
                    @endif
                    @if(\Auth::User()->id == $employee->Division->Superior->user_id && $is_approved == false)
                    <a href="javascript:void(0);" class="btn btn-sm btn-success" id="btn-approve">
                         <i class="fa fa-check"></i>&nbsp; Konfirmasi Absensi
                    </a>
                    @endif
                    <a href="{{ route('employee_absences.current', ['month'=>$month, 'year'=>$year] ) }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <h1></h1>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Total Jam Kerja</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0;  @endphp
                    @foreach($dates as $d)
                    @php $holiday = $d["day_name"] == "sunday" || $d["day_name"] == "saturday" || !is_null($d['date_holiday'])  ? "danger" : ""; @endphp
                    <tr class="{{ $holiday }}">
                        <td>{{ $d["date"] }}</td>
                        <td>{{ \App\Helpers\AppHelper::indonesiaDays($d["day_name"]) }}</td>
                        @if($holiday == "danger" || !is_null($d['date_holiday']))
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>{{ !is_null($d['date_holiday']) ? $d['date_holiday']->name : "-" }}</strong></td>
                        @else
                            <td>{{ $d["absence"] ? $d["absence"]->start_hour : "-" }}</td>
                            <td>{{ $d["absence"] ? $d["absence"]->end_hour : "-" }}</td>
                            <td>{{ $d["absence"] && isset($d["absence"]->start_hour) && isset($d["absence"]->end_hour) ? $d["absence"]->total : "0" }}</td>
                            <td>{{ $d["absence"] ? $d["absence"]->notes : "-" }}</td>
                            @if(!is_null($d["absence"]) && isset($d["absence"]->status))
                                @if($d["absence"]->status == "1")
                                    <td>
                                        <span class="label label-success">Hadir</span>
                                    </td>
                                @else 
                                    <td>
                                        <span class="label label-warning">Tidak Hadir</span>
                                    </td>
                                @endif
                            @else 
                                <td>
                                    <span class="label label-danger">Belum Absen</span>
                                </td>
                            @endif
                        @endif
                    </tr>
                    @php $total += (isset($d["absence"]->total) ? $d["absence"]->total : 0); @endphp 
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="active">
                        <td colspan="4">
                            <strong>TOTAL</strong>
                        </td>
                        <td>
                            <strong>{{ $total }}</strong>
                        </td>
                        <td>
                            <strong>STATUS KONFIRMASI</strong>
                        </td>
                        <td>
                            <strong>{!! $is_approved == true ? "<span class='label label-success'><i class='fa fa-check'></i>&nbsp;SUDAH DIKONFIRMASI</span>" : "<span class='label label-warning'><i class='fa fa-warning'></i>&nbsp;BELUM DIKONFIRMASI</span>" !!}</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form class="form" id="form-filter-show">
                <input type="hidden" name="employee_id" id="employee_id" value="{{ $employee_id }}" />
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