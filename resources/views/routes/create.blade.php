<!-- /resources/views/routes/edit.blade.php -->
@extends('app')

@section('content')
    <h2>Stel een nieuwe route op</h2>
    
    {!! Form::model(new Jrl3\Route, ['route' => 'routes.store']) !!}
    @include('routes/partials/_form', ['submit_text' => 'Aanmaken'])
    {!! Form::close() !!}
@endsection