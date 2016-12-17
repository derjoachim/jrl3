@extends('app')

@section('content')
<div class="page-header">
    <h1>{{ ucfirst(trans('app.home')) }}&nbsp;<small>{{ trans('jrl.welcome_to_jrl') }}</small></h1>
</div>
<div class="row">
    <div class="col-sm-4 col-md-4">
        <h4>Aantal workouts</h4>
        <ul class="list-unstyled">
            <li>Afgelopen week: <span class="badge">{{ $cumulative_workouts['by_week'] }}</span></li>
            <li>Afgelopen maand: <span class="badge">{{ $cumulative_workouts['by_month'] }}</span></li>
            <li>Afgelopen jaar: <span class="badge">{{ $cumulative_workouts['by_year'] }}</span></li>
        </ul>
    </div>
    <div class="col-sm-4 col-md-4">
        <h4>Aantal kilometers</h4>
        <ul class="list-unstyled">
            <li>Afgelopen week: <span class="badge">{{ $cumulative_distance['by_week'] }}</span></li>
            <li>Afgelopen maand: <span class="badge">{{ $cumulative_distance['by_month'] }}</span></li>
            <li>Afgelopen jaar: <span class="badge">{{ $cumulative_distance['by_year'] }}</span></li>
        </ul>
    </div>
    <div class="col-sm-4 col-md-4">
        <h4>Totalen</h4>
        <ul class="list-unstyled">
            <li>Totale workouts: <span class="badge">{{ $grand_totals['num_workouts'] }}</span></li>
            <li>Totale afstand: <span class="badge">{{ $grand_totals['total_distance'] }}</span></li>
            <li>Aantal standaardroutes: <span class="badge">{{ $grand_totals['num_routes'] }}</span></li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6">
        <h4>{{ucfirst(trans('jrl.latest_workouts'))}}</h4>
        <table class="table table-responsive table-condensed table-striped">
            <thead>
                <tr>
                    <th>{{ ucfirst(trans('app.date')) }}</th>
                    <th>{{ ucfirst(trans('jrl.name')) }}</th>
                    <th>{{ ucfirst(trans_choice('jrl.routes',1)) }}</th>
                    <th>{{ ucfirst(trans('jrl.distance')) }}</th>
                    <th>{{ ucfirst(trans('jrl.finish_time')) }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($latest_workouts as $workout)
                <tr>
                    <td>{{ date('d-m-Y', strtotime($workout->date)) }}
                    <td><a href="{{ route('workouts.show', $workout->slug)}}">{{ $workout->name }}</a></td>
                    <td>{{ $workout->route['name'] }}</td>
                    <td>{{ $workout->distance }} </td>
                    <td>{{ $workout->getTime() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-6 col-md-6">
        <h4>{{ucfirst(trans('jrl.favorite_routes'))}}</h4>
        <table class="table table-responsive table-condensed table-striped">
            <thead>
                <tr>
                    <th>{{ ucfirst(trans('jrl.name')) }}</th>
                    <th>{{ ucfirst(trans('jrl.distance')) }}</th>
                    <th>{{ ucfirst(trans('jrl.grade')) }}</th>
                    <th>{{ ucfirst(trans('jrl.quantity')) }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($favorite_routes as $route)
                <tr>
                    <td><a href="{{ route('routes.show', $route->slug)}}">{{ $route->name }}</a></td>
                    <td>{{ $route->distance }}</td>
                    <td>{{ $route->rating }}</td>
                    <td>{{ $route->workouts_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
</div>
<div>&nbsp;</div>
@endsection
