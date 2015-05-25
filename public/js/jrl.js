var apicode = "d1b7e70b48125943112710";
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
    if(typeof(google) == "undefined") { 
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyAqDEqlfOFkyVxhHtU0kjuOWaXLwBwDQGY&sensor=true&callback=drawMap";
        document.body.appendChild(script);
        console.log('successfully added GM API');
    }
}


/*
 * Draws map based on longitude and latitude
 * @param array arrMarker: array of markers to be drawn
 * @param array arrWps: array of waypoints with longitude and latitude
 * @param elemid: id of the element
 * @param prefix string: prefix
 */
function drawMap(arrMarker,arrWps,elemid,prefix)
{
    if(typeof(arrMarker) == "undefined") {
        console.log("No markers defined");
        return false;
    }
    if(String(prefix).length == 0) { prefix = '';}
    var lon = arrMarker[0][1];
    var lat = arrMarker[0][0];
 
    var myLatlng = new google.maps.LatLng(arrMarker[0][0], arrMarker[0][1]);
    var myOptions = {
        zoom: 16,
        center: myLatlng,
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
    // Draw the route
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

/*
 * Opens a Jquery modal
 * @param id: ID of the modal element
 * @param url: URL of the route to be opened into the modal
 */
function jqmodal(elem,yeoldeurl)
{
	$.ajax({
		type: "GET",
		url: yeoldeurl,
	}).done(function(html){
		jQuery('#'+elem).html(html);
	});
}