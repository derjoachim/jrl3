<script type="text/javascript" defer>
    /*
     * @TODO: Retrieve weather data
     */
    $(document).ready(function() {
	AddGMToHead();
	$("#lon_start").on("change", function(event) {
            drawMap($('#lat_start').val(),$('#lon_start').val(),'map_canvas');
	});
	$("#lat_start").on("change", function(event) {
            drawMap($('#lat_start').val(),$('#lon_start').val(),'map_canvas');
	});
	if(!($('#lat_start').val()) || !($('#lon_start').val())) {
            getcoords();
 	}
	setTimeout(function() {drawMap($('#lat_start').val(),$('#lon_start').val(),'map_canvas');},700);
    });
</script>
<div class="row">
    <div class="col-lg-3">
        <h3>Algemene gegevens</h3>
        <div class="form-group">
            {!! Form::label('date', 'Datum:',['class' => 'control-label']) !!}
            {!! Form::text('date',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('start_time', 'Tijd:',['class' => 'control-label']) !!}
            {!! Form::text('start_time',null,['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('name', 'Naam:',['class' => 'control-label']) !!}
            {!! Form::text('name',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-3">
        <h3>Tijd en afstand</h3>
        <div class="form-group">
            {!! Form::label('route_id', 'Route:',['class' => 'control-label']) !!}
            {!! Form::select('route_id',[0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], 
            0, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('distance', 'Afstand:',['class' => 'control-label']) !!}
            {!! Form::text('distance',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('time_in_seconds', 'Eindtijd:',['class' => 'control-label']) !!}
            {!! Form::text('time_in_seconds',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class='col-lg-3'>
        <h3>Weer</h3>
        <div class="form-group">
            {!! Form::label('temperature', 'Temperatuur:',['class' => 'control-label']) !!}
            {!! Form::text('temperature',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('pressure', 'Luchtdruk:',['class' => 'control-label']) !!}
            {!! Form::text('pressure',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('wind_speed', 'Windsnelheid:',['class' => 'control-label']) !!}
            {!! Form::text('wind_speed',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('wind_direction', 'Windrichting:',['class' => 'control-label']) !!}
            {!! Form::text('wind_direction',null,['class' => 'form-control']) !!}
        </div>        
    </div>
    <div class="col-lg-3">
        <h3>Vibe</h3>
        <div class="form-group">
            {!! Form::label('finished', 'Voltooid:',['class' => 'control-label']) !!}
            {!! Form::checkbox('finished',null) !!}
        </div>
        <div class="form-group">
            {!! Form::label('mood', 'Stemming:',['class' => 'control-label']) !!}
            {!! Form::selectRange('mood', 1, 5, 3, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('health', 'Gezondheid:',['class' => 'control-label']) !!}
            {!! Form::selectRange('health', 1, 5, 3, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h3>Coole maps zaken</h3>
        <div class="form-group">
            {!! Form::label('lon_start', 'Lengtegraad start:',['class' => 'control-label']) !!}
            {!! Form::text('lon_start',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lat_start', 'Breedtegraad start:',['class' => 'control-label']) !!}
            {!! Form::text('lat_start',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lon_finish', 'Lengtegraad finish:',['class' => 'control-label']) !!}
            {!! Form::text('lon_finish',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lat_finish', 'Breedtegraad finish:',['class' => 'control-label']) !!}
            {!! Form::text('lat_finish',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-9" id="map_canvas" style="min-height: 400px;"></div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('description', 'Omschrijving:',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
        </div>            
    </div>
</div>
