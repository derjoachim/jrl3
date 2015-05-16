<script type="text/javascript" defer>
    /*
     * @TODO: Retrieve weather data
     * @TODO: Retrieve data from Strava
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
        
        $('#btn-weather').on("click", function(event){
            if( $('#date').val() == '') {
                alert("Vult u svp een datum in");
                return false;
            }
            if($('#start_time').val() == '') {
                alert('Vult u svp een geldige tijd HH:MM in');
                return false;
            }
            if($('#lon_start').val() == '' || $('#lat_start').val() == '') {
                alert('Vult u SVP uw coordinaten in');
                return false;
            }
            $.getJSON( "/forecast", {
                date: $('#date').val(),
                time: $('#start_time').val(),
                lon: $('#lon_start').val(),
                lat: $('#lat_start').val(),
                format: "json",
                method: "POST"
            })
            .done(function(data){
                $('#temperature').val(Math.round(data.currently.temperature));
                $('#pressure').val(Math.round(data.currently.pressure));
                $('#humidity').val(Math.round(100 * data.currently.humidity));
                $('#wind_speed').val(Math.round(data.currently.windSpeed * 3.6));
                $('#wind_direction').val(deg2compass(data.currently.windBearing));
           })
            .fail(function(data){
                alert("Fout bij ophalen weer. ");
            });
        });
    });
    
    /*
     * Convert degrees to compass direction
     * Source: http://stackoverflow.com/questions/7490660/converting-wind-direction-in-angles-to-text-words
     * @param int nuw
     * @return string compass direction e.g. NNW
     */
    function deg2compass(num) {
        val = Math.round((parseInt(num)/22.5)+.5);
        arr = new Array("N","NNE","NE","ENE","E","ESE", "SE", "SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");
        return arr[(val % 16)];
    }
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
