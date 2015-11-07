@extends('app')
 
@section('content')
@if ($route->lon_start && $route->lat_start)
<script type="text/javascript" defer>
    $(document).ready(function() {
        AddGMToHead();
        
        setTimeout(function() {drawMap(new Array(), 'map_canvas');},700);
    });
</script>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <h2>
                {{ $route->name }}
            </h2>
            <h3>{{ $route->distance }} {{ trans('jrl.kilometers') }}</h3>    
        </div>
    </div>
    <div class="col-lg-12">
        {!! $route->description !!}
    </div>
    @if ( $route->lon_start && $route->lat_start )
        <div class="col-lg-3">
            <h3>{{ ucfirst(trans('jrl.start')) }}</h3>
            <dl>
                <dt>{{ ucfirst(trans('jrl.longitude')) }}</dt>
                <dd>{{ $route->lon_start }}</dd>
                <dt>{{ ucfirst(trans('jrl.latitude')) }}</dt>
                <dd>{{ $route->lat_start }}</dd>
            </dl>
            <h3>{{ ucfirst(trans('jrl.finish')) }}</h3>
            <dl>
                <dt>{{ ucfirst(trans('jrl.longitude')) }}</dt>
                <dd>{{ $route->lon_finish }}</dd>
                <dt>{{ ucfirst(trans('jrl.latitude')) }}</dt>
                <dd>{{ $route->lat_finish }}</dd>
            </dl>
        </div>
        <input type="hidden" id="lat_start" value="{{ $route->lat_start }}" />
        <input type="hidden" id="lon_start" value="{{ $route->lon_start }}" />
        <input type="hidden" id="lat_finish" value="{{ $route->lat_finish }}" />
        <input type="hidden" id="lon_finish" value="{{ $route->lon_finish }}" />

        <div class="col-lg-9" style="height: 400px;" id="map_canvas"></div>
    @else
        <div class="col-lg-12"><div class="alert alert-info">{{ trans('jrl.no_coords') }}</div></div>
    @endif        
    <div class="col-lg-12">
        {!! link_to_route('routes.edit',ucfirst(trans('app.edit')), array($route->slug), array('class' => 'btn btn-info')) !!}
    </div>
</div>
@endsection