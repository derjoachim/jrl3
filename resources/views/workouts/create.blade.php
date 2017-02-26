<!-- /resources/views/workouts/create.blade.php -->
@extends('app')

@section('content')
<div class="row">
    {!! Form::model(new App\Models\Workout, ['route' => 'workouts.store', 'class'=>'form-horizontal']) !!}

    <div class="col-lg-9">
        <div class="page-header">
            <h2>{{ ucfirst(trans('app.create_new')) }} {{ trans_choice('jrl.workouts',1) }}</h2>
        </div>
    </div>
    @include('workouts/partials/_form', [
        'submit_text' => ucfirst(trans('app.create')),
        'routes' => $routes, 
        'route_id' => '', 
        'mood' => 3, 
        'health' => 3 
        ])
    {!! Form::close() !!}
</div>
@endsection