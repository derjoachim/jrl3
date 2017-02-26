<!-- /resources/views/exports/index.blade.php -->
@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-9">
        <h2>Exporteren logboek jaargangen</h2>
        
@if( count($years) == 0 ) 
<div class="alert alert-info">Geen workouts gevonden, dus niets te exporteren</div>
@else
    {!! Form::open(['url' => 'export/export', 'class'=>'form-horizontal']) !!}
    </div>
    <div class="col-lg-3">
        <div class="btn-group" role="group" >
            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-export"></i> 
                {{ ucfirst(trans('app.export')) }}
            </button>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-lg-9">
        <div class="form-group">
            <h3>{{ ucfirst(trans('jrl.general_data')) }}</h3>
            {!! Form::label('year', ucfirst(trans('app.year')) .':',['class' => 'control-label']) !!}
            {!! Form::select('year',$years, date('Y'),['class' => 'form-control input-lg']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="form-group">
            {!! Form::label('description', ucfirst(trans('jrl.description')).':',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor', 'rows' => '5']) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}
@endif
@endsection