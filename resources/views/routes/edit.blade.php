<!-- /resources/views/routes/edit.blade.php -->
@extends('app')

@section('content')
    <h2>Bewerk route {{ $route->name }}</h2>
    
    {!! Form::model($route, ['method' => 'PATCH', 'route' => ['routes.update', $route->slug]]) !!}
    @include('routes/partials/_form', ['submit_text' => 'Opslaan'])
    {!! Form::close() !!}
@endsection