<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
    <div class="mdl-cell mdl-cell--12-col">
        <div class="mdl-textfield mdl-js-textfield  mdl-textfield--floating-label">
            {!! Form::text('name',null,['class' => 'mdl-textfield__input']) !!}
            {!! Form::label('name', ucfirst(trans('jrl.name')).':',['class' => 'mdl-textfield__label']) !!}
            <span class="mdl-textfield__error">{{ trans('validation.required') }}</span>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--6-col">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            {!! Form::label('distance', ucfirst(trans('jrl.distance')).':',['class' => 'mdl-textfield__label']) !!}
            {!! Form::text('distance',null,['class' => 'mdl-textfield__input', 'pattern' => '-?[0-9]*(\.[0-9]+)?']) !!}
            <span class="mdl-textfield__error">{{ trans('validation.numeric') }}</span>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--6-col">
        <div class="mdl-textfield--floating-label">{{ ucfirst(trans('jrl.grade')) }}:</div>
        <div class="mdl-textfield mdl-js-textfield">
            <input class="mdl-slider mdl-js-slider" type="range" id="rating" name="rating" min="1" max="5" value="{{ $rating }}" tabindex="0">
        </div>
    </div>
</section>

<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
    <div class="mdl-card mdl-cell mdl-cell--12-col">

        <div class="mdl-textfield mdl-js-textfield full-width">
            {!! Form::textarea('description', null, ['class' => 'mdl-textfield__input ckeditor full-width', 
            'type'=>"text", 'rows'=> 8, 'id' => 'description']) !!}
            {!! Form::label('description', ucfirst(trans('jrl.description')).':',['class' => 'mdl-textfield__label']) !!}
        </div>
    </div>
        <!--<div id="map_canvas" style='min-height: 200px;background-color: #00bfa5;min-width: 300px;'></div>-->
    {!! Form::hidden('lon_start', null, ['id'=>'lon_start']) !!}
    {!! Form::hidden('lat_start', null, ['id'=>'lat_start']) !!}
    {!! Form::hidden('lon_finish', null, ['id'=>'lon_finish']) !!}
    {!! Form::hidden('lat_finish', null, ['id'=>'lat_finish']) !!}
</section>

{!! Form::submit(ucfirst($submit_text), ['class'=>'mdl-button mdl-js-button mdl-button--raised 
    mdl-js-ripple-effect mdl-button--colored', 'id' => 'savebtn' ]) !!}
<script type="text/javascript">
    $(document).ready(function() {
        if(!($('#lat_start').val()) || !($('#lon_start').val())) {
            getcoords();
        }
    	AddGMToHead();
        $("#lon_start").on("change", function(event) {
            drawMap(new Array(),'map_canvas');
        });
        $("#lat_start").on("change", function(event) {
            drawMap(new Array(),'map_canvas');
        });
        
    	setTimeout(function() {drawMap(new Array(), 'map_canvas');},700);
    });

</script>