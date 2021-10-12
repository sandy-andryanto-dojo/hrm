@extends('layouts.core')
@section('title') Biodata @endsection

@if(isset($metaPermission))
    @section('meta')
        {!! $metaPermission !!}
    @endsection
@endif

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Biodata</h4>
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
                    Biodata
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
                <li class="active">
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
                <li class="">
                    <a href="{{ route('profiles.show',['id'=>6]) }}" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Lampiran</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">
                    <h1></h1>
                    {!! Form::model($data->UserProfile, array('route' => 'profiles.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form')) !!}
                        <input type="hidden" name="redirect" value="{{ $redirect }}" />
                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Nama Depan  </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $data->UserProfile->first_name }}">
                                @if ($errors->has('first_name'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('first_name') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Nama Belakang  </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $data->UserProfile->last_name }}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('last_name') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('nick_name') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Nama Panggilan  </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="nick_name" name="nick_name" value="{{ $data->UserProfile->nick_name }}">
                                @if ($errors->has('nick_name'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('nick_name') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Jenis Kelamin  </label>
                            <div class="col-md-10">
                                @foreach($genders as $gender)
                                @php $checked = $gender->id == $data->UserProfile->gender_id ? "checked" : "" ; @endphp
                                <div class="radio radio-inline radio-primary">
                                    <input id="gender{{ $gender->id }}" type="radio" name="gender_id" value="{{ $gender->id}}" {{ $checked }}>
                                    <label for="gender{{ $gender->id }}">
                                        {{ $gender->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('birth_date') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Tanggal Lahir  </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control input-datepicker" id="birth_date" name="birth_date" value="{{ $data->UserProfile->birth_date }}">
                                @if ($errors->has('birth_date'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('birth_date') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('birth_place') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Tempat Lahir  </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="birth_place" name="birth_place" value="{{ $data->UserProfile->birth_place }}">
                                @if ($errors->has('birth_place'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('birth_place') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Status Nikah  </label>
                            <div class="col-md-10">
                                @foreach($maritals as $marital)
                                @php $checked = $marital->id == $data->UserProfile->status_id ? "checked" : "" ; @endphp
                                <div class="radio radio-inline radio-primary">
                                    <input id="marital{{ $marital->id }}" type="radio" name="status_id" value="{{ $marital->id}}" {{ $checked }}>
                                    <label for="marital{{ $marital->id }}">
                                        {{ $marital->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('total_child') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Jumlah Anak</label>
                            <div class="col-md-10">
                                <input type="number" min="0" class="form-control" id="total_child" name="total_child" value="{{ $data->UserProfile->total_child }}">
                                @if ($errors->has('total_child'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('total_child') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('blood_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Golongan Darah  </label>
                            <div class="col-md-10">
                                @foreach($bloods as $blood)
                                @php $checked = $blood->id == $data->UserProfile->blood_id ? "checked" : "" ; @endphp
                                <div class="radio radio-inline radio-primary">
                                    <input id="blood{{ $blood->id }}" type="radio" name="blood_id" value="{{ $blood->id}}" {{ $checked }}>
                                    <label for="blood{{ $blood->id }}">
                                        {{ $blood->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('use_lens') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Menggunakan Lensa  </label>
                            <div class="col-md-10">
                                <div class="radio radio-inline radio-primary">
                                    <input id="use_lens" type="radio" name="use_lens" value="1" {{ $employee->use_lens == 1 ? "checked" : "" }}>
                                    <label for="use_lens">
                                        Ya
                                    </label>
                                </div>
                                <div class="radio radio-inline radio-primary">
                                    <input id="use_lens" type="radio" name="use_lens" value="0" {{ $employee->use_lens == 0 ? "checked" : "" }}>
                                    <label for="use_lens">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('weight') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Berat (Kg)</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" id="weight" name="weight" min="0" step="any" value="{{ $employee->weight }}">
                                @if ($errors->has('weight'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('weight') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('height') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Tinggi (Cm)</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" id="height" name="height" min="0" step="any" value="{{ $employee->height }}">
                                @if ($errors->has('height'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('height') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('postal_code') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Kode Pos  </label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $data->UserProfile->postal_code }}">
                                @if ($errors->has('postal_code'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('postal_code') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Kewarganegaraan</label>
                            <div class="col-md-10">
                                {!! Form::select('country_id', $countries->pluck('name','id'), null, ['id'=>'country_id','class'=>'select2', 'placeholder'=>'-- Pilih Kewarganegaraan --']) !!}
                                @if ($errors->has('country_id'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('country_id') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('identity_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Jenis Identitas</label>
                            <div class="col-md-10">
                                {!! Form::select('identity_id', $identities->pluck('name','id'), null, ['id'=>'identity_id','class'=>'select2', 'placeholder'=>'-- Pilih Jenis Identitas --']) !!}
                                @if ($errors->has('identity_id'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('identity_id') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('identity_number') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Nomor Identitas</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="identity_number" name="identity_number" value="{{ $data->UserProfile->identity_number }}">
                                @if ($errors->has('identity_number'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('identity_number') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('family_number') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Nomor Kartu Keluarga</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="family_number" name="family_number" value="{{ $data->UserProfile->family_number }}">
                                @if ($errors->has('family_number'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('family_number') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('bank_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Bank  </label>
                            <div class="col-md-10">
                                {!! Form::select('bank_id', $banks->pluck('name','id'), null, ['id'=>'bank_id','class'=>'select2', 'placeholder'=>'-- Pilih Bank --']) !!}
                                @if ($errors->has('bank_id'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('bank_id') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('account_number') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">No Rekening</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="account_number" name="account_number" value="{{ $data->UserProfile->account_number }}">
                                @if ($errors->has('account_number'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('account_number') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('tax_number') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">NPWP</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="tax_number" name="tax_number" value="{{ $data->UserProfile->tax_number }}">
                                @if ($errors->has('tax_number'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('tax_number') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('medical_number') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">No BPJS</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="medical_number" name="medical_number" value="{{ $data->UserProfile->medical_number }}">
                                @if ($errors->has('medical_number'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('medical_number') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Alamat Lengkap </label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="address" name="address" rows="5">{{ $data->UserProfile->address  }}</textarea> 
                                @if ($errors->has('address'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('address') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('about_me') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label">Tentang Saya  </label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="about_me" name="about_me" rows="5">{{ $data->UserProfile->about_me  }}</textarea> 
                                @if ($errors->has('about_me'))
                                    <span class="help-block text-danger">
                                        <small>{{ $errors->first('about_me') }}</small>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="fa fa-save"></i>&nbsp; Simpan
                                </button>
                                <button type="reset" class="btn btn-warning waves-effect waves-light">
                                    <i class="fa fa-refresh"></i>&nbsp; Reset
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection