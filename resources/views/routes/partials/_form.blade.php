<script type="text/javascript" defer>
    $(document).ready(function() {
	AddGMToHead();
	$("#lon_start").on("change", function(event) {
        drawMap(new Array(),'map_canvas');
	});
	$("#lat_start").on("change", function(event) {
        drawMap(new Array(),'map_canvas');
	});
	if(!($('#lat_start').val()) || !($('#lon_start').val())) {
        getcoords();
 	}
	setTimeout(function() {drawMap(new Array(),'map_canvas');},700);
    });
</script>
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
            <!--{ ! ! Form::label('rating', ucfirst(trans('jrl.grade')).':',['class' => 'mdl-textfield__label']) ! ! }-->
            <input class="mdl-slider mdl-js-slider" type="range" id="rating" min="1" max="5" value="{{ $rating }}" tabindex="0">
            <!--{ ! ! Form::selectRange('rating', 1, 5, $rating,['class' => 'mdl-slider mdl-js-slider']) ! ! }-->
        </div>
    </div>
</section>

<section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
    <div class="mdl-card mdl-cell mdl-cell--12-col">

        <div class="form-group">
            {!! Form::label('description', ucfirst(trans('jrl.description')).':',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor']) !!}
        </div>
    </div>
</section>

<section>
            {!! Form::submit(ucfirst($submit_text), ['class'=>'btn btn-primary']) !!}
</section>