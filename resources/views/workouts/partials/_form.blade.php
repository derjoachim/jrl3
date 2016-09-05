    <div class="col-lg-3">
        <div class="btn-group" role="group" >
            <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-save"></i> 
                {{ ucfirst(trans('app.save')) }}
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h3>{{ ucfirst(trans('jrl.general_data')) }}</h3>
        <div class="form-group">
            {!! Form::label('name', ucfirst(trans('jrl.name')) .':',['class' => 'control-label']) !!}
            {!! Form::text('name',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('date', ucfirst(trans('app.date')) .':',['class' => 'control-label']) !!}
            {!! Form::input('date','date',$date,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('start_time', ucfirst(trans('app.time')) .':',['class' => 'control-label']) !!}
            {!! Form::text('start_time',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <h3>{{ ucfirst(trans('app.time')) }} {{ trans('app.and') }} {{ trans('jrl.distance') }}</h3>
        <div class="form-group">
            {!! Form::label('route_id', ucfirst(trans_choice('jrl.routes',1)).':',['class' => 'control-label']) !!}
            {!! Form::select('route_id',$routes, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('distance', ucfirst(trans('jrl.distance')) .':',['class' => 'control-label']) !!}
            {!! Form::text('distance',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('time_in_seconds', ucfirst(trans('jrl.finish_time')) .':',['class' => 'control-label']) !!}
            {!! Form::text('time_in_seconds',(isset($t) ? $t : null),['class' => 'form-control']) !!}
        </div>
    </div>
    <div class='col-lg-12'>
        <h3>{{ ucfirst(trans('jrl.weather')) }}</h3>
        <a class="btn btn-warning" id="btn-weather"><i class="icon glyphicon glyphicon-cloud"></i> {{ ucfirst(trans('jrl.fetch')) }}</a>
        <div class="form-group">
            {!! Form::label('temperature', ucfirst(trans('jrl.temperature')).':',['class' => 'control-label']) !!}
            {!! Form::text('temperature',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('humidity', ucfirst(trans('jrl.humidity')).':',['class' => 'control-label']) !!}
            {!! Form::text('humidity',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('wind_speed', ucfirst(trans('jrl.wind_speed')).':',['class' => 'control-label']) !!}
            {!! Form::text('wind_speed',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('wind_direction', ucfirst(trans('jrl.wind_direction')).':',['class' => 'control-label']) !!}
            {!! Form::text('wind_direction',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('pressure', ucfirst(trans('jrl.pressure')).':',['class' => 'control-label']) !!}
            {!! Form::text('pressure',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <h3>{{ ucfirst(trans('jrl.vibe')) }}</h3>
        <div class="form-group">
            {!! Form::label('finished', ucfirst(trans('jrl.finished')).':',['class' => 'control-label']) !!}
            {!! Form::checkbox('finished', '1', true) !!}
        </div>
        <div class="form-group">
            {!! Form::label('mood', ucfirst(trans('jrl.mood')).':',['class' => 'control-label']) !!}
            {!! Form::selectRange('mood', 1, 5, $mood, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('health', ucfirst(trans('jrl.health')).':',['class' => 'control-label']) !!}
            {!! Form::selectRange('health', 1, 5, $health, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('description', ucfirst(trans('jrl.description')).':',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor']) !!}
        </div>
    </div>
    <div class="col-lg-12">
        <h3>{{ ucfirst(trans('jrl.coordinates')) }}</h3>
    </div>
    
    <div class="col-lg-6" id="map_canvas" style="min-height: 400px;"></div>

    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('lon_start', ucfirst(trans('jrl.longitude')).' '.trans('jrl.start').':',['class' => 'control-label']) !!}
            {!! Form::text('lon_start',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lat_start', ucfirst(trans('jrl.latitude')).' '.trans('jrl.start').':',['class' => 'control-label']) !!}
            {!! Form::text('lat_start',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lon_finish', ucfirst(trans('jrl.longitude')).' '.trans('jrl.finish').':',['class' => 'control-label']) !!}
            {!! Form::text('lon_finish',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('lat_finish', ucfirst(trans('jrl.latitude')).' '.trans('jrl.finish').':',['class' => 'control-label']) !!}
            {!! Form::text('lat_finish',null,['class' => 'form-control']) !!}
        </div>
    </div>
<script type="text/javascript">
    /*
     * @TODO: Retrieve data from Strava
     */
    $(document).ready(function() {
        AddGMToHead();
        var arrWps = new Array();     
        
        $("#lon_start","#lat_start").on("change", function(event) {
            drawMap(new Array(),'map_canvas');
        });

        $("#lon_finish","#lat_finish").on("change", function(event) {
            drawMap(new Array(),'map_canvas');
        });
        
        // If lat/lon is empty, try by finding the coordinates
        if(!($('#lat_start').val()) || !($('#lon_start').val())) {
            getcoords();
        }
        
        @if (isset($workout) and $workout->id > 0 )
        arrWps = getWaypoints({{ $workout->id }});
        @endif
        
        $("#route_id").on("change",function(elem){
            if($("#route_id").val() == "") {
                $("#distance").val("");
                return;
            } 
            $.getJSON( "/routes/byid", {
                id: $('#route_id').val(),
                format: "json",
                method: "POST"
            })
            .done(function(data){
                if(data.distance && parseInt(data.distance) > 0 ) {
                    $("#distance").val(data.distance);
                } 
            })
            .fail(function(data){
                $("#distance").val("");
                console.log("Fout bij ophalen route.");
            });
        });

        setTimeout(function() {
            drawMap(arrWps,'map_canvas');
        },700);

        $('#btn-weather').on("click", function(event){
            fetch_weather();
        });
    });   
</script>