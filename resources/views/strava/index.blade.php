<!-- /resources/strava/workouts/index.blade.php -->
@extends('app')

@section('content')
<h2>Laatste Strava-entries</h2>
@if( !count($workouts) ) 
<div class="alert alert-info">Geen workouts gevonden binnen Strava.</div>
@else
<div class="row-fluid">
    <table class="table table-condensed table-striped">
        <thead>
            <th>Datum</th>
            <th>Naam</th>
            <th>Afstand</th>
            <th>Eindtijd</th>
            <th></th>
        </thead>
        <tfoot>
            <th colspan='5'>&nbsp;</th>
        </tfoot>
        <tbody>
            @foreach( $workouts as $workout )
                <tr>
                    <td>{{ $workout['date'] }}
                    <td>{{ $workout['name'] }}</td>
                    <td>{{ $workout['distance'] }} </td>
                    <td>{{ $workout['time'] }}</td>
                    <td>
                        @if ( !$workout['workout_id'] )
                        <div class="btn-group" role="group">
                            <a class="btn btn-small btn-info" href="{{ action("StravaController@import",array('id' => $workout['id'])) }}">
                                <i class="glyphicon glyphicon-import"></i>&nbsp;Import</a>
                        </div>
                        @else
                        <p>&nbsp;</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection