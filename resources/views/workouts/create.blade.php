<!-- /resources/views/workouts/create.blade.php -->
@extends('app')

@section('content')
    <h2>Sla een nieuwe workout op</h2>
    
    {!! Form::model(new Jrl3\Workout, ['route' => 'workouts.store']) !!}
    @include('workouts/partials/_form', [
        'submit_text' => 'Aanmaken',
        'routes' => $routes, 
        'route_id' => '', 
        'mood' => 3, 
        'health' => 3 
        ])
    {!! Form::close() !!}
@endsection