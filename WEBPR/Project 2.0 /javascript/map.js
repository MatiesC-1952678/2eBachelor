mapboxgl.accessToken = 'pk.eyJ1IjoibWF0aWVrZTYwMCIsImEiOiJja2puMWhmOGI1cDJ1MnJucXZsZjl3Y2RuIn0.G9pCvnFOqxWN3CObQV7x5A';
var map = new mapboxgl.Map({
    container: 'map', // Container ID
    style: 'mapbox://styles/mapbox/streets-v11', // Map style to use
    center: [4.3517, 50.8503], // Starting position [lng, lat]
    zoom: 3, // Starting zoom level
});
var geocoder = new MapboxGeocoder({ // Initialize the geocoder
    accessToken: mapboxgl.accessToken, // Set the access token
    //placeholder: 'Search for places in around the globe';
    mapboxgl: mapboxgl, // Set the mapbox-gl instance
    marker: false, // Do not use the default marker style
});

// Add the geocoder to the map
map.addControl(geocoder);