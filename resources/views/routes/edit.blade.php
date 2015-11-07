<!-- /resources/views/routes/edit.blade.php -->
@extends('app')

@section('content')
    <h2>{{ ucfirst(trans_choice('jrl.routes',1)) }} {{ trans('app.edit') }} - {{ $route->name }}</h2>
    
    {!! Form::model($route, ['method' => 'PATCH', 'route' => ['routes.update', $route->slug]]) !!}
    @include('routes/partials/_form', ['submit_text' => ucfirst(trans('app.save')),'rating' => $route->rating])
    {!! Form::close() !!}
@endsection