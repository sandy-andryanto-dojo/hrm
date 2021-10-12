@extends('layouts.core')
@section('title') Kemampuan Bahasa @endsection

@section('script')
    <script src="{{ asset('assets/app/js/profiles-languages.js') }}"></script>
@endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

{!! Form::model(null, ['method' => 'PATCH','class'=>'','id'=>'form-delete','route' => ['profiles.update', 5] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="eid" id="eid" />
{{ Form::close() }}

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Kemampuan Bahasa</h4>
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
                    Kemampuan Bahasa
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
                <li class="active">
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
                        <a href="{{ route('profiles.create') }}" class="btn btn-success btn-sm btn-create-data">
                            <i class="fa fa-plus"></i>&nbsp;Tambah Baru
                        </a>
                    </div>
                    <h1></h1>
                    <table class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bahasa</th>
                                <th>Menulis</th>
                                <th>Membaca</th>
                                <th>Mendengarkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>       
                        <tbody>
                            @php $num = 1; @endphp
                            @if(count($data) == 0)
                                <tr>
                                    <td class="text-center" colspan="6"> -- Tidak ada Data --</td>
                                </tr>
                            @endif
                            @foreach($data as $row)
                                <tr id="{{ $num }}">
                                    <textarea class="item hidden" id="item{{ $num }}">{{ json_encode($row) }}</textarea>
                                    <td>{{ $num }}</td>
                                    <td>{{ $row->language }}</td>
                                    <td>{{ $row->write }}</td>
                                    <td>{{ $row->read }}</td>
                                    <td>{{ $row->listen }}</td>
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

<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(array('route' => 'profiles.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                <input type="hidden" name="redirect" value="{{ $redirect }}" />
                <input type="hidden" name="id" id="id" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Form Kemampuan Bahasa</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bahasa</label>
                        <div class="col-md-9">
                            {!! Form::select('language', $languages, null, ['id'=>'language','class'=>'select2', 'placeholder'=>'-- Pilih Bahasa --']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Kemampuan Membaca </label>
                        <div class="col-md-9">
                            <input type="number" id="read" name="read" class="form-control" min="0" max="100" step="any" placeholder="Index 0 - 100"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Kemampuan Mendengarkan </label>
                        <div class="col-md-9">
                            <input type="number" id="listen" name="listen" class="form-control" min="0" max="100" step="any" placeholder="Index 0 - 100"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Kemampuan Menulis </label>
                        <div class="col-md-9">
                            <input type="number" id="write" name="write" class="form-control" min="0" max="100" step="any" placeholder="Index 0 - 100"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Keterangan</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        <i class="fa fa-save"></i>&nbsp; Simpan
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection