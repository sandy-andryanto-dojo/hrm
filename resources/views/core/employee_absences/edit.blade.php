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
                    Edit Data
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
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
    <form class="form" id="form-submit" method="POST" action="{{ route('employee_absences.store') }}">
        {{ csrf_field() }}
        <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee_id }}" />
        <input type="hidden" id="month" name="month" value="{{ $month }}" />
        <input type="hidden" id="year" name="year" value="{{ $year }}" />
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
                        <a href="{{ route('employee_absences.current', ['month'=>$month, 'year'=>$year] ) }}" class="btn btn-sm btn-warning btn-edit-data">
                            <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                        </a>
                    </div>
                </div>
                <h1></h1>
                <table class="table table-colored table-info dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th width="150">Tanggal</th>
                            <th width="150">Hari</th>
                            <th width="150">Jam Masuk</th>
                            <th width="150">Jam Keluar</th>
                            <th width="150">Total Jam Kerja</th>
                            <th width="150">Status</th>
                            <th>Keterangan / Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rowId = 1; $total = 0; @endphp
                        @foreach($dates as $d)
                        @php $holiday = $d["day_name"] == "sunday" || $d["day_name"] == "saturday" || !is_null($d['date_holiday'])  ? "danger" : ""; @endphp
                        <tr class="{{ $holiday ? 'danger' : '' }}" data-id="{{ $rowId }}">
                            <td data-id="{{ $rowId }}" class="date_index">{{ $rowId > 9 ? $rowId : '0'.$rowId }}</td>
                            <td data-id="{{ $rowId }}" class="day_name">{{ \App\Helpers\AppHelper::indonesiaDays($d["day_name"]) }}</td>
                            @if($holiday || !is_null($d['date_holiday']))
                                <td colspan="5">
                                    <input type="hidden" name="absence_date[]" value="{{ $d['date'] }}" />
                                    <input type="hidden" name="start_hour[]" value="{{ isset($d['absence']) && $d['absence']->start_hour ? $d['absence']->start_hour : '09:00' }}" />
                                    <input type="hidden" name="end_hour[]" value="{{ isset($d['absence']) && $d['absence']->end_hour ? $d['absence']->end_hour : '17:00' }}" />
                                    <input type="hidden" name="is_holiday[]" value="1" />
                                    <input type="hidden" name="status[]" value="0" />
                                    <input type="hidden" name="total[]" value="0" />
                                </td>
                            @else
                                <td><input type="text" data-id="{{ $rowId }}" class="form-control input-sm input-hour start_hour calc" name="start_hour[]" value="{{ isset($d['absence']) && $d['absence']->start_hour ? $d['absence']->start_hour : '09:00' }}" /></td>
                                <td><input type="text" data-id="{{ $rowId }}" class="form-control input-sm input-hour end_hour calc" name="end_hour[]" value="{{ isset($d['absence']) && $d['absence']->end_hour ? $d['absence']->end_hour : '17:00' }}" /></td>
                                <td><input type="text" data-id="{{ $rowId }}" class="form-control input-sm total" name="total[]" readonly="readonly" value="{{ isset($d['absence']) && $d['absence']->total ? $d['absence']->total : '8' }}" /></td>
                                <td>
                                    <select class="form-control input-sm status" name="status[]" data-id="{{ $rowId }}" >
                                        <option disabled="disabled" selected="selected">-- Pilih Status --</option>
                                        <option value="1" {{ isset($d['absence']) && $d['absence']->status == "1" ? "selected" : "" }}>Hadir</option>
                                        <option value="0" {{ isset($d['absence']) && $d['absence']->status == "2" ? "selected" : "" }}>Tidak Hadir</option>
                                    </select>
                                    <input type="hidden" name="is_holiday[]" value="{{ isset($d['absence']->is_holiday) ? $d['absence']->is_holiday : 0 }}" />
                                    <input type="hidden" name="absence_date[]" value="{{ $d["date"] }}" />
                                </td>    
                                <td><input type="text" class="form-control input-sm" name="notes[]" data-id="{{ $rowId }}" value="{{ isset($d['absence']->notes) ? $d['absence']->notes : "" }}" /></td>    
                            @endif
                        </tr>
                        @php $rowId++; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="active">
                            <td colspan="4">
                                <strong>TOTAL</strong>
                            </td>
                            <td class="text-left">
                                <strong id="total_hadir">0</strong>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="clearfix">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="fa fa-save"></i>&nbsp; Simpan
                        </button>
                        <button type="reset" class="btn btn-warning waves-effect waves-light">
                            <i class="fa fa-refresh"></i>&nbsp; Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form class="form" id="form-filter-edit">
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