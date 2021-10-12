@extends('layouts.core')
@section('title') Data Pegawai @endsection

@section('script')
    <script src="{{ asset('assets/app/js/workers.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

{{ Form::open(['method' => $form['method'],'id'=>'form-delete', 'route' =>  $form['route']]) }}
{{ Form::close() }}

{!! Form::model(null, ['method' => 'PATCH','class'=>'','id'=>'form-delete-attachment','route' => ['workers.update', 0] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="eid" id="eid" />
    <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}" />
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title"> Data Pegawai </h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Kepegawaian</a>
                </li>
                <li>
                    <a href="{{ route('workers.index') }}"> Data Pegawai</a>
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
                    <h4>Detail Data Pegawai</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('workers.create') }}" class="btn btn-success btn-create-data btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Data
                    </a>
                    <a href="{{ route('workers.edit',['category'=>$data->id]) }}"
                        class="btn btn-info btn-edit-data btn-sm">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('workers.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <legend>1. Informasi Umum</legend>
                    <table class="table table-striped  dt-responsive nowrap">
                        <tr>
                            <td width="200">NIK</td>
                            <td width="50">:</td>
                            <td>{{ $data->employee_number }}</td>
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
                    </table>
                </div>
                <div class="col-md-6">
                    <legend>2. Akun Sistem dan Akses</legend>
                    <table class="table table-striped  dt-responsive nowrap">
                        <tr>
                            <td width="200">Username</td>
                            <td width="50">:</td>
                            <td>{{ $data->username }}</td>
                        </tr>
                        <tr>
                            <td>Email Aktif</td>
                            <td>:</td>
                            <td>{{ $data->email }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Telepon Aktif</td>
                            <td>:</td>
                            <td>{{ $data->phone }}</td>
                        </tr>
                        <tr>
                            <td>Kata Sandi</td>
                            <td>:</td>
                            <td>******</td>
                        </tr>
                        <tr>
                            <td>Akses Pengguna</td>
                            <td>:</td>
                            <td>{{ implode(", ", $data->roles->pluck("name")->toArray()) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <legend>3. Biodata</legend>
                    <table class="table table-striped  dt-responsive nowrap">
                        <tr>
                            <td width="200">Nama Depan</td>
                            <td width="50">:</td>
                            <td>{{ $data->first_name }}</td>
                        </tr>
                        <tr>
                            <td>Nama Belakang</td>
                            <td>:</td>
                            <td>{{ $data->last_name ? $data->last_name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Nama Panggilan</td>
                            <td>:</td>
                            <td>{{ $data->nick_name }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>{{ $gender ? $gender->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td>{{ $data->birth_date }}</td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir</td>
                            <td>:</td>
                            <td>{{ $data->birth_place }}</td>
                        </tr>
                        <tr>
                            <td>Status Nikah</td>
                            <td>:</td>
                            <td>{{ $marital ? $marital->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Anak</td>
                            <td>:</td>
                            <td>{{ (int) $data->total_child }}</td>
                        </tr>
                        <tr>
                            <td>Golongan Darah</td>
                            <td>:</td>
                            <td>{{ $blood ? $blood->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Menggunakan Lensa</td>
                            <td>:</td>
                            <td>{{ $data->has_lens == "1" ? "Ya" : "Tidak" }}</td>
                        </tr>
                        <tr>
                            <td>Berat (Kg)</td>
                            <td>:</td>
                            <td>{{ $data->weight }}</td>
                        </tr>
                        <tr>
                            <td>Tinggi (Cm)</td>
                            <td>:</td>
                            <td>{{ $data->height }}</td>
                        </tr>
                        <tr>
                            <td>Kode Pos</td>
                            <td>:</td>
                            <td>{{ $data->postal_code }}</td>
                        </tr>
                        <tr>
                            <td>Kewarganegaraan</td>
                            <td>:</td>
                            <td>{{ $country ? $country->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Identitas</td>
                            <td>:</td>
                            <td>{{ $identity ? $identity->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Identitas</td>
                            <td>:</td>
                            <td>{{ $data->identity_number ?  $data->identity_number : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Kartu Keluarga</td>
                            <td>:</td>
                            <td>{{ $data->family_number ? $data->family_number : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Bank</td>
                            <td>:</td>
                            <td>{{ $bank ? $bank->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>No Rekening</td>
                            <td>:</td>
                            <td>{{ $data->account_number ? $data->account_number : "-" }}</td>
                        </tr>
                        <tr>
                            <td>NPWP</td>
                            <td>:</td>
                            <td>{{ $data->tax_number ? $data->tax_number : "-" }}</td>
                        </tr>
                        <tr>
                            <td>No BPJS</td>
                            <td>:</td>
                            <td>{{ $data->medical_number ? $data->medical_number : "-" }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Lengkap</td>
                            <td>:</td>
                            <td>{{ $data->address ? $data->address : "-" }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <legend>4. Lampiran / Dokumen Pendukung</legend>
                    <table class="table table-striped  dt-responsive nowrap">
                        @foreach($attachments as $row)
                        <tr>
                            <td width="200">{{ $row->name }}</td>
                            <td width="50">:</td>
                            <td>
                                @php
                                    $file = \App\Helpers\AppHelper::getFileByGroup("App\Models\Employees\Employee", $data->id,  $row->id);
                                @endphp
                                @if(!is_null($file))
                                    <a href="{{ url($file->path) }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="fa fa-paperclip"></i>
                                    </a>  
                                @else
                                    -- Tidak ada file --
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <legend>5. Pengalaman Bekerja</legend>
                    <table class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Posisi</th>
                                <th>Divisi</th>
                                <th>Gaji</th>
                                <th>Periode</th>
                            </tr>
                        </thead>       
                        <tbody>
                            @php $num = 1; @endphp
                            @if(count($experinces) == 0)
                                <tr>
                                    <td class="text-center" colspan="5"> -- Tidak ada Data --</td>
                                </tr>
                            @endif
                            @foreach($experinces as $row)
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
                                    <td>{{ $row->company_name }}</td>
                                    <td>{{ $row->Position ? $row->Position->name : "-" }}</td>
                                    <td>{{ $row->Division ? $row->Division->name : "-" }}</td>
                                    <td>{{ number_format($row->sallary, 2, ',', '.')." (".$currency.")" }}</td>
                                    <td>{{ $workPeriod }}</td>
                                </tr>
                            @php $num++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <legend>6. Riwayat Pendidikan</legend>
                    <table class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Nama Institusi</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Program Studi</th>
                                <th>Periode</th>
                            </tr>
                        </thead>       
                        <tbody>
                            @php $num = 1; @endphp
                            @if(count($educations) == 0)
                                <tr>
                                    <td class="text-center" colspan="5"> -- Tidak ada Data --</td>
                                </tr>
                            @endif
                            @foreach($educations as $row)
                                @php 
                                    $startPeriod = "-";
                                    $endPeriod = "-";
                                    if(!is_null($row->month_start) && !is_null($row->year_start)) $startPeriod = \App\Helpers\AppHelper::getMonth($row->month_start)." ".$row->year_start;
                                    if(!is_null($row->month_end) && !is_null($row->year_end)) $endPeriod = \App\Helpers\AppHelper::getMonth($row->month_end)." ".$row->year_end;
                                    $workPeriod = $startPeriod." s/d ".$endPeriod;
                                @endphp
                                <tr id="{{ $num }}">
                                    <textarea class="item hidden" id="item{{ $num }}">{{ json_encode($row) }}</textarea>
                                    <td>{{ $row->school_name }}</td>
                                    <td>{{ $row->department }}</td>
                                    <td>{{ $row->specliationation }}</td>
                                    <td>{{ $row->Qualification ? $row->Qualification->name : "-" }}</td>
                                    <td>{{ $workPeriod }}</td>
                                </tr>
                            @php $num++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <legend>7. Keahlian</legend>
                    <table class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Nama Keahlian</th>
                                <th>Tingkat Kemahiran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>       
                        <tbody>
                            @php $num = 1; @endphp
                            @if(count($specialist) == 0)
                                <tr>
                                    <td class="text-center" colspan="3"> -- Tidak ada Data --</td>
                                </tr>
                            @endif
                            @foreach($specialist as $row)
                                <tr id="{{ $num }}">
                                    <textarea class="item hidden" id="item{{ $num }}">{{ json_encode($row) }}</textarea>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ \App\Helpers\AppHelper::getSkills($row->level) }}</td>
                                    <td>{{ $row->description }}</td>
                                </tr>
                            @php $num++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <legend>8. Kemampuan Bahasa</legend>
                    <table class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Bahasa</th>
                                <th>Menulis</th>
                                <th>Membaca</th>
                                <th>Mendengarkan</th>
                            </tr>
                        </thead>       
                        <tbody>
                            @php $num = 1; @endphp
                            @if(count($toefl) == 0)
                                <tr>
                                    <td class="text-center" colspan="4"> -- Tidak ada Data --</td>
                                </tr>
                            @endif
                            @foreach($toefl as $row)
                                <tr id="{{ $num }}">
                                    <textarea class="item hidden" id="item{{ $num }}">{{ json_encode($row) }}</textarea>
                                    <td>{{ $row->language }}</td>
                                    <td>{{ $row->write }}</td>
                                    <td>{{ $row->read }}</td>
                                    <td>{{ $row->listen }}</td>
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

@endsection