@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <i class="fa fa-info-circle"></i> <b>Informasi : </b> {!! $message !!}
</div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible" role="alert">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <i class="fa fa-check-square-o"></i> <b>Pesan Sukses : </b> {!! $message !!}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <i class="fa fa-warning"></i> <b>Peringatan : </b> {!! $message !!}
</div>
@endif

@if ($message = Session::get('danger'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <i class="fa fa-exclamation-circle"></i> <b>Ada Kesalahan : </b> {!! $message !!}
</div>
@endif