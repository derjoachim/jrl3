@extends('app')
 
@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="page-header">
            <h2>
                {{ $route->name }}
                <small>{{ $route->distance }} {{ trans('jrl.kilometers') }}</small>
            </h2>
            <div>
                @for ( $iR =1; $iR <= 5; $iR++ )
                    <i class="glyphicon {{ $iR <= $route->rating ? 'glyphicon-heart' : 'glyphicon-heart-empty'}}"></i>
                @endfor
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="btn-group" role="group" >
            <a href="{{ route('routes.edit', ['slug' => $route->slug]) }}" class="btn btn-default" role="button">
                <i class="glyphicon glyphicon-pencil"></i> {{ ucfirst(trans('app.edit')) }}
            </a>
            @if ( $route->lon_start && $route->lat_start )
            <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bs-modal-map-lg">
                <i class="glyphicon glyphicon-map-marker"></i> {{ ucfirst(trans('jrl.show_map')) }}
            </button>
            @endif
        </div>
    </div>
    <div class="col-lg-8">
        {!! $route->description !!}
    </div>
    @if ( $route->lon_start && $route->lat_start )
        <input type="hidden" id="lat_start" value="{{ $route->lat_start }}" />
        <input type="hidden" id="lon_start" value="{{ $route->lon_start }}" />
        <input type="hidden" id="lat_finish" value="{{ $route->lat_finish }}" />
        <input type="hidden" id="lon_finish" value="{{ $route->lon_finish }}" />
    @endif
</div>
<div class="modal fade bs-modal-map-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div id="map_canvas" style="height: 550px;"></div>
        </div>
    </div>
  </div>
</div>
@if ( $route->lon_start && $route->lat_start)

<script type="text/javascript">
$(document).ready(function(){
    AddGMToHead();
});

$('#myModal').on('show.bs.modal', function (e) {
    // do something...
    setTimeout(function() {drawMap(new Array(), 'map_canvas');},700);
});    
</script>
@endif

@endsection

