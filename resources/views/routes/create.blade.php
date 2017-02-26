<!-- /resources/views/routes/edit.blade.php -->
@extends('app')

@section('content')
<div class="row">
    {!! Form::model(new App\Models\Route, ['route' => 'routes.store', 'class'=>'form-horizontal']) !!}
    <div class="col-lg-9">
        <div class="page-header">
            <h2>{{ ucfirst(trans('app.create_new')) }} {{ trans_choice('jrl.routes',1) }}</h2>
        </div>
    </div>
    @include('routes/partials/_form', ['rating' => 3])
    {!! Form::close() !!}
</div>
@endsection