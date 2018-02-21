/**
 * [initMap called by Google Maps API, initiates and binds to #map]
 * @return {none}
 */
initMap = () => {
    // make objects for Cannon coffee
    var cannon = {lat: 43.247664, lng: -79.817814};

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
}
