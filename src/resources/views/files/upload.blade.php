<!-- /resources/views/files/upload.blade.php -->
@extends('app')

@section('content')
<h2>{{ trans('jrl.upload_workout_file') }}</h2>

{!! Form::open(array('files'=>'true', 'method'=>'POST', 'url'=>'/parse')) !!}
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('file', ucfirst(trans('jrl.description')).':',['class' => 'control-label']) !!}
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
        <p id="success" class="alert alert-info">{{ trans('jrl.choose_gpx_file') }}.</p>        
    </div>
</div>
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::submit(ucfirst(trans('app.upload')), ['class'=>'btn btn-primary']) !!}
        </div>            
    </div>
</div>
{!! Form::close() !!}
@endsection
