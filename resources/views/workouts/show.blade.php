@extends('app')
 
@section('content')
@if ($workout->lon_start && $workout->lat_start)
<script type="text/javascript" defer>
    $(document).ready(function() {
	AddGMToHead();
        setTimeout(function() {drawMap({{ $workout->lat_start }}, {{ $workout->lon_start }},'map_canvas');},700);
    });
</script>
@endif
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="page-header">
            <h2>
                {{ $workout->name }}
            </h2>
            <h3>{{ $workout->distance }} kilometer - {{ $t }}</h3>    
        </div>
    </div>
    <div class="col-lg-12">
        {!! $workout->description !!}
    </div>
    @if ( $workout->lon_start && $workout->lat_start )
        <div class="col-lg-3">
            <h3>Start</h3>
            <dl>
                <dt>Lengtegraad</dt>
                <dd>{{ $workout->lon_start }}</dd>
                <dt>Breedtegraad</dt>
                <dd>{{ $workout->lat_start }}</dd>
            </dl>
            <h3>Finish</h3>
            <dl>
                <dt>Lengtegraad</dt>
                <dd>{{ $workout->lon_finish }}</dd>
                <dt>Breedtegraad</dt>
                <dd>{{ $workout->lat_finish }}</dd>
            </dl>
         </div>
        <div class="col-lg-9" style="height: 400px;" id="map_canvas"></div>
    @else
        <div class="col-lg-12"><div class="alert alert-info">Geen co&ouml;rdinaten bekend</div></div>
    @endif        
    <div class="col-lg-12">
        {!! link_to_route('workouts.edit','Bewerk', array($workout->slug), array('class' => 'btn btn-info')) !!}
    </div>
</div>
@endsection