@extends('layouts.core')
@section('title') Penerimaan @endsection

@section('script')
    <script src="{{ asset('assets/app/js/acceptances.js') }}"></script>
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
            <h4 class="page-title"> Penerimaan</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Perekrutan</a>
                </li>
                <li>
                    <a href="{{ route('acceptances.index') }}"> Penerimaan</a>
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
            <h4>Detail Penerimaan</h4>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">Nama Lowongan</td>
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
                    <td>Manager</td>
                    <td>:</td>
                    <td>{{ $data->Division->Superior ? $data->Division->Superior->first_name." ".$data->Division->Superior->last_name : "-" }}</td>
                </tr>
                <tr>
                    <td>Status Lowongan</td>
                    <td>:</td>
                    @if((int)$data->is_closed == 0)
                        <td>{!! \App\Helpers\AppHelper::statusText("success", "Aktif") !!}</td>
                    @else
                        <td>{!! \App\Helpers\AppHelper::statusText("warning", "Tidak Aktif") !!}</td>
                    @endif
                </tr>
            </table>
        </div>
        <div class="card-box">
            <h4>Daftar Kandidat</h4>
            <table class="table table-striped  table-colored table-info dt-responsive nowrap" id="table-candidate">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($candidates->count() == 0)
                    <tr colspan="8">
                        <td>-- Tidak ada data --</td>
                    </tr>
                    @else 
                        @php $i = 1; @endphp
                        @foreach($candidates as $row)
                        @php $data = $row->Candidate; @endphp
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->first_name." ".$data->last_name }}</td>
                            <td>{{ $data->Gender ? $data->Gender->name : "-" }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->phone }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="true"> 
                                        <i class="fa fa-download"></i>&nbsp;
                                        <span class="caret"></span> 
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach($attachments as $attachment)
                                        @php $file = \App\Helpers\AppHelper::getFileByGroup("App\Models\Recruitment\Candidate", $data->id,  $attachment->id);  @endphp
                                            @if(!is_null($file))
                                                <li><a target="_blank" href="{{ url($file->path) }}">{{ $attachment->name }}</a></li>	
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                            @if((int) $row->manager_approved == 0)
                                <td>{!! \App\Helpers\AppHelper::statusText("warning", "Proses") !!}</td>
                                <td>
                                    <a href="javascript:void(0);" data-id="{{ $row->id }}" data-status="1" data-text="menerima" class="btn btn-success btn-sm btn-approve"><i class="fa fa-check"></i></a>
                                    <a href="javascript:void(0);" data-id="{{ $row->id }}" data-status="-1" data-text="menolak" class="btn btn-danger btn-sm btn-approve"><i class="fa fa-close"></i></a>
                                </td>
                            @elseif((int) $row->manager_approved == 1)
                                <td>{!! \App\Helpers\AppHelper::statusText("success", "Di Terima") !!}</td>
                                <td><a href="javascript:void(0);" class="btn btn-success btn-sm disabled"><i class="fa fa-check"></i></a></td>
                            @else
                                <td>{!! \App\Helpers\AppHelper::statusText("danger", "Di Tolak") !!}</td>
                                <td><a href="javascript:void(0);" class="btn btn-danger btn-sm disabled"><i class="fa fa-close"></i></a></td>
                            @endif
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{!! Form::model(null, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'form-approve','route' => ['acceptances.update', 0] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="eid" id="eid" />
    <input type="hidden" name="status" id="estatus" />
{!! Form::close() !!}

@endsection