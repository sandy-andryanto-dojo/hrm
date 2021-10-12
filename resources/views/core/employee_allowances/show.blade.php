@extends('layouts.core')
@section('title') Tunjangan @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_allowances.js') }}"></script>
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
            <h4 class="page-title"> Tunjangan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li>
                    <a href="{{ route('employee_allowances.index') }}"> Data Tunjangan</a>
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
                    <h4>Detail Pegawai</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('employee_allowances.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
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
                <tr>
                    <td>Profesi </td>
                    <td>:</td>
                    <td>{{ $data->Job ? $data->Job->name : "-"}}</td>
                </tr>
                <tr>
                    <td>Gaji Per Jam</td>
                    <td>:</td>
                    <td>{{ number_format($data->Position->hour_salary ? $data->Position->hour_salary : 0, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Gaji Bulanan</td>
                    <td>:</td>
                    <td>{{ number_format($data->Position->month_salary ? $data->Position->month_salary : 0, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-box">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>Detail Tunjangan</h4>
                </div>
                <div class="pull-right">
                    @if(count($allowances_employee) > 0)
                        <a href="{{ route('employee_allowances.edit', ['id'=>$data->id]) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-edit"></i>&nbsp;Edit
                        </a>
                    @else
                        <a href="{{ route('employee_allowances.edit', ['id'=>$data->id]) }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i>&nbsp;Tambah
                        </a>
                    @endif
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                @if(count($allowances_employee) > 0)
                    @foreach($allowances_employee as $row)
                        <tr>
                            <td width="200">{{ $row->Type->name }}</td>
                            <td width="50">:</td>
                            <td>{{ number_format($row->cost, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">
                            -- Tidak Ada Data --
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection