<!-- /resources/views/workouts/index.blade.php -->
@extends('app')

@section('content')
<h2>Workouts</h2>
@if( !$workouts->count() ) 
<div class="alert alert-info">Geen workouts gelogd. Klik {!! link_to_route('workouts.create', 'hier',array(),array()) !!} om een workout te loggen.</div>
@else
<div class="row-fluid">
    <table class="table table-condensed table-striped">
        <thead>
            <th>Datum</th>
            <th>Naam</th>
            <th>Route</th>
            <th>Afstand</th>
            <th>Eindtijd</th>
            <th></th>
        </thead>
        <tfoot>
            <th colspan='5'>&nbsp;</th>
            <th>{!! link_to_route('workouts.create', 'Nieuwe Workout',array(),array('class' => 'btn btn-primary')) !!}</th>
        </tfoot>
        <tbody>
            @foreach( $workouts as $workout )
                <tr>
                    <td>{{ $workout->date }}
                    <td><a href="{{ route('workouts.show', $workout->slug)}}">{{ $workout->name }}</a></td>
                    <td>{{ $workout->route_id }}</td>
                    <td>{{ $workout->distance }} </td>
                    <td>{{ $workout->time_in_seconds }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            {!! Form::open(array('class'=>'form-inline', 'method'=>'DELETE', 'route'=> array('workouts.destroy', $workout->slug))) !!}
                            {!! link_to_route('workouts.edit','Bewerk', array($workout->slug), array('class' => 'btn btn-info')) !!}
                            {!! Form::submit('Verwijder',array('class' => 'btn btn-danger')) !!}
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