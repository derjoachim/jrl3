<!-- /resources/views/files/upload.blade.php -->
@extends('app')

@section('content')
<h2>Upload een workout-bestand</h2>

{!! Form::open(array('files'=>'true', 'method'=>'POST', 'url'=>'/parse')) !!}
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('file', 'Omschrijving:',['class' => 'control-label']) !!}
            {!! Form::file('file') !!}
        </div>
    </div>
</div>
<div class="row-fluid">
    @if ( Session::has('error') )
        <div class="col-lg-12">
            <p class="alert alert-error"></p>        
        </div>
    @endif
    <div class="col-lg-12">
        <p id="success" class="alert alert-success"></p>        
    </div>
</div>
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::submit('Upload', ['class'=>'btn btn-primary']) !!}
        </div>            
    </div>
</div>
{!! Form::close() !!}
@endsection
