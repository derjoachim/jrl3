<!-- /resources/views/workouts/edit.blade.php -->
@extends('app')

@section('content')
    <h2>{{ ucfirst(trans_choice('jrl.workouts',1)) }} {{ trans('app.edit') }} - {{ $workout->name }}</h2>

    {!! Form::model($workout, ['method' => 'PATCH', 'route' => ['workouts.update', $workout->slug]]) !!}
    @include('workouts/partials/_form', ['submit_text' => ucfirst(trans('app.save'))])
    {!! Form::close() !!}
@endsection