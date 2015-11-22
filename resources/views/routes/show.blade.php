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
<div class="mdl-layout__tab-panel is-active" id="overview">
    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
        <header id="map_canvas" class="section__play-btn mdl-cell mdl-cell--3-col-desktop mdl-cell--2-col-tablet mdl-cell--4-col-phone mdl-color--teal-100 mdl-color-text--white">
            <i class="material-icons">map</i>
        </header>
        <div class="mdl-card mdl-cell mdl-cell--9-col-desktop mdl-cell--6-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card__supporting-text">
                <h4>{{ $route->name }}</h4>
                <h5>{{ $route->distance }} {{ trans('jrl.kilometers') }}</h5>
                @if ( $route->lon_start && $route->lat_start )
                    <input type="hidden" id="lat_start" value="{{ $route->lat_start }}" />
                    <input type="hidden" id="lon_start" value="{{ $route->lon_start }}" />
                    <input type="hidden" id="lat_finish" value="{{ $route->lat_finish }}" />
                    <input type="hidden" id="lon_finish" value="{{ $route->lon_finish }}" />
                @endif
                <h6>{{ ucfirst(trans('jrl.grade')) }}</h6>
                @for ($i=1; $i<=5; $i++)
                    <i class="material-icons" style="font-size: 1em;">
                    @if ($i > $route->rating) 
                        star_border
                    @else
                        star
                    @endif
                    </i>                        
                @endfor
            </div>
        </div>
        <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btn1">
            <i class="material-icons">more_vert</i>
        </button>
        <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right" for="btn1">
            <li class="mdl-menu__item"><a href="{{ URL::route('routes.create')}}">{{ ucfirst(trans('app.edit')) }}</a></li>
            <li class="mdl-menu__item"><a href="#" onclick="$('#delete-form').submit();">
                        {!! Form::open(array('id' => 'delete-form', 'method'=>'DELETE', 'route'=> array('routes.destroy', $route->slug))) !!}
                        <button class="hidden" type="submit" id="btn-delete">Delete</button>
                        {!! Form::close() !!}
                        {{ ucfirst(trans('app.delete')) }}</a></li>
        </ul>
    </section>
    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
        <div class="mdl-card mdl-cell mdl-cell--12-col">
          <div class="mdl-card__supporting-text">
            {!! $route->description !!}
          </div>
        </div>
    </section>
    </div>
   <!--{ ! ! link_to_route('routes.edit',ucfirst(trans('app.edit')), array($route->slug), array('class' => 'btn btn-info')) ! ! }-->
</div>
@endsection