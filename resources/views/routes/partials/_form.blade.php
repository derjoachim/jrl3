    <div class="col-lg-3">
        <div class="btn-group" role="group" >
            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-save"></i> 
                {{ ucfirst(trans('app.save')) }}
            </button>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-lg-9">
        <div class="form-group">
            {!! Form::label('name', ucfirst(trans('jrl.name')).':',['class' => 'control-label']) !!}
            {!! Form::text('name',null,['class' => 'form-control input-lg']) !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            {!! Form::label('distance', ucfirst(trans('jrl.distance')).':',['class' => 'control-label']) !!}
            {!! Form::text('distance',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('rating', ucfirst(trans('jrl.grade')).':',['class' => 'control-label']) !!}
            {!! Form::selectRange('rating', 1, 5, $rating,['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="form-group">
            {!! Form::label('description', ucfirst(trans('jrl.description')).':',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor', 'rows' => '5']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6" id="map_canvas" style="min-height: 400px;">
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            {!! Form::label('lon_start', ucfirst(trans('jrl.longitude')).' '.trans('jrl.start').':',['class' => 'control-label']) !!}
            {!! Form::text('lon_start',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lat_start', ucfirst(trans('jrl.latitude')).' '.trans('jrl.start').':',['class' => 'control-label']) !!}
            {!! Form::text('lat_start',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            {!! Form::label('lon_finish', ucfirst(trans('jrl.longitude')).' '.trans('jrl.finish').':',['class' => 'control-label']) !!}
            {!! Form::text('lon_finish',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lat_finish', ucfirst(trans('jrl.latitude')).' '.trans('jrl.finish').':',['class' => 'control-label']) !!}
            {!! Form::text('lat_finish',null,['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<script type="text/javascript">
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