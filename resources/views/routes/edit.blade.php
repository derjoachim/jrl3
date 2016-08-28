<!-- /resources/views/routes/edit.blade.php -->
@extends('app')

@section('content')
<div class="row">
    {!! Form::model($route, ['method' => 'PATCH', 'route' => ['routes.update', $route->slug]]) !!}
    
    <div class="col-lg-9">
        <div class="page-header">
            <h2>{{ $route->name }} - <small>{{ ucfirst(trans('app.edit')) }}</small></h2>
        </div>
    </div>
    @include('routes/partials/_form', ['rating' => $route->rating])
    {!! Form::close() !!}
</div>
@endsection