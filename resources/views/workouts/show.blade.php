@extends('app')
 
@section('content')
@if ($workout->lon_start && $workout->lat_start)
<script type="text/javascript" defer>
    $(document).ready(function() {
        AddGMToHead();
        var arrWps = getWaypoints({{ $workout->id }});
        setTimeout(function() {drawMap(arrWps,'map_canvas');},700);
    });
</script>
@endif
<div class="row">
    <div class="col-lg-9">
        <div class="page-header">
            <h2>
                {{ $workout->name }}
            </h2>
            <h3>{{ $workout->distance }} {{ trans('jrl.kilometers')}} 
                @if ( $workout->finished == '1')
                - {{ $t }}
                @endif
            </h3>    
        </div>
    </div>
    <div class="col-lg-3">
        <div class="btn-group">
            @unless (is_null($prev))
            <a href="{{ route('workouts.show', $prev)}}" class="btn btn-default">
                <i class="icon glyphicon glyphicon-arrow-left"></i>
                &nbsp;{{ trans('pagination.previous') }}
            </a>
            @endunless
            {!! link_to_route('workouts.edit', ucfirst(trans('app.edit')), array($workout->slug), array('class' => 'btn btn-default')) !!}
            @unless (is_null($next))
            <a href="{{ route('workouts.show', $next)}}"  class="btn btn-default">
                {{ trans('pagination.next') }}&nbsp;
                <i class="icon glyphicon glyphicon-arrow-right"></i>
            </a>
            @endunless
        </div>
    </div>

    <div class="col-lg-6">
        <h3>{{ ucfirst(trans('jrl.general_data')) }}</h3>
        <dl>
            <dt>{{ ucfirst(trans('app.date')) }}:</dt>
            <dd>{{ $workout->date->format('d-m-Y') }}</dd>
            <dt>{{ ucfirst(trans('app.date')) }}:</dt>
            <dd>{{ $workout->start_time }}</dd>
            @unless ( is_null($route) ) 
                <dt>{{ ucfirst(trans_choice('jrl.routes',2)) }}:</dt>
                <dd>{{ $route }}</dd>
            @endunless
            <dt>{{ ucfirst(trans('jrl.finish_time')) }}:</dt>
            <dd>{{ $t }}</dd>
            <dt>{{ ucfirst(trans('jrl.distance')) }}:</dt>
            <dd>{{ $workout->distance }}</dd>
        </dl>
    </div>
    <div class="col-lg-3">
        <h3>{{ ucfirst(trans('jrl.weather')) }}</h3>
        <dl>
            <dt>{{ ucfirst(trans('jrl.temperature')) }}:</dt>
            <dd>{{ $workout->temperature }}</dd>
            <dt>{{ ucfirst(trans('jrl.humidity')) }}:</dt>
            <dd>{{ $workout->humidity }}</dd>
            <dt>{{ ucfirst(trans('jrl.wind_speed')) }}:</dt>
            <dd>{{ $workout->wind_speed }}</dd>
            <dt>{{ ucfirst(trans('jrl.wind_direction')) }}:</dt>
            <dd>{{ $workout->wind_direction }}</dd>
            <dt>{{ ucfirst(trans('jrl.pressure')) }}:</dt>
            <dd>{{ $workout->pressure }}</dd>
        </dl>
    </div>
    <div class="col-lg-3">
        <h3>{{ ucfirst(trans('jrl.vibe')) }}</h3>
        <dl>
            <dt>{{ ucfirst(trans('jrl.finished')) }}:</dt>
            <dd>@if ($workout->finished == 1)
            {{ ucfirst(trans('app.yes')) }}
            @else
            {{ ucfirst(trans('app.no')) }}
            @endif
            </dd>
            <dt>{{ ucfirst(trans('jrl.mood')) }}:</dt>
            <dd>{{ $workout->mood }}</dd>
            <dt>{{ ucfirst(trans('jrl.health')) }}</dt>
            <dd>{{ $workout->health }}</dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <h3>{{ ucfirst(trans('jrl.description')) }}</h3>
        {!! $workout->description !!}
    </div>
    @if ( $workout->lon_start && $workout->lat_start )
        <div class="col-lg-2">
            <h3>{{ ucfirst(trans('jrl.start')) }}</h3>
            <dl>
                <dt>{{ ucfirst(trans('jrl.longitude')) }}</dt>
                <dd>{{ $workout->lon_start }}</dd>
                <dt>{{ ucfirst(trans('jrl.latitude')) }}</dt>
                <dd>{{ $workout->lat_start }}</dd>
            </dl>
            @if ($workout->lon_finish && $workout->lat_finish)
            <h3>{{ ucfirst(trans('jrl.finish')) }}</h3>
            <dl>
                <dt>{{ ucfirst(trans('jrl.longitude')) }}</dt>
                <dd>{{ $workout->lon_finish }}</dd>
                <dt>{{ ucfirst(trans('jrl.latitude')) }}</dt>
                <dd>{{ $workout->lat_finish }}</dd>
            </dl>
            @endif
        </div>
        <input type="hidden" id="lat_start" value="{{ $workout->lat_start }}" />
        <input type="hidden" id="lon_start" value="{{ $workout->lon_start }}" />
        <input type="hidden" id="lat_finish" value="{{ $workout->lat_finish }}" />
        <input type="hidden" id="lon_finish" value="{{ $workout->lon_finish }}" />
        <div class="col-lg-6" style="height: 300px;" id="map_canvas"></div>
    @else
        <div class="col-lg-8"><div class="alert alert-info">{{ trans('jrl.no_known_coordinates')}}</div></div>
    @endif        
</div>
@endsection