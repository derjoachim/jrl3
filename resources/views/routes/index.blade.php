<!-- /resources/views/routes/index.blade.php -->
@extends('app')

@section('content')
<h2>Standaardroutes</h2>
@if( !$routes->count() ) 
<div class="alert alert-info">Geen standaardroutes gedefinieerd</div>
@else
<div class="row-fluid">
    <table class="table table-condensed table-striped">
        <thead>
            <th></th>
            <th>Naam</th>
            <th>Afstand</th>
            <th>Start</th>
            <th>Finish</th>
            <th>Waardering</th>
            <th></th>
        </thead>
        <tfoot>
            <th colspan='6'>&nbsp;</th>
            <th>{!! link_to_route('routes.create', 'Create Route',array(),array('class' => 'btn btn-primary')) !!}</th>
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
                            {!! link_to_route('routes.edit','Edit', array($route->slug), array('class' => 'btn btn-info')) !!}
                            {!! Form::submit('Delete',array('class' => 'btn btn-danger')) !!}
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