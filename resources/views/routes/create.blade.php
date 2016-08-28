<!-- /resources/views/routes/edit.blade.php -->
@extends('app')

@section('content')
{!! Form::model(new App\Route, ['route' => 'routes.store']) !!}
<div class="row">
    <div class="col-lg-9">
        <div class="page-header">
            <h2>{{ ucfirst(trans('app.create_new')) }} {{ trans_choice('jrl.routes',1) }}</h2>
        </div>
    </div>
    @include('routes/partials/_form', ['rating' => 3])
    {!! Form::close() !!}
</div>
@endsection