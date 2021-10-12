@extends('layouts.core')
@section('title') Lampiran @endsection

@section('script')
    <script src="{{ asset('assets/app/js/profiles-attachments.js') }}"></script>
@endsection


@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

{!! Form::model(null, ['method' => 'PATCH','class'=>'','id'=>'form-delete','route' => ['profiles.update', 6] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="eid" id="eid" />
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Lampiran</h4>
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
                    Lampiran
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
                <li class="">
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
                <li class="active">
                    <a href="{{ route('profiles.show',['id'=>6]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Lampiran</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    {!! Form::open(array('route' => 'profiles.store','method'=>'POST','enctype'=>'multipart/form-data','id'=>'FormSubmit','role'=>'form')) !!}
                        <input type="hidden" name="redirect" value="{{ $redirect }}" />
                        <table class="table table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Jenis Lampiran</th>
                                    <th colspan="2">Unggah / Unduh Lampiran</th>
                                </tr>
                            </thead>       
                            <tbody>
                                @php $num = 1; @endphp
                                @if(count($types) > 0)
                                    @foreach($types as $row)
                                        <tr id="{{ $num }}">
                                                <textarea class="item hidden" id="item{{ $num }}">{{ json_encode($row) }}</textarea>
                                                <input type="hidden" name="group_id[]" value="{{ $row->id }}" />
                                                <td>{{ $num }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>
                                                    <input type="file" name="filename[]" class="file-input-lampiran" />
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $file = \App\Helpers\AppHelper::getFileByGroup("App\Models\Employees\Employee", $eid,  $row->id);
                                                    @endphp
                                                    @if(!is_null($file))
                                                        <a href="{{ url($file->path) }}" target="_blank" class="btn  btn-primary">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" data-id="{{ $file->id }}" class="btn btn-hapus btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-warning disabled" >
                                                            <i class="fa fa-ban"></i>
                                                        </a>   
                                                    @endif
                                                   
                                                </td>
                                            </tr>
                                        @php $num++; @endphp
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        <hr>
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            <i class="fa fa-save"></i>&nbsp; Simpan
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection