/**
 * [initMap called by Google Maps API, initiates and binds to #map]
 * @return {none}
 */
initMap = () => {
    // build objects for each marker
    var cannon = {lat: 43.247664, lng: -79.817814};
    var mcmaster = {lat: 43.260806, lng: -79.920407};
    var lib = {lat: 43.258935, lng: -79.870521};

    // build map object with Google Maps API
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,           // how zoomed in view is
        center: cannon      // where map is centered
    });

    // build a marker object with Google Maps API
    var cannonMarker = new google.maps.Marker({
        position: cannon,           // where to place
        map: map,                   // what map to put on
        title: 'Cannon Coffee Co.'  // title of it
    });

    // build window object with Google Maps API
    var cannonInfo = new google.maps.InfoWindow({
        // what will show when clicked
        content: '<div id="content"><a href="/static/detail.html">Cannon Coffee Co.</a><p>179 Ottawa St N</p><p>Hamilton, ON</p><p class="pull-left">L8H 3Z4</p></div>'
    });

    // bind click listener for Cannon Marker
    cannonMarker.addListener('click', function() {
        cannonInfo.open(map, cannonMarker);
    });

    // do the same for McMaster and Library...
    var macMarker = new google.maps.Marker({
        position: mcmaster,
        map: map
    });

    var macInfo = new google.maps.InfoWindow({
        content: '<div id="content"><a href="/static/detail.html">McMaster University Library</a><p>1280 Main St W</p><p>Hamilton, ON</p><p class="pull-left">L8S 1B1</p></div>'
    });

    macMarker.addListener('click', function() {
        macInfo.open(map, macMarker);
    });

    var libraryMarker = new google.maps.Marker({
        position: lib,
        map: map
    });

    var libraryInfo = new google.maps.InfoWindow({
        content: '<div id="content"><a href="/static/detail.html">Hamilton Public Library</a><p>55 York Blvd</p><p>Hamilton, ON</p><p class="pull-left">L8P 1K1</p></div>'
    });

    libraryMarker.addListener('click', function() {
        libraryInfo.open(map, libraryMarker);
    });
}
