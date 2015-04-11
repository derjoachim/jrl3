<script type="text/javascript" defer>
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
<div class="row-fluid">
    <div class="col-lg-3">
        <div class="form-group">
            {!! Form::label('name', 'Naam:',['class' => 'control-label']) !!}
            {!! Form::text('name',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('distance', 'Afstand:',['class' => 'control-label']) !!}
            {!! Form::text('distance',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('rating', 'Waardering:',['class' => 'control-label']) !!}
            {!! Form::select('rating',[1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], 
            3, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-3">
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
    <div class="col-lg-6" id="map_canvas" style="min-height: 400px;">
    </div>
</div>
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('description', 'Omschrijving:',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor']) !!}
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
        </div>            
    </div>
</div>
