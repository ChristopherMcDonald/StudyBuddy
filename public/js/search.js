/**
 * [onload requests adress using HTML5 geolocation, fills in input field]
 * @return {none}
 */
window.onload = () => {
    // make request for location
    // navigator.geolocation.getCurrentPosition((pos) => {
    //     // build request to Google Maps API for PostalCode, pos.coords.latitude, pos.coords.longitude
    //     var req = "https://maps.googleapis.com/maps/api/geocode/json?" + "latlng=" + pos.coords.latitude + "," + pos.coords.longitude + "&sensor=true&key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY";
    //
    // });
}

/**
 * [findNearMe directly navigates to search page using postal code, uses HTML5 geolocation]
 * @return {none}
 */
findNearMe = () => {
    navigator.geolocation.getCurrentPosition((pos) => {
        window.location = '/static/results.php?lat' + pos.coords.latitude + '&lng=' + pos.coords.longitude;
    });
}
