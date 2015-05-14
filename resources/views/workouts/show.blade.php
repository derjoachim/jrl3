@extends('app')
 
@section('content')
@if ($workout->lon_start && $workout->lat_start)
<script type="text/javascript" defer>
    $(document).ready(function() {
	AddGMToHead();eerste route
        setTimeout(function() {drawMap({{ $workout->lat_start }}, {{ $workout->lon_start }},'map_canvas');},700);
    });
</script>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <h2>
                {{ $workout->name }}
            </h2>
            <h3>{{ $workout->distance }} kilometer 
                @if ( $workout->finished == '1')
                - {{ $t }}
                @endif
            </h3>    
        </div>
    </div>
    <div class="col-lg-6">
        <h3>Algemene Gegevens</h3>
        <dl>
            <dt>Datum:</dt>
            <dd>{{ $workout->date->format('d-m-Y') }}</dd>
            <dt>Tijd:</dt>
            <dd>{{ $workout->start_time }}</dd>
            @unless ( is_null($route) ) 
                <dt>Route:</dt>
                <dd>{{ $route }}</dd>
            @endunless
            <dt>Finish tijd:</dt>
            <dd>{{ $t }}</dd>
            <dt>Afstand:</dt>
            <dd>{{ $workout->distance }}</dd>
        </dl>
    </div>
    <div class="col-lg-3">
        <h3>Weer</h3>
        <dl>
            <dt>Temperatuur:</dt>
            <dd>{{ $workout->temperature }}</dd>
            <dt>Luchtdruk:</dt>
            <dd>{{ $workout->pressure }}</dd>
            <dt>Vochtigheid:</dt>
            <dd>{{ $workout->humidity }}</dd>
            <dt>Windsnelheid:</dt>
            <dd>{{ $workout->wind_speed }}</dd>
            <dt>Windrichting:</dt>
            <dd>{{ $workout->wind_direction }}</dd>
        </dl>
    </div>
    <div class="col-lg-3">
        <h3>Vibe</h3>
        <dl>
            <dt>Voltooid:</dt>
            <dd>@if ($workout->finished == 1)
            Ja
            @else
            Nee
            @endif
            </dd>
            <dt>Stemming:</dt>
            <dd>{{ $workout->mood }}</dd>
            <dt>Gezondheid</dt>
            <dd>{{ $workout->health }}</dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <h3>Beschrijving</h3>
        {!! $workout->description !!}
    </div>
    @if ( $workout->lon_start && $workout->lat_start )
        <div class="col-lg-2">
            <h3>Start</h3>
            <dl>
                <dt>Lengtegraad</dt>
                <dd>{{ $workout->lon_start }}</dd>
                <dt>Breedtegraad</dt>
                <dd>{{ $workout->lat_start }}</dd>
            </dl>
            @if ($workout->lon_finish && $workout->lat_finish)
            <h3>Finish</h3>
            <dl>
                <dt>Lengtegraad</dt>
                <dd>{{ $workout->lon_finish }}</dd>
                <dt>Breedtegraad</dt>
                <dd>{{ $workout->lat_finish }}</dd>
            </dl>
            @endif
        </div>
        <div class="col-lg-6" style="height: 300px;" id="map_canvas"></div>
    @else
        <div class="col-lg-8"><div class="alert alert-info">Geen co&ouml;rdinaten bekend</div></div>
    @endif        
    <div class="col-lg-12">
        {!! link_to_route('workouts.edit','Bewerk', array($workout->slug), array('class' => 'btn btn-info')) !!}
    </div>
</div>
@endsection