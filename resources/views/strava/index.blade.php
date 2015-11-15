<!-- /resources/strava/workouts/index.blade.php -->
@extends('app')

@section('content')
<h2>{{ ucfirst(trans('jrl.most_recent'))}} Strava-{{ trans_choice('jrl.entries',2) }}</h2>
@if( !count($workouts) ) 
<div class="alert alert-info">{{ trans('jrl.no_workouts_found') }}</div>
@else
<div class="row-fluid">
    <table class="table table-condensed table-striped">
        <thead>
            <th>{{ ucfirst(trans('app.date')) }}</th>
            <th>{{ ucfirst(trans('jrl.name')) }}</th>
            <th>{{ ucfirst(trans('jrl.distance')) }}</th>
            <th>{{ ucfirst(trans('jrl.finish_time')) }}</th>
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
                                <i class="glyphicon glyphicon-import"></i>&nbsp;{{ ucfirst(trans('app.import')) }}</a>
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