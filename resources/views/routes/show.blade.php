@extends('app')
 
@section('content')
@if ($route->lon_start && $route->lat_start)
<script type="text/javascript" defer>
    $(document).ready(function() {
	AddGMToHead();
        setTimeout(function() {drawMap({{ $route->lat_start }}, {{ $route->lon_start }},'map_canvas');},700);
    });
</script>
@endif
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="page-header">
            <h2>
                {{ $route->name }}
            </h2>
            <h3>{{ $route->distance }} kilometer</h3>    
        </div>
    </div>
    <div class="col-lg-12">
        {!! $route->description !!}
    </div>
    @if ( $route->lon_start && $route->lat_start )
        <div class="col-lg-3">
            <h3>Start coordinates</h3>
            <dl>
                <dt>longitude</dt>
                <dd>{{ $route->lon_start }}</dd>
                <dt>latitude:</dt>
                <dd>{{ $route->lat_start }}</dd>
            </dl>
            <h3>Finish coordinates</h3>
            <dl>
                <dt>longitude</dt>
                    <dd>{{ $route->lon_finish }}</dd>
                <dt>latitude:</dt>
                <dd>{{ $route->lat_finish }}</dd>
            </dl>
         </div>
        <div class="col-lg-9" style="height: 400px;" id="map_canvas"></div>
    @else
        <div class="col-lg-12"><div class="alert alert-info">Geen co&ouml;rdinaten bekend</div></div>
    @endif        
    <div class="col-lg-12">
        {!! link_to_route('routes.edit','Edit', array($route->slug), array('class' => 'btn btn-info')) !!}
    </div>
</div>
@endsection