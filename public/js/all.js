var apicode = "d1b7e70b48125943112710";
/*
 * Try to get coordinates based on HTML5 geolocation API
 * @param {type} prefix
 * @returns {Boolean}
 */
function getcoords(prefix) 
{
    if(!prefix) { prefix = '';}
    if (navigator.geolocation) 
    { 
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            $('#'+prefix+'lat_start').val(lat);
            $('#'+prefix+'lon_start').val(lon);
            if(sessionStorage && (sessionStorage.getItem("lon_start")!=lon || sessionStorage.getItem("lat_start")!=lat))
            { 
                // Trigger a refresh by setting the current timestamp to Jan 1, 1970
                sessionStorage.setItem("timestamp","0");
            }

            $('#'+prefix+'lon_start').trigger('change'); // Have to fire this event explicitly. Y U NO work automagically?
        });
    } 
    else
    {
        console.log('Geolocation is either disabled or not supported. The programmer is a lazy bastard. You should fill in your own weather description.');
        return false;
    }
}

/*
 * Add Google maps API JS to the document HEAD
 */
function AddGMToHead()
{
    if(typeof(google) === "undefined") { 
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyAqDEqlfOFkyVxhHtU0kjuOWaXLwBwDQGY&sensor=true&callback=drawMap";
        document.body.appendChild(script);
//        console.log('successfully added GM API');
    }
}
/*
 * Fills the data for the green start marker
 * @returns {Boolean}
 */
function fillStartMarker() 
{
    if($("#lat_start").val() && $("#lon_start").val()) {
        return new Array($("#lat_start").val(),$("#lon_start").val(),'green','Start');
    }
    return new Array();
}
/*
 * Fills the data for the red stop marker
 * @returns {undefined}
 */
function fillStopMarker()
{
    if($("#lat_finish").val() && $("#lon_finish").val()) {
        return new Array($("#lat_finish").val(),$("#lon_finish").val(),'red','Finish');
    }
    return new Array();
}

/*
 * Draws map based on longitude and latitude
 * @param array arrMarker: array of markers to be drawn
 * @param elemid: id of the element
 * @param prefix string: prefix
 */
function drawMap(arrWps,elemid,prefix)
{
    var arrMarker = new Array();
    arrMarker[0] = fillStartMarker();
    arrMarker[1] = fillStopMarker();
    
    if(String(prefix).length === 0) { prefix = '';}
    var lon = arrMarker[0][1];
    var lat = arrMarker[0][0];
 
    var myOptions = {
        zoom: 16,
        center: new google.maps.LatLng(lat, lon),
        streetViewControl: true,
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var infowindow = new google.maps.InfoWindow();
    var map = new google.maps.Map(document.getElementById(elemid),myOptions);
    $.each(arrMarker, function(elem,val){
        var tmpLatLng = new google.maps.LatLng(Number(val[0]), Number(val[1]));
        var marker = new google.maps.Marker({
            map:map,
            draggable:true,
            icon: "http://maps.google.com/mapfiles/ms/icons/" + val[2] + ".png",
            position: tmpLatLng
        });
        
        google.maps.event.addListener(marker, 'click', (function(marker) {
            return function() {
                infowindow.setContent(val[3]);
                infowindow.open(map, marker);
            }
        })(marker));
        google.maps.event.addListener(marker,'mouseup',function(e) {
            var mypos = e.latLng;
            $('#'+prefix+'lat_start').val(mypos.lat());
            $('#'+prefix+'lon_start').val(mypos.lng());
            map.setCenter(mypos);
        });
        
    });
    
    if(arrWps.length > 0 ) {
        var arrRoute = new Array();
        var bounds = new google.maps.LatLngBounds();
        $.each(arrWps, function(elem, val){
            var tmpLatLng = new google.maps.LatLng(Number(val[0]), Number(val[1]));
            arrRoute.push(tmpLatLng);
            bounds.extend(tmpLatLng);
        });
        var myRoute = new google.maps.Polyline({
            path: arrRoute,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });
        map.setCenter(bounds.getCenter());
        map.fitBounds(bounds);
        myRoute.setMap(map);        
    }
}

/*
 * 
 * @param {type} num
 * @returns {arr|Array}
 */
function fetch_weather() {
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
        console.log("Fout bij ophalen weer.");
    });
}

/*
 * Convert degrees to compass direction
 * Source: http://stackoverflow.com/questions/7490660/converting-wind-direction-in-angles-to-text-words
 * @param int num
 * @return string compass direction e.g. NNW
 */
function deg2compass(num) {
    val = Math.round((parseInt(num)/22.5)+.5);
    arr = new Array("N","NNE","NE","ENE","E","ESE", "SE", "SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");
    return arr[(val % 16)];
}

/*
 * Retrieve all waypoints for a workout
 * @param {integer} id
 * @returns {arrWps|Array}
 */
function getWaypoints(id) {
    arrWps = new Array();
    $.getJSON("/waypoints", {
        "id": id,
        "method": "POST",
        "format": "json"
    }).done(function(data) {
        $.each(data, function(key,i) { 
            arrWps.push(new Array(i.lat,i.lon));
        });
    });
    return arrWps;
}
/*
 * Opens a Jquery modal
 * @param id: ID of the modal element
 * @param url: URL of the route to be opened into the modal
 */
function jqmodal(elem,yeoldeurl)
{
    $.ajax({
        type: "GET",
        url: yeoldeurl
    }).done(function(html){
        $('#'+elem).html(html);
    });
}
//# sourceMappingURL=all.js.map
