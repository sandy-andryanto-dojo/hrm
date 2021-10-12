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
                    Tambah Data
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
                    <h4>Form Kandidat</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('candidates.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-mail-reply"></i>&nbsp;Kembali
                    </a>
                </div>
            </div>
            <hr>
            {!! Form::open(array('route' => 'candidates.store','method'=>'POST','class'=>'form-horizontal','id'=>'FormSubmit','role'=>'form', 'enctype'=>'multipart/form-data')) !!}
                <div class="form-group {{ $errors->has('vacancies') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Posisi <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        {!! Form::select('vacancies[]', $vacancies->pluck('name','id'), null, ['id'=>'role_id','class'=>'select2',  'multiple'=>'multiple']) !!}
                        @if ($errors->has('roles'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('vacancies') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama Depan <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}">
                        @if ($errors->has('first_name'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('first_name') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nama Belakang </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
                        @if ($errors->has('last_name'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('last_name') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Jenis Kelamin <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        @foreach($genders as $gender)
                        @php $checked = null; @endphp
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
                    <label class="col-md-2 control-label">Tanggal Lahir <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input-datepicker" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                        @if ($errors->has('birth_date'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('birth_date') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('birth_place') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Tempat Lahir <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="birth_place" name="birth_place" value="{{  old('birth_place') }}">
                        @if ($errors->has('birth_place'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('birth_place') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Status Nikah <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        @foreach($maritals as $marital)
                        @php $checked =  null; @endphp
                        <div class="radio radio-inline radio-primary">
                            <input id="marital{{ $marital->id }}" type="radio" name="status_id" value="{{ $marital->id}}" {{ $checked }}>
                            <label for="marital{{ $marital->id }}">
                                {{ $marital->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group {{ $errors->has('blood_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Golongan Darah <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        @foreach($bloods as $blood)
                        @php $checked =  null; @endphp
                        <div class="radio radio-inline radio-primary">
                            <input id="blood{{ $blood->id }}" type="radio" name="blood_id" value="{{ $blood->id}}" {{ $checked }}>
                            <label for="blood{{ $blood->id }}">
                                {{ $blood->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Kewarganegaraan <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        {!! Form::select('country_id', $countries->pluck('name','id'), null, ['id'=>'type','class'=>'select2', 'placeholder'=>'-- Pilih Kewarganegaraan --']) !!}
                        @if ($errors->has('country_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('country_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('identity_id') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Jenis Identitas <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        {!! Form::select('identity_id', $identities->pluck('name','id'), null, ['id'=>'type','class'=>'select2', 'placeholder'=>'-- Pilih Jenis Identitas --']) !!}
                        @if ($errors->has('identity_id'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('identity_id') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('identity_number') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nomor Identitas <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="identity_number" name="identity_number" value="{{ old('identity_number') }}">
                        @if ($errors->has('identity_number'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('identity_number') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Email <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('email') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Nomor Telepon <span class="text-danger">*</span> </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('phone') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('postal_code') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Kode Pos </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                        @if ($errors->has('postal_code'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('postal_code') }}</small>
                            </span>
                        @endif
                    </div>
                </div>    
                <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Alamat <span class="text-danger">*</span>  </label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="address" name="address" rows="5">{{ old('address') }}</textarea>
                        @if ($errors->has('address'))
                            <span class="help-block text-danger">
                                <small>{{ $errors->first('address') }}</small>
                            </span>
                        @endif
                    </div>
                </div>
                @foreach($attachments as $attachment)
                <div class="form-group">
                    <label class="col-md-2 control-label">{{ $attachment->name }}</label>
                    <div class="col-md-10">
                        <input type="file" name="filename[]" class="file-input-lampiran" />
                        <input type="hidden" name="group_id[]" value="{{ $attachment->id }}" />
                    </div>
                </div>
                @endforeach
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

@endsection