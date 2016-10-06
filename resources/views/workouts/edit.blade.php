<!-- /resources/views/workouts/edit.blade.php -->
@extends('app')

@section('content')
<div class="row">
    {!! Form::model($workout, ['method' => 'PATCH', 'route' => ['workouts.update', $workout->slug], 'class'=>'form-horizontal']) !!}
    <div class="col-lg-9">
        <div class="page-header">
            <h2>{{ $workout->name }} <small>{{ trans('app.edit') }}</small></h2>
        </div>
    </div>
    @include('workouts/partials/_form')
    {!! Form::close() !!}
</div>
@endsection