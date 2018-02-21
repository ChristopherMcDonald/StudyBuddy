function initMap() {
    var cannon = {lat: 43.247664, lng: -79.817814};
    var mcmaster = {lat: 43.260806, lng: -79.920407};
    var lib = {lat: 43.258935, lng: -79.870521};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: cannon
    });

    var marker1 = new google.maps.Marker({
        position: cannon,
        map: map,
        title: 'Cannon Coffee Co.'
    });

    var infowindow = new google.maps.InfoWindow({
        content: '<div id="content"><a href="/static/detail.html">Cannon Coffee Co.</a><p>179 Ottawa St N</p><p>Hamilton, ON</p><p class="pull-left">L8H   3Z4</p></div>'
    });

    marker1.addListener('click', function() {
        infowindow.open(map, marker1);
    });

    var marker2 = new google.maps.Marker({
        position: mcmaster,
        map: map
    });

    var infowindow2 = new google.maps.InfoWindow({
        content: '<div id="content"><a href="/static/detail.html">McMaster University Library</a><p>1280 Main St W</p><p>Hamilton, ON</p><p class="pull-left">L8S 1B1</p></div>'
    });

    marker2.addListener('click', function() {
        infowindow2.open(map, marker2);
    });

    var marker3 = new google.maps.Marker({
        position: lib,
        map: map
    });

    var infowindow3 = new google.maps.InfoWindow({
        content: '<div id="content"><a href="/static/detail.html">Hamilton Public Library</a><p>55 York Blvd</p><p>Hamilton, ON</p><p class="pull-left">L8P 1K1</p></div>'
    });

    marker3.addListener('click', function() {
        infowindow3.open(map, marker3);
    });
}
