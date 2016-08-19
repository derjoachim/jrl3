<!-- /resources/views/routes/index.blade.php -->
@extends('app')

@section('content')
<h2>{{ ucfirst(trans_choice('jrl.standard_routes',2)) }}</h2>
@if( !$routes->count() ) 
<div class="alert alert-info">{!! trans('jrl.no_routes_defined', [ 'url' => URL::route('routes.create') ] ) !!}</div>
@else
<div class="row-fluid">
    <table class="table table-condensed table-striped">
        <thead>
            <th></th>
            <th>{{ ucfirst(trans('jrl.name')) }}</th>
            <th>{{ ucfirst(trans('jrl.distance')) }}</th>
            <th>{{ ucfirst(trans('jrl.start')) }}</th>
            <th>{{ ucfirst(trans('jrl.finish')) }}</th>
            <th>{{ ucfirst(trans('jrl.grade')) }}</th>
            <th></th>
        </thead>
        <tfoot>
            <th colspan='6'>&nbsp;</th>
            <th>{!! link_to_route('routes.create', ucfirst(trans('app.new')).' '.ucfirst(trans_choice('jrl.routes',1))
                ,array(),array('class' => 'btn btn-default')) !!}</th>
        </tfoot>
        <tbody>
            @foreach( $routes as $route )
                <tr>
                    <td/>
                    <td><a href="{{ route('routes.show', $route->slug)}}">{{ $route->name }}</a></td>
                    <td>{{ $route->distance }}</td>
                    <td>{{ $route->lon_start }} - {{ $route->lat_start }}</td>
                    <td>{{ $route->lon_finish }} - {{ $route->lat_finish }}</td>
                    <td>{{ $route->rating }} / 5</td>
                    <td>
                        <div class="btn-group" role="group">
                            {!! Form::open(array('class'=>'form-inline', 'method'=>'DELETE', 'route'=> array('routes.destroy', $route->slug))) !!}
                            {!! link_to_route('routes.edit', ucfirst(trans('app.edit')), array($route->slug), array('class' => 'btn btn-default')) !!}
                            {!! Form::submit(ucfirst(trans('app.delete')),array('class' => 'btn btn-default')) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection