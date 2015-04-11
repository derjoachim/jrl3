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
 * Get the weather from worldweather.com
 * @param lon int : Longitude in degrees
 * @param lat int : latitude in degrees
 */
function fetch_weather(lat,lon) 
{
	var bRefresh = false;// -> TODO: make it dependent on timestamp
	if(!sessionStorage) { bRefresh = true;} // Old data isn't saved, so the JSON call must be made
	else if($time() - sessionStorage.getItem("timestamp") > 1000 * 60 * 15) { bRefresh = true;}

	if(bRefresh)
	{
		sessionStorage.clear();
		sessionStorage.setItem("timestamp",$time());
		sessionStorage.setItem("lon_start",lon);
		sessionStorage.setItem("lat_start",lat);
		var gRequest = new Request.JSONP({
			method: 'get', 
			data: {
					'q': lat+','+lon,
					'format': 'json',
					'num_of_days': '2',
					'key': apicode
			},
			url: 'http://free.worldweatheronline.com/feed/weather.ashx',
			onComplete: function(evt) {
				if(evt.data && evt.data.current_condition.length > 0) {
					var cc = evt.data.current_condition[0];
					var wind = cc.winddir16Point+" "+cc.windspeedKmph+" km/h";
					$each({ 'humidity':cc.humidity,'temperature':cc.temp_C,"pressure":cc.pressure,"wind":wind}, function(val,idx){
						if(sessionStorage) {
							sessionStorage.setItem(idx,val);
						}
						$(idx).set('value',val);
					});
				}
			}
		}).send();
	}
	else if(sessionStorage)
	{ 
		$('humidity').set('value',sessionStorage.getItem("humidity"));
		$('temperature').set('value',sessionStorage.getItem("temperature"));
		$('pressure').set('value',sessionStorage.getItem("pressure"));
		$('wind').set('value',sessionStorage.getItem("wind"));
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
 * @param lon: longitude
 * @param lat: latitude
 * @param elemid: id of the element
 * @param prefix string: prefix
 */
function drawMap(lat,lon,elemid,prefix)
{
    if(String(prefix).length == 0) { prefix = '';}
    if(typeof(lon) == "undefined" || typeof(lat) == "undefined")
    {
        console.log("Invalid latitude "+lat+" or longitude "+lon);
        return false;
    }
    var myLatlng = new google.maps.LatLng(lat, lon);
    var myOptions = {
        zoom: 16,
        center: myLatlng,
        streetViewControl: true,
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById(elemid),myOptions);
    var marker = new google.maps.Marker({
        map:map,
        draggable:true,
        //animation: google.maps.Animation.DROP,
        position: myLatlng
    });

    google.maps.event.addListener(marker,'mouseup',function(e) {
        var mypos = e.latLng;
        $('#'+prefix+'lat_start').val(mypos.lat());
        $('#'+prefix+'lon_start').val(mypos.lng());
        map.setCenter(mypos)
    });
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