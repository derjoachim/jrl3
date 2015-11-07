<!-- /resources/views/routes/edit.blade.php -->
@extends('app')

@section('content')
    <h2>{{ ucfirst(trans('app.create_new')) }} {{ trans_choice('jrl.routes',1) }}</h2>
    
    {!! Form::model(new Jrl3\Route, ['route' => 'routes.store']) !!}
    @include('routes/partials/_form', ['submit_text' => ucfirst(trans('app.create')), 'rating' => 3])
    {!! Form::close() !!}
@endsection