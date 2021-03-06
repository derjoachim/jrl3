    <div class="col-lg-3">
        <div class="btn-group" role="group" >
            <button type="submit" class="btn btn-default navbar-btn"><i class="glyphicon glyphicon-save"></i> 
                {{ ucfirst(trans('app.save')) }}
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h3>{{ ucfirst(trans('jrl.general_data')) }}</h3>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            {!! Form::label('name', ucfirst(trans('jrl.name')) .':',['class' => 'control-label']) !!}
            {!! Form::text('name',null,['class' => 'form-control input-lg']) !!}
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
    <div class="col-lg-6" id="map_canvas">
        {!! Form::hidden('lon_start',null,['id' => 'lon_start']) !!}
        {!! Form::hidden('lat_start',null,['id' => 'lat_start']) !!}
        {!! Form::hidden('lon_finish',null,['id' => 'lon_finish']) !!}
        {!! Form::hidden('lat_finish',null,['id' => 'lat_finish']) !!}
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
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
    <div class='col-lg-4'>
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
    <div class="col-lg-4">
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
        <div class="form-group">
            {!! Form::label('avg_hr', ucfirst(trans('jrl.avg_hr')).':',['class' => 'control-label']) !!}
            {!! Form::text('avg_hr',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('max_hr', ucfirst(trans('jrl.max_hr')).':',['class' => 'control-label']) !!}
            {!! Form::text('max_hr',null,['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('description', ucfirst(trans('jrl.description')).':',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor', 'rows' => '5']) !!}
        </div>
    </div>
</div>
{{--<div class="row">--}}
{{--    <div class="col-lg-6">--}}
{{--        <h3>{!! ucfirst(trans('jrl.coordinates')) !!}</h3>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="row">

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#lon_start","#lat_start").on("change", function(event) {
            // drawMap(new Array(),'map_canvas');
            //TODO
        });

        $("#lon_finish","#lat_finish").on("change", function(event) {
            //drawMap(new Array(),'map_canvas');
            //TODO
        });
        
        // If lat/lon is empty, try by finding the coordinates
        if(!($('#lat_start').val()) || !($('#lon_start').val())) {
            getcoords();
        }
        

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

        $('#btn-weather').on("click", function(event){
            fetch_weather();
        });

        @if (isset($workout) and $workout->id > 0 )
        renderMap({{$workout->id}}, "map_canvas", "lon_start", "lat_start");
        @endif
    });   
</script>