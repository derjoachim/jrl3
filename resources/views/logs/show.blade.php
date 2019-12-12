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
    <div class="col-lg-6">
        <h4></h4>
        <dl>
            @unless ( is_null($pr))
            <dt>{{ ucfirst(trans('jrl.current_pr')) }}:</dt>
            <dd>{{ $pr }}</dd>
            @endunless
            <dt>{{ ucfirst(trans('jrl.description')) }}:</dt>
            <dd>{!! $route->description !!}</dd>
        </dl>
    </div>
    <div class="col-lg-6">
        <h4>{{ ucfirst(trans('jrl.latest_workouts')) }}</h4>
            <table class="table table-responsive table-condensed table-striped">
            <thead>
                <tr>
                    <th>{{ ucfirst(trans('app.date')) }}</th>
                    <th>{{ ucfirst(trans('jrl.name')) }}</th>
                    <th>{{ ucfirst(trans('jrl.finish_time')) }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($latest_workouts as $workout)
                <tr>
                    <td>{{ date('d-m-Y', strtotime($workout->date)) }}
                    <td><a href="{{ route('workouts.show', $workout->slug)}}">{{ $workout->name }}</a></td>
                    <td>{{ $workout->getTime() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
          <div id="map_canvas_lg"></div>
        </div>
    </div>
  </div>
</div>
@if ( $route->lon_start && $route->lat_start)

<script type="text/javascript">
$(document).ready(function(){
});

$('#myModal').on('show.bs.modal', function (e) {
    setTimeout(function() {drawMap(new Array(), 'map_canvas_lg');},700);
});    
</script>
@endif

@endsection

