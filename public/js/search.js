/**
 * [onload requests adress using HTML5 geolocation, fills in input field]
 * @return {none}
 */
window.onload = () => {
    // make request for location
    navigator.geolocation.getCurrentPosition((pos) => {
        // build request to Google Maps API for PostalCode
        var req = "https://maps.googleapis.com/maps/api/geocode/json?" + "latlng=" + pos.coords.latitude + "," + pos.coords.longitude + "&sensor=true&key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY";

        // make request to Google Maps API
        $.get(req)
            // ON SUCCESS
            .done((data) => {
                // filter all the address component for "postal_code"
                // and strip the space
                var post = data.results[0].address_components.filter(item => item.types.includes("postal_code"))[0].long_name.replace(/\s/g, '');
                // fill in field
                $(".form-entry > input[name='postal']").val(post);
            })
            // ON FAIL
            .fail(() => {
                displayError("Woah! We had some trouble getting your location, please fill in the field manually.");
                console.error("Could not access Google Maps API for Postal Code");
            });
    });
}

/**
 * [findNearMe directly navigates to search page using postal code, uses HTML5 geolocation]
 * @return {none}
 */
findNearMe = () => {
    navigator.geolocation.getCurrentPosition((pos) => {
        var req = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + pos.coords.latitude + "," + pos.coords.longitude + "&sensor=true&key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY";

        // make request to Google Maps API
        $.get(req)
            // ON SUCCESS
            .done((data) => {
                // filter all the address component for "postal_code"
                // and strip the spaces
                var post = data.results[0].address_components.filter(item => item.types.includes("postal_code"))[0].long_name.replace(/\s/g, '');
                // do a fuzzy search only using postal code
                window.location.href = "/static/results.html?postal=" + post;
            })
            // ON FAIL
            .fail(() => {
                displayError("Woah! We had some trouble getting your location, please fill in the field manually and click 'Search'!");
                console.error("Could not access Google Maps API for Postal Code");
            });
    };
}
