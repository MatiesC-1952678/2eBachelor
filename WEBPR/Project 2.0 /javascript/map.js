//THIS IMPLEMENTATION IS TAKEN FROM mapbox.com
mapboxgl.accessToken = 'pk.eyJ1IjoibWF0aWVrZTYwMCIsImEiOiJja2puMWhmOGI1cDJ1MnJucXZsZjl3Y2RuIn0.G9pCvnFOqxWN3CObQV7x5A';
var map = new mapboxgl.Map({
    container: 'map', // Container ID
    style: 'mapbox://styles/mapbox/streets-v11', // Map style to use
    center: [4.3517, 50.8503], // Starting position [lng, lat]
    zoom: 3, // Starting zoom level
});

//THIS FUNCTION IS TAKEN FROM https://docs.mapbox.com/mapbox-gl-js/example/mapbox-gl-geocoder-accept-coordinates/ 
/* given a query in the form "lng, lat" or "lat, lng" returns the matching
* geographic coordinate(s) as search results in carmen geojson format,
* https://github.com/mapbox/carmen/blob/master/carmen-geojson.md
*/
var coordinatesGeocoder = function (query) {
    // match anything which looks like a decimal degrees coordinate pair
    var matches = query.match(
        /^[ ]*(?:Lat: )?(-?\d+\.?\d*)[, ]+(?:Lng: )?(-?\d+\.?\d*)[ ]*$/i
    );
    if (!matches) {
        return null;
    }
     
    function coordinateFeature(lng, lat) {
        return {
            center: [lng, lat],
            geometry: {
                type: 'Point',
                coordinates: [lng, lat]
            },
            place_name: 'Lat: ' + lat + ' Lng: ' + lng,
            place_type: ['coordinate'],
            properties: {},
            type: 'Feature'
        };
    }
     
    var coord1 = Number(matches[1]);
    var coord2 = Number(matches[2]);
    var geocodes = [];
     
    if (coord1 < -90 || coord1 > 90) {
        // must be lng, lat
        geocodes.push(coordinateFeature(coord1, coord2));
    }
     
    if (coord2 < -90 || coord2 > 90) {
        // must be lat, lng
        geocodes.push(coordinateFeature(coord2, coord1));
    }
     
    if (geocodes.length === 0) {
        // else could be either lng, lat or lat, lng
        geocodes.push(coordinateFeature(coord1, coord2));
        geocodes.push(coordinateFeature(coord2, coord1));
    }
    return geocodes;
};

var geocoder = new MapboxGeocoder({ // Initialize the geocoder
    accessToken: mapboxgl.accessToken, // Set the access token
    placeholder: '170,-40 or Address',
    localGeocoder: coordinatesGeocoder,
    mapboxgl: mapboxgl, // Set the mapbox-gl instance
    marker: false, // Do not use the default marker style
    trackUserLocation: true
});

// Add the geocoder to the map
map.addControl(geocoder);

map.on('click', function (e) {
    var long = document.getElementById('longInput');
    var lat = document.getElementById('latInput');
    document.getElementById('lnglat').innerHTML = "Lat: "+e.lngLat.lat+" - Long: "+e.lngLat.lng;
    if (long != null && lat != null) {
        long.value = e.lngLat.lng;
        lat.value = e.lngLat.lat;
    }
    if (document.getElementById('Searchbar') != null) 
        getLongLatsFromDatabase(e.lngLat.lng, e.lngLat.lat);
});

getLongLatsFromDatabase(0, 0);
function getLongLatsFromDatabase(long, lat) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        showMarkers(xmlhttp, long, lat);
    };
    xmlhttp.open("POST", "ajax/ajaxHome.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("type=getLongLat");
}

function showMarkers(xmlhttp, long, lat) {
    if ((xmlhttp) && (xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
        if (xmlhttp.responseText != "0") {
            var output = JSON.parse(xmlhttp.responseText);
            if (long == 0 && lat == 0) {
                output.forEach(room => {
                    createMarker(room.long, room.lat, room.name, room.belongstohotel)
                });
            } else {
                var distancePlusInfo = new Array();
                var echo = "";
                output.forEach(room => {
                    if (room.long != 0 && room.lat != 0) {
                        distancePlusInfo.push(new Array(calcDistance(lat, long, room.lat, room.long), room));
                    }
                });
                distancePlusInfo.sort( function(a, b) {
                    if (a[0] > b[0]) 
                        return 1;
                    if (a[0] < b[0])
                        return -1;
                    if (a[1][4] > b[1][4])
                        return 1;
                    if (a[1][5] < b[1][5]) 
                        return -1;
                    return 0; 
                })
                for (var i = 0; i < distancePlusInfo.length; i++) {
                    echo += '<article class="Room"><p class="Room-Title title">'+distancePlusInfo[i][1][1]+'</p><ul><li> Distance: '+distancePlusInfo[i][0]+'km </li><li> Hotel: '+distancePlusInfo[i][1][0]+'</li><li> Cost: €'+distancePlusInfo[i][1][3]+'</li>';
                    if (distancePlusInfo[i][1][2] != "")
                        echo += '<li> Description: '+distancePlusInfo[i][1][2]+'</li>';
                    if (distancePlusInfo[i][1][4] != "" && distancePlusInfo[i][1][5] != "")
                        echo += '<li> Availability:  '+distancePlusInfo[i][1][4]+' - '+distancePlusInfo[i][1][5]+' (overrides hotel) </li>';
                    if (distancePlusInfo[i][1][6] != "")
                        echo += '<li> Max Timeslot: '+distancePlusInfo[i][1][6]+'</li>';
                    echo += '<li><a href="booking.php?roomName='+encodeURI(distancePlusInfo[i][1][1])+'&hotelName='+encodeURI(distancePlusInfo[i][1][0])+'">Book This Room</a></li>';
                    echo += '<li><a href="rating.php?room='+encodeURI(distancePlusInfo[i][1][1])+'&hotel='+encodeURI(distancePlusInfo[i][1][0])+'">Ratings</a></li>';
                    echo += '<li> Coordinates (long,lat): '+distancePlusInfo[i][1][7]+', '+distancePlusInfo[i][1][8]+'</li>'
                    echo += '</ul></article>';
                }
                document.getElementsByClassName("List")[0].innerHTML = echo;
            }
        } else 
            document.getElementsByClassName("List")[0].setCustomValidity("Error accessing db");
    }
}

//INSPIRED BY https://stackoverflow.com/questions/18883601/function-to-calculate-distance-between-two-coordinates 
function calcDistance(lat1, long1, lat2, long2) {
      var R = 6371; // km
      var dLat = toRad(lat2-lat1);
      var dLon = toRad(long2-long1);
      var lat1 = toRad(lat1);
      var lat2 = toRad(lat2);

      var first = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
      return (2 * Math.atan2(Math.sqrt(first), Math.sqrt(1-first))) * R;
}

    // Converts numeric degrees to radians
function toRad(Value) {
    return Value * Math.PI / 180;
}

function createMarker(long, lat, room, hotel) {
    if (long != 0 && lat != 0) {
        var marker = new mapboxgl.Marker() 
            .setLngLat([long, lat]) 
            .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML(
                    `<p class="title">${room}</p><text>${hotel}</text><a href="booking.php?roomName=${encodeURI(room)}&hotelName=${encodeURI(hotel)}"> Book This Room </a>`))
            .addTo(map); 
    }
}


/*
var search = document.getElementById("address");
if (search != null)
    search.addEventListener("input", getLongLat, false);

function getLongLat() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        showResult(xmlhttp);
    };
    var address = document.getElementById('address').value;
    xmlhttp.open("GET", "https://api.mapbox.com/geocoding/v5/mapbox.places/"+encodeURI(address)+".json?access_token=pk.eyJ1IjoibWF0aWVrZTYwMCIsImEiOiJja2puMHQ3ZjcyaWc2MnJsbzZwbW5zYm5kIn0.kmfxcBp1HWKQyKW5KsIHZA", true);
    xmlhttp.send();
}

function showResult(xmlhttp) {
    if ((xmlhttp) && (xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
        if (xmlhttp.responseText == "0")
            document.getElementById("address").setCustomValidity("Error retrieving address");
        else
            var test = JSON.parse(xmlhttp.responseText);
    }
}
*/