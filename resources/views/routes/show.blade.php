@extends('app')
 
@section('content')
    <h2>
        {{ $route->name }}
    </h2>
<h3>{{ $route->distance }} kilometer</h3>
<p>
    {{ $route->description }}
</p>

@if ( $route->lon && $route->lat )
<dl>
    <dt>longitude</dt>
    <dd>{{ $route->lon }}</dd>
    <dt>latitude:</dt>
    <dd>{{ $route->lat }}</dd>
</dl>
@else
<p>Geen co&ouml;rdinaten bekend</p>
@endif
@endsection