<script type="text/javascript" defer>
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
<div class="row">
    <div class="col-lg-3">
        <h3>Algemene gegevens</h3>
        <div class="form-group">
            {!! Form::label('name', 'Naam:',['class' => 'control-label']) !!}
            {!! Form::text('name',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('date', 'Datum:',['class' => 'control-label']) !!}
            {!! Form::input('date','date',$date,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('start_time', 'Tijd:',['class' => 'control-label']) !!}
            {!! Form::text('start_time',null,['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-3">
        <h3>Tijd en afstand</h3>
        <div class="form-group">
            {!! Form::label('route_id', 'Route:',['class' => 'control-label']) !!}
            {!! Form::select('route_id',$routes, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('distance', 'Afstand:',['class' => 'control-label']) !!}
            {!! Form::text('distance',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('time_in_seconds', 'Eindtijd:',['class' => 'control-label']) !!}
            {!! Form::text('time_in_seconds',(isset($t) ? $t : null),['class' => 'form-control']) !!}
        </div>
    </div>
    <div class='col-lg-3'>
        <h3>Weer</h3>
        <a class="btn btn-warning" id="btn-weather"><i class="icon glyphicon glyphicon-cloud"></i> Fetch</a>
        <div class="form-group">
            {!! Form::label('temperature', 'Temperatuur:',['class' => 'control-label']) !!}
            {!! Form::text('temperature',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('pressure', 'Luchtdruk:',['class' => 'control-label']) !!}
            {!! Form::text('pressure',null,['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('humidity', 'Vochtigheid:',['class' => 'control-label']) !!}
            {!! Form::text('humidity',null,['class' => 'form-control']) !!}
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
            {!! Form::checkbox('finished', '1', true) !!}
        </div>
        <div class="form-group">
            {!! Form::label('mood', 'Stemming:',['class' => 'control-label']) !!}
            {!! Form::selectRange('mood', 1, 5, $mood, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('health', 'Gezondheid:',['class' => 'control-label']) !!}
            {!! Form::selectRange('health', 1, 5, $health, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="form-group">
            {!! Form::label('description', 'Omschrijving:',['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['class' => 'form-control ckeditor']) !!}
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
            {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
        </div>            
    </div>
</div>
