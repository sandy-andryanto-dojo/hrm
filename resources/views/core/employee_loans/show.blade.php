@extends('layouts.core')
@section('title') Permohonan Pinjaman @endsection

@section('script')
    <script src="{{ asset('assets/app/js/employee_loans.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div class="hidden">
    <div id="employee_id">{{ $employee_id }}</div>
</div>

{{ Form::open(['method' => $form['method'],'id'=>'form-delete', 'route' =>  $form['route']]) }}
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title"> Permohonan Pinjaman</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Permohonan</a>
                </li>
                <li>
                    <a href="{{ route('employee_loans.index') }}"> Permohonan Pinjaman</a>
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
                    <h4>Detail Permohonan Pinjaman</h4>
                </div>
                <div class="pull-right">
                    @if($employee_id != $data->manager_id)
                        <a href="{{ route('employee_loans.create') }}" class="btn btn-success btn-create-data btn-sm">
                            <i class="fa fa-plus"></i>&nbsp;Tambah Data
                        </a>
                        @if((int) $data->is_approved == 0)
                        <a href="{{ route('employee_loans.edit',['category'=>$data->id]) }}"
                            class="btn btn-info btn-edit-data btn-sm">
                            <i class="fa fa-edit"></i>&nbsp;Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                            <i class="fa fa-trash"></i>&nbsp;Hapus
                        </a>
                        @endif
                    @else 
                        @if((int) $data->is_approved == 0)
                            @php 
                                $item = array(
                                    "employee_number"=>$data->Employee ? $data->Employee->employee_number : "-",
                                    "employee_name"=>$data->Employee ? $data->Employee->User->UserProfile->first_name." ".$data->Employee->User->UserProfile->last_name : "-",
                                    "division_name"=>$data->Employee ? $data->Employee->Division->name : "-",
                                    "position_name"=>$data->Employee ? $data->Employee->Position->name : "-",
                                    "cost"=>$data->cost,
                                    "reason"=>$data->reason ? $data->reason : "-",
                                );
                            @endphp
                            <textarea class="hidden item" data-id="{{ $data->id }}">{!! json_encode($item) !!}</textarea>
                            <a href="javascript:void(0);" class="btn btn-info btn-sm btn-approve" data-id="{{ $data->id }}">
                                <i class="fa fa-gavel"></i>&nbsp;Setujui atau Tolak Permohonan
                            </a>
                        @endif
                    @endif
                    <a href="{{ route('employee_loans.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">No Pegawai</td>
                    <td width="50">:</td>
                    <td>{{ $data->Employee ? $data->Employee->employee_number : "-" }}</td>
                </tr>
                <tr>
                    <td>Nama Pegawai</td>
                    <td>:</td>
                    <td>{{ $data->Employee ? $data->Employee->User->UserProfile->first_name." ".$data->Employee->User->UserProfile->last_name : "-" }}</td>
                </tr>
                <tr>
                    <td>Divisi</td>
                    <td>:</td>
                    <td>{{ $data->Employee ? $data->Employee->Division->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Posisi</td>
                    <td>:</td>
                    <td>{{ $data->Employee ? $data->Employee->Position->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Nama Atasan</td>
                    <td>:</td>
                    <td>{{ $data->Manager ? $data->Manager->User->UserProfile->first_name." ".$data->Manager->User->UserProfile->last_name : "-" }}</td>
                </tr>
                <tr>
                    <td>Total Pinjaman</td>
                    <td>:</td>
                    <td>{{ number_format($data->cost, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Alasan Pinjaman</td>
                    <td>:</td>
                    <td>{{ $data->reason ? $data->reason : "-" }}</td>
                </tr>
                <tr>
                    <td>Status Permohonan</td>
                    <td>:</td>
                    <td>{!! \App\Helpers\AppHelper::getAnnualStatus($data->is_approved) !!}</td>
                </tr>
                <tr>
                    <td>Catatan Manager</td>
                    <td>:</td>
                    <td>{{ $data->manager_notes ? $data->manager_notes : "-" }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@include('core.employee_loans.approval')

@endsection