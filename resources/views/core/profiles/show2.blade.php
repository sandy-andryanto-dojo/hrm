@extends('layouts.core')
@section('title')  Pengalaman Bekerja @endsection

@section('script')
    <script src="{{ asset('assets/app/js/profiles-experiences.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

{!! Form::model(null, ['method' => 'PATCH','class'=>'','id'=>'form-delete','route' => ['profiles.update', 2] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="eid" id="eid" />
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Pengalaman Bekerja</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Pengaturan</a>
                </li>
                <li>
                    <a href="{{ route('profiles.index') }}"> Profil Pengguna</a>
                </li>
                <li class="active">
                    Pengalaman Bekerja
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
         @include('layouts.alert')
    </div>
    <div class="clearfix"></div>
    <div class="col-md-2">
        <div class="card-box">
            @include('core.profiles.image')
        </div>
    </div>
    <div class="col-md-10 profiles">
        <div class="card-box">
            <ul class="nav nav-tabs tabs-bordered nav-justified">
                <li class="">
                    <a href="{{ route('profiles.index') }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Detail Pegawai</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>1]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Biodata</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('profiles.show',['id'=>2]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Pengalaman</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>3]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Riwayat Pendidikan</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>4]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Keahlian</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>5]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Kemampuan Bahasa</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>6]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Lampiran</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <div class="text-right">
                        <a href="javascript:void(0);" class="btn btn-success btn-sm btn-create-data">
                            <i class="fa fa-plus"></i>&nbsp;Tambah Baru
                        </a>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped dt-responsive nowrap" id="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Posisi</th>
                                    <th>Divisi</th>
                                    <th>Gaji</th>
                                    <th>Periode</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>       
                            <tbody>
                                @php $num = 1; @endphp
                                @if(count($data) == 0)
                                    <tr>
                                        <td class="text-center" colspan="7"> -- Tidak ada Data --</td>
                                    </tr>
                                @endif
                                @foreach($data as $row)
                                    @php 
                                        $currency = $row->Currency ? $row->Currency->name : ""; 
                                        $startPeriod = "-";
                                        $endPeriod = "-";
                                        if(!is_null($row->month_start) && !is_null($row->year_start)) $startPeriod = \App\Helpers\AppHelper::getMonth($row->month_start)." ".$row->year_start;
                                        if(!is_null($row->month_end) && !is_null($row->year_end)) $endPeriod = \App\Helpers\AppHelper::getMonth($row->month_end)." ".$row->year_end;
                                        $workPeriod = $startPeriod." s/d ".$endPeriod;
                                    @endphp
                                    <tr id="{{ $num }}">
                                        <textarea class="item hidden" id="item{{ $num }}">{{ json_encode($row) }}</textarea>
                                        <td>{{ $num }}</td>
                                        <td>{{ $row->company_name }}</td>
                                        <td>{{ $row->Position ? $row->Position->name : "-" }}</td>
                                        <td>{{ $row->Division ? $row->Division->name : "-" }}</td>
                                        <td>{{ number_format($row->sallary, 2, ',', '.')." (".$currency.")" }}</td>
                                        <td>{{ $workPeriod }}</td>
                                        <td>
                                            <a href='javascript:void(0);' data-id="{{ $num }}" class='btn btn-primary btn-sm waves-effect waves-light btn-ubah'><i class='fa fa-edit'></i></a>
                                            <a href='javascript:void(0);' data-id="{{ $num }}" class='btn btn-danger btn-sm waves-effect waves-light btn-hapus'><i class='fa fa-trash'></i></a>
                                        </td>
                                    </tr>
                                @php $num++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(array('route' => 'profiles.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
            <input type="hidden" name="redirect" value="{{ $redirect }}" />
            <input type="hidden" name="id" id="id" />
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Form Pengalaman Kerja</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">Nama Perusahaan </label>
                    <div class="col-md-10">
                        <input type="text" id="company_name" name="company_name" class="form-control" required="required" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Posisi </label>
                    <div class="col-md-10">
                        {!! Form::select('position_id', $positions->pluck('name','id'), null, ['id'=>'position_id','class'=>'select2', 'placeholder'=>'-- Pilih Posisi --']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Divisi </label>
                    <div class="col-md-10">
                        {!! Form::select('division_id', $divisions->pluck('name','id'), null, ['id'=>'division_id','class'=>'select2', 'placeholder'=>'-- Pilih Divisi --']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Spesialisasi </label>
                    <div class="col-md-10">
                        {!! Form::select('specliationation_id', $specializations->pluck('name','id'), null, ['id'=>'specliationation_id','class'=>'select2', 'placeholder'=>'-- Pilih Spesialisasi --']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Industri </label>
                    <div class="col-md-10">
                        {!! Form::select('industry_id', $industries->pluck('name','id'), null, ['id'=>'industry_id','class'=>'select2', 'placeholder'=>'-- Pilih Industri --']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Negara </label>
                    <div class="col-md-10">
                        {!! Form::select('country_id', $countries->pluck('name','id'), null, ['id'=>'country_id','class'=>'select2', 'placeholder'=>'-- Pilih Negara --']) !!}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">Gaji</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="sallary" id="sallary" value="0" />
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">Mata Uang</label>
                    <div class="col-md-8">
                        {!! Form::select('currency_id', $currencies->pluck('code1','id'), null, ['id'=>'currency_id','class'=>'select2', 'placeholder'=>'-- Pilih Mata Uang --']) !!}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">Bulan Awal </label>
                    <div class="col-md-8">
                        {!! Form::select('month_start', $months, null, ['id'=>'month_start','class'=>'select2', 'placeholder'=>'-- Pilih Bulan Awal --']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6 ">
                    <label class="col-md-4 control-label">Tahun Awal </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" name="year_start" id="year_start" value="{{ date('Y') }}" max="{{ date('Y') }}" min="1800" />
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">Bulan Akhir </label>
                    <div class="col-md-8">
                        {!! Form::select('month_end', $months, null, ['id'=>'month_end','class'=>'select2', 'placeholder'=>'-- Pilih Bulan Akhir --']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6 ">
                    <label class="col-md-4 control-label">Tahun Akhir </label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" name="year_end" id="year_end" value="{{ date('Y') }}" max="{{ date('Y') }}" min="1800" />
                    </div>
                </div>
                <div class="clearfix"></div>
                <h1></h1>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light">
                    <i class="fa fa-save"></i>&nbsp; Simpan
                </button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection