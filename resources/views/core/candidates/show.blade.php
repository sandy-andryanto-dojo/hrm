@extends('layouts.core')
@section('title') Kandidat @endsection

@section('script')
    <script src="{{ asset('assets/app/js/candidates.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

{{ Form::open(['method' => $form['method'],'id'=>'form-delete', 'route' =>  $form['route']]) }}
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title"> Kandidat</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="{{ url('') }}">Beranda</a>
                </li>
                <li>
                    <a href="#">Perekrutan</a>
                </li>
                <li>
                    <a href="{{ route('candidates.index') }}"> Kandidat</a>
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
                    <h4>Detail Kandidat</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('candidates.create') }}" class="btn btn-success btn-create-data btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;Tambah Data
                    </a>
                    <a href="{{ route('candidates.edit',['category'=>$data->id]) }}"
                        class="btn btn-info btn-edit-data btn-sm">
                        <i class="fa fa-edit"></i>&nbsp;Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-remove-data btn-delete btn-sm">
                        <i class="fa fa-trash"></i>&nbsp;Hapus
                    </a>
                    <a href="{{ route('candidates.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            <table class="table table-striped table-colored table-info dt-responsive nowrap">
                <tr>
                    <td width="200">Lowongan</td>
                    <td width="50">:</td>
                    <td>
                        @foreach($vacancies as $vac)
                            {{ $vac->Vacancy->name }}&nbsp;,
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td>{{ $data->first_name." ".$data->last_name }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $data->Gender ? $data->Gender->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Kewarganegaraan</td>
                    <td>:</td>
                    <td>{{ $data->Country ? $data->Country->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Jenis Identitas</td>
                    <td>:</td>
                    <td>{{ $data->Identity ? $data->Identity->name : "-" }}</td>
                </tr>
                <tr>
                    <td>No Identitas</td>
                    <td>:</td>
                    <td>{{ $data->identity_number ? $data->identity_number : "-" }}</td>
                </tr>
                <tr>
                    <td>Tempat Lahir</td>
                    <td>:</td>
                    <td>{{ $data->birth_place ? $data->birth_place : "-" }}</td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $data->birth_date ? $data->birth_date : "-" }}</td>
                </tr>
                <tr>
                    <td>Golongan Darah</td>
                    <td>:</td>
                    <td>{{ $data->Blood ? $data->Blood->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Status Nikah</td>
                    <td>:</td>
                    <td>{{ $data->Status ? $data->Status->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>{{ $data->email ? $data->email : "-" }}</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td>:</td>
                    <td>{{ $data->phone ? $data->phone : "-" }}</td>
                </tr>
                <tr>
                    <td>Kode Pos</td>
                    <td>:</td>
                    <td>{{ $data->postal_code ? $data->postal_code : "-" }}</td>
                </tr>
                <tr>
                    <td>Alamat Lengkap</td>
                    <td>:</td>
                    <td>{{ $data->address ? $data->address : "-" }}</td>
                </tr>
                @foreach($attachments as $attachment)
                @php $file = \App\Helpers\AppHelper::getFileByGroup("App\Models\Recruitment\Candidate", $data->id,  $attachment->id);  @endphp
                <tr>
                    <td>{{ $attachment->name }}</td>
                    <td>:</td>
                    <td>{!! !is_null($file) ? "<a target='_blank' href='".url($file->path)."' class='btn btn-sm btn-success'><i class='fa fa-download'></i></a>" : "<a href='javascript:void(0);' disabled='disabled' class='btn btn-sm btn-success'><i class='fa fa-download'></i></a>"  !!}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection