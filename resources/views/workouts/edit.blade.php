<!-- /resources/views/workouts/edit.blade.php -->
@extends('app')

@section('content')
    <h2>Bewerk workout {{ $workout->name }}</h2>

    {!! Form::model($workout, ['method' => 'PATCH', 'route' => ['workouts.update', $workout->slug]]) !!}
    @include('workouts/partials/_form', ['submit_text' => 'Opslaan'])
    {!! Form::close() !!}
@endsection