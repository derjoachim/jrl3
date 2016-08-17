<!-- /resources/views/workouts/create.blade.php -->
@extends('app')

@section('content')
    <h2>{{ ucfirst(trans('app.create_new')) }} {{ trans_choice('jrl.workouts',1) }}</h2>
    
    {!! Form::model(new App\Workout, ['route' => 'workouts.store']) !!}
    @include('workouts/partials/_form', [
        'submit_text' => ucfirst(trans('app.create')),
        'routes' => $routes, 
        'route_id' => '', 
        'mood' => 3, 
        'health' => 3 
        ])
    {!! Form::close() !!}
@endsection