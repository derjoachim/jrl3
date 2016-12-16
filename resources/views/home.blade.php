@extends('app')

@section('content')
<div class="page-header">
    <h1>{{ ucfirst(trans('app.home')) }}&nbsp;<small>{{ trans('jrl.welcome_to_jrl') }}</small></h1>
</div>
<!--<div class="row">
    <div class="col-sm-4 col-md-4">TODO Number of workouts</div>
    <div class="col-sm-4 col-md-4">TODO Number of kilometers</div>
    <div class="col-sm-4 col-md-4">TODO Number of blah</div>
</div>-->
<div class="row">
    <div class="col-sm-6 col-md-6">
        <h3>{{ucfirst(trans('jrl.latest_workouts'))}}</h3>
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
        <h3>{{ucfirst(trans('jrl.favorite_routes'))}}</h3>
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
<div class="row">
    <div class="col-sm-3 col-md-3"><a href="https://strava.com/" target="_blank">
        <img src="{{ asset('/img/api_logo_pwrdBy_strava_stack_light.png') }}" style="width:160px"/>
    </a></div>
    <div class="col-sm-3 col-md-3"><a href="https://darksky.net/poweredby" target="_blank">
        <img src="{{ asset('/img/poweredby.png') }}" style="width:160px"/>
    </a></div>
    <div class="col-sm-3 col-md-3">&nbsp;</div>
    <div class="col-sm-3 col-md-3">&nbsp;</div>
</div>
<div></div>
@endsection
