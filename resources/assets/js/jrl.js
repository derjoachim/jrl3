/*
 * Try to get coordinates based on HTML5 geolocation API
 * @param {type} prefix
 * @returns {Boolean}
 */
function getcoords(prefix) {
    if (!prefix) {
        prefix = '';
    }
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            $('#' + prefix + 'lat_start').val(lat);
            $('#' + prefix + 'lon_start').val(lon);
            if (sessionStorage && (sessionStorage.getItem("lon_start") != lon || sessionStorage.getItem("lat_start") != lat)) {
                // Trigger a refresh by setting the current timestamp to Jan 1, 1970
                sessionStorage.setItem("timestamp", "0");
            }

            $('#' + prefix + 'lon_start').trigger('change'); // Have to fire this event explicitly. Y U NO work automagically?
        });
    } else {
        console.log('Geolocation is either disabled or not supported. The programmer is a lazy bastard. You should fill in your own weather description.');
        return false;
    }
}


/**
 * Render a full map based on a workout
 *
 * Get a (workout) id, render a polyline based on the waypoints, draw start and stop markers and fit the map to the
 * canvas.
 *
 * @param int id ID of the workout
 * @param string canvas_elem the canvas element to be rendered
 * @param string start_lat name of the form element that contains the latitude
 * @param string start_lon name of the form element that contains the longitude
 */
function renderMap(id, canvas_elem, start_lat, start_lon) {
    $.getJSON("/waypoints", {
        "id": id,
        "method": "POST",
        "format": "json"
    }).success(function (data) {
        var mymap = prepareMap(canvas_elem,start_lat,start_lon)

        var startIcon = new L.icon({
            iconUrl: "/img/marker-icon-green.png",
            iconSize: [40, 40]
        });
        var finishIcon = new L.icon({
            iconUrl: "/img/marker-icon-red.png",
            iconSize: [40, 40]
        });

        new L.marker([$("#lat_start").val(), $("#lon_start").val()], {icon: startIcon}).addTo(mymap);
        new L.marker([$("#lat_finish").val(), $("#lon_finish").val()], {icon: finishIcon}).addTo(mymap);
        var polyline = new L.polyline(data, {color: 'red'}).addTo(mymap);
        mymap.fitBounds(polyline.getBounds());
    });
}

/**
 * Render an empty map with a single marker
 *
 * @param canvas_elem
 * @param start_lat
 * @param start_lon
 */
function renderEmptyMap(canvas_elem, start_lat, start_lon)
{
    var mymap = prepareMap(canvas_elem, start_lat, start_lon);
    var startIcon = new L.icon({
        iconUrl: "/img/marker-icon-green.png",
        iconSize: [40, 40]
    });
    new L.marker([$("#"+start_lat).val(), $("#"+start_lon).val()], {icon: startIcon}).addTo(mymap);
}

/**
 * Render an empty map on canvas_elem based on start latitude and longitude
 *
 * @param canvas_elem
 * @param start_lat
 * @param start_lon
 */
function prepareMap(canvas_elem, start_lat, start_lon) {
    console.log("Poging 2: " + $("#"+start_lat).val() + " -- " +$("#"+start_lon).val());

    var mymap = L.map(canvas_elem);
    var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
    var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 18, attribution: osmAttrib});
    mymap.setView(new L.LatLng($("#"+start_lat).val(), $("#"+start_lon).val()), 14);
    mymap.addLayer(osm);
    return mymap;
}




/**
 * Collect parameters and do an AJAX call that basically wraps around the weather.io APi
 *
 * @returns {boolean|void}
 */
function fetch_weather() {
    if ($('#date').val() == '') {
        alert("Vult u svp een datum in");
        return false;
    }
    if ($('#start_time').val() == '') {
        alert('Vult u svp een geldige tijd HH:MM in');
        return false;
    }
    if ($('#lon_start').val() == '' || $('#lat_start').val() == '') {
        alert('Vult u SVP uw coordinaten in');
        return false;
    }
    $.getJSON("/forecast", {
        date: $('#date').val(),
        time: $('#start_time').val(),
        lon: $('#lon_start').val(),
        lat: $('#lat_start').val(),
        format: "json",
        method: "POST"
    })
        .done(function (data) {
            $('#temperature').val(Math.round(data.currently.temperature));
            $('#pressure').val(Math.round(data.currently.pressure));
            $('#humidity').val(Math.round(100 * data.currently.humidity));
            $('#wind_speed').val(Math.round(data.currently.windSpeed * 3.6));
            $('#wind_direction').val(deg2compass(data.currently.windBearing));
        })
        .fail(function (data) {
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
    val = Math.round((parseInt(num) / 22.5) + .5);
    arr = new Array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");
    return arr[(val % 16)];
}

/*
 * Retrieve all waypoints for a workout
 * @param {integer} id
 * @returns {arrWps|Array}
 */
function getWaypoints(id) {
    $.getJSON("/waypoints", {
        "id": id,
        "method": "POST",
        "format": "json"
    }).done(function (data) {
        return data;
    });
    return false;
}

/*
 * Opens a Jquery modal
 * @param id: ID of the modal element
 * @param url: URL of the route to be opened into the modal
 */
function jqmodal(elem, yeoldeurl) {
    $.ajax({
        type: "GET",
        url: yeoldeurl
    }).done(function (html) {
        $('#' + elem).html(html);
    });
}