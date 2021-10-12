@extends('layouts.auth')
@section('title') Masuk @endsection
@section('content')

<form id="log_in" method="POST" action="{{ route('login') }}" />
    {{ csrf_field() }}  
    @include('layouts.alert')    
    <div class="input-group addon-line">
        <span class="input-group-addon">
            <i class="material-icons">person</i>
        </span>
        <div class="form-line {{ $errors->has('email') ? ' error focused' : '' }}">
            <input type="text" class="form-control" name="email" placeholder="Username atau Email" value="{{ old('email') }}"  autofocus="" />
        </div>
        @if($errors->has('email'))
            <label id="username-error" class="error" for="username">{{ $errors->first('email') }}.</label>
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
    <div class="row">
        <div class="col-xs-6 p-t-5">
            <input type="checkbox" name="remember" id="rememberme" class="filled-in chk-col-blue" {{ old('remember') ? 'checked' : '' }} />
            <label for="rememberme">Ingat Saya</label>
        </div>
        <div class="col-xs-6 align-right p-t-5">
            <a href="{{ route('password.request') }}">Lupa Kata Sandi ?</a>
        </div>
    </div>

    <button class="btn btn-block btn-primary waves-effect" type="submit">MASUK</button>

    <p class="text-muted text-center p-t-20 hidden">
        <small>Tidak memilik akun ?</small>
    </p>

    <a class="btn btn-sm btn-default btn-block hidden" href="{{ route('register') }}">Buat Akun Disini</a>

</form>

@endsection