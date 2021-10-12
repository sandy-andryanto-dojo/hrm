@extends('layouts.auth')
@section('title') Pulihkan Kata Sandi @endsection
@section('content')

<form id="log_in" method="POST" action="{{ route('password.email') }}" />
    {{ csrf_field() }}  
    @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif
    <div class="input-group addon-line">
        <span class="input-group-addon">
            <i class="material-icons">mail</i>
        </span>
        <div class="form-line {{ $errors->has('email') ? ' error focused' : '' }}">
            <input type="text" class="form-control" name="email" placeholder="Username atau Email" value="{{ old('email') }}"  autofocus="" />
        </div>
        @if($errors->has('email'))
            <label id="username-error" class="error" for="username">{{ $errors->first('email') }}.</label>
        @endif
    </div>
   

    <button class="btn btn-block btn-primary waves-effect" type="submit">KIRIM PERMINTAAN</button>

    <p class="text-muted text-center p-t-20">
        <small>Sudah memilik akun ?</small>
    </p>

    <a class="btn btn-sm btn-default btn-block" href="{{ route('login') }}">Masuk Disini</a>

</form>

@endsection