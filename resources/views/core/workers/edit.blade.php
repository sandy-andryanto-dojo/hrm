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

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title"> Data Pegawai</h4>
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
                    Edit Data
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

{!! Form::model(null, ['method' => 'PATCH','class'=>'','id'=>'form-delete-attachment','route' => ['workers.update', 0] ,'enctype'=>'multipart/form-data']) !!}
    <input type="hidden" name="eid" id="eid" />
    <input type="hidden" name="employee_id" id="employee_id" value="{{ $data->id }}" />
{{ Form::close() }}

<div class="row">
    <div class="col-md-12">
        @include('layouts.alert')
        <div class="card-box">
                {!! Form::model($data, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'FormSubmit','route' => ['workers.update', $data->id] ,'enctype'=>'multipart/form-data']) !!}
                <input type="hidden" name="user_id" id="user_id" value="{{ $data->user_id }}" />
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend>1. Informasi Umum</legend>
                            <div class="form-group {{ $errors->has('employee_number') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">NIK <span class="text-danger">*</span> </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" readonly="readonly" value="{{ $data->employee_number }}" />
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('division_id') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Divisi <span class="text-danger">*</span> </label>
                                <div class="col-md-10">
                                    {!! Form::select('division_id', $divisions->pluck('name','id'), null, ['id'=>'division_id','class'=>'select2', 'placeholder'=>'-- Pilih Divisi --']) !!}
                                    @if ($errors->has('division_id'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('division_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('position_id') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Posisi <span class="text-danger">*</span> </label>
                                <div class="col-md-10">
                                    {!! Form::select('position_id', $positions->pluck('name','id'), null, ['id'=>'position_id','class'=>'select2', 'placeholder'=>'-- Pilih Posisi --']) !!}
                                    @if ($errors->has('position_id'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('position_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Tipe <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    {!! Form::select('type_id', $types->pluck('name','id'), null, ['id'=>'type_id','class'=>'select2', 'placeholder'=>'-- Pilih Tipe --']) !!}
                                    @if ($errors->has('type_id'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('type_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('job_id') ? ' has-error' : '' }}">
                                <label class="col-md-2 control-label">Profesi </label>
                                <div class="col-md-10">
                                    {!! Form::select('job_id', $jobs->pluck('name','id'), null, ['id'=>'job_id','class'=>'select2', 'placeholder'=>'-- Pilih Profesi --']) !!}
                                    @if ($errors->has('job_id'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('job_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset>
                            <legend>2. Akun Sistem dan Akses</legend>
                            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Username <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" name="username" id="username" class="form-control" value="{{ $data->username }}" />
                                    @if ($errors->has('username'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('username') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Email Aktif <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $data->email }}" />
                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('email') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Nomor Telepon Aktif  <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $data->phone }}" />
                                    @if ($errors->has('phone'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('phone') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Kata Sandi </label>
                                <div class="col-md-9">
                                    <input type="password" name="password" id="password" class="form-control" value="" />
                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('password') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('roles') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Akses Pengguna <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    {!! Form::select('roles[]', $roles->pluck('name','id'), null, ['id'=>'role_id','class'=>'select2',  'multiple'=>'multiple']) !!}
                                    @if ($errors->has('roles'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('roles') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="col-md-6">
                        <fieldset>
                            <legend>3. Biodata</legend>
                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Nama Depan <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $data->first_name }}">
                                    @if ($errors->has('first_name'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('first_name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Nama Belakang </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $data->last_name }}">
                                    @if ($errors->has('last_name'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('last_name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('nick_name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Nama Panggilan <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nick_name" name="nick_name" value="{{ $data->nick_name }}">
                                    @if ($errors->has('nick_name'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('nick_name') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Jenis Kelamin<span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    @foreach($genders as $gender)
                                    @php $checked = $gender->id == $data->gender_id ? "checked" : "" ; @endphp
                                    <div class="radio radio-inline radio-primary">
                                        <input id="gender{{ $gender->id }}" type="radio" name="gender_id" value="{{ $gender->id}}" {{ $checked }} >
                                        <label for="gender{{ $gender->id }}">
                                            {{ $gender->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @if ($errors->has('gender_id'))
                                        <div class="clearfix"></div>
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('gender_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('birth_date') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control input-datepicker" id="birth_date" name="birth_date" value="{{ $data->birth_date }}">
                                    @if ($errors->has('birth_date'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('birth_date') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('birth_place') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="birth_place" name="birth_place" value="{{ $data->birth_place }}">
                                    @if ($errors->has('birth_place'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('birth_place') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Status Nikah <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    @foreach($maritals as $marital)
                                    @php $checked = $marital->id == $data->status_id ? "checked" : "" ; @endphp
                                    <div class="radio radio-inline radio-primary">
                                        <input id="marital{{ $marital->id }}" type="radio" name="status_id" value="{{ $marital->id}}" {{ $checked }}>
                                        <label for="marital{{ $marital->id }}">
                                            {{ $marital->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @if ($errors->has('status_id'))
                                        <div class="clearfix"></div>
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('status_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('total_child') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Jumlah Anak</label>
                                <div class="col-md-9">
                                    <input type="number" min="0" class="form-control" id="total_child" name="total_child" value="{{ $data->total_child ? $data->total_child : 0 }}">
                                    @if ($errors->has('total_child'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('total_child') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('blood_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Golongan Darah <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    @foreach($bloods as $blood)
                                    @php $checked = $blood->id == $data->blood_id ? "checked" : "" ; @endphp
                                    <div class="radio radio-inline radio-primary">
                                        <input id="blood{{ $blood->id }}" type="radio" name="blood_id" value="{{ $blood->id}}" {{ $checked  }} >
                                        <label for="blood{{ $blood->id }}">
                                            {{ $blood->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @if ($errors->has('blood_id'))
                                        <div class="clearfix"></div>
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('blood_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('use_lens') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Menggunakan Lensa <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <div class="radio radio-inline radio-primary">
                                        <input id="use_lens" type="radio" name="use_lens" value="1" {{ $data->use_lens == "1" ? "checked" : "" }}>
                                        <label for="use_lens">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="radio radio-inline radio-primary">
                                        <input id="use_lens" type="radio" name="use_lens" value="0" {{  $data->use_lens == "0" ? "checked" : "" }}>
                                        <label for="use_lens">
                                            Tidak
                                        </label>
                                    </div>
                                    @if ($errors->has('use_lens'))
                                        <div class="clearfix"></div>
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('use_lens') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('weight') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Berat (Kg) <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" id="weight" name="weight" min="0" step="any" value="{{ $data->weight }}">
                                    @if ($errors->has('weight'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('weight') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('height') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Tinggi (Cm) <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" id="height" name="height" min="0" step="any" value="{{ $data->height }}">
                                    @if ($errors->has('height'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('height') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Kode Pos</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $data->postal_code }}">
                                    @if ($errors->has('postal_code'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('postal_code') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Kewarganegaraan <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    {!! Form::select('country_id', $countries->pluck('name','id'), null, ['id'=>'country_id','class'=>'select2', 'placeholder'=>'-- Pilih Kewarganegaraan --']) !!}
                                    @if ($errors->has('country_id'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('country_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('identity_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Jenis Identitas <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    {!! Form::select('identity_id', $identities->pluck('name','id'), null, ['id'=>'identity_id','class'=>'select2', 'placeholder'=>'-- Pilih Jenis Identitas --']) !!}
                                    @if ($errors->has('identity_id'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('identity_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('identity_number') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Nomor Identitas <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="identity_number" name="identity_number" value="{{ $data->identity_number }}">
                                    @if ($errors->has('identity_number'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('identity_number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('family_number') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Nomor Kartu Keluarga</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="family_number" name="family_number" value="{{ $data->family_number }}">
                                    @if ($errors->has('family_number'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('family_number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('bank_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Bank <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    {!! Form::select('bank_id', $banks->pluck('name','id'), null, ['id'=>'bank_id','class'=>'select2', 'placeholder'=>'-- Pilih Bank --']) !!}
                                    @if ($errors->has('bank_id'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('bank_id') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('account_number') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">No Rekening <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="account_number" name="account_number" value="{{ $data->account_number }}">
                                    @if ($errors->has('account_number'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('account_number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('tax_number') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">NPWP <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="tax_number" name="tax_number" value="{{ $data->tax_number }}">
                                    @if ($errors->has('tax_number'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('tax_number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('medical_number') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">No BPJS <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="medical_number" name="medical_number" value="{{ $data->medical_number }}">
                                    @if ($errors->has('medical_number'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('medical_number') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">Alamat Lengkap <span class="text-danger">*</span> </label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="address" name="address" rows="5">{{ $data->address }}</textarea> 
                                    @if ($errors->has('address'))
                                        <span class="help-block text-danger">
                                            <small>{{ $errors->first('address') }}</small>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset>
                            <legend>4. Lampiran / Dokumen Pendukung</legend>
                            @foreach($attachments as $row)
                            <div class="form-group {{ $errors->has('filename') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">{{ $row->name }} </label>
                                <div class="col-md-7">
                                    <input type="hidden" name="group_id[]" value="{{ $row->id }}" />
                                    <input type="file" name="filename[]" class="file-input-lampiran" />
                                    @php
                                        $file = \App\Helpers\AppHelper::getFileByGroup("App\Models\Employees\Employee", $data->id,  $row->id);
                                    @endphp
                                </div>
                                <div class="col-md-2">
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
                                </div>
                            </div>
                            @endforeach
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <div class="clearfix">
                            <div class="pull-left">
                                <a href="{{ route('workers.index') }}" class="btn btn-primary waves-effect waves-light">
                                    <i class="fa fa-mail-reply"></i>&nbsp; Kembali
                                </a>
                            </div>
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
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection