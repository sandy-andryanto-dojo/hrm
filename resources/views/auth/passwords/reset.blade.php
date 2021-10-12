@extends('layouts.auth')
@section('title') Pemulihan Kata Sandi @endsection
@section('content')

<form id="log_in" method="POST" action="{{ route('password.request') }}" />
    {{ csrf_field() }}  
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="input-group addon-line">
        <span class="input-group-addon">
            <i class="material-icons">mail</i>
        </span>
        <div class="form-line {{ $errors->has('email') ? ' error focused' : '' }}">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}"  />
        </div>
        @if($errors->has('email'))
            <label id="email-error" class="error" for="email">{{ $errors->first('email') }}.</label>
        @endif
    </div>
    <div class="input-group addon-line error">
        <span class="input-group-addon">
            <i class="material-icons">lock</i>
        </span>
        <div class="form-line {{ $errors->has('password') ? ' error focused' : '' }}">
            <input type="password" class="form-control" name="password" placeholder="Kata Sandi"  />
        </div>
        @if($errors->has('password'))
            <label id="password-error" class="error" for="password">{{ $errors->first('password') }}.</label>
        @endif
    </div>
    <div class="input-group addon-line error">
        <span class="input-group-addon">
            <i class="material-icons">lock</i>
        </span>
        <div class="form-line {{ $errors->has('password_confirmation') ? ' error focused' : '' }}">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Kata Sandi"  />
        </div>
        @if($errors->has('password_confirmation'))
            <label id="password-confirmation-error" class="error" for="password_confirmation">{{ $errors->first('password_confirmation') }}.</label>
        @endif
    </div>

    <a class="btn btn-sm btn-default btn-block" href="{{ route('login') }}">Pulihkan Kata Sandi</a>

</form>

@endsection