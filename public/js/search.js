window.onload = () => {
    navigator.geolocation.getCurrentPosition((pos) => {
        var req = "https://maps.googleapis.com/maps/api/geocode/json?" + "latlng=" + pos.coords.latitude + "," + pos.coords.longitude + "&sensor=true&key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY";

        $.get(req, {}, (data) => {
            var post = data.results[0].address_components.filter(item => item.types.includes("postal_code"))[0].long_name
.replace(/\s/g, '');
            $(".form-entry > input[name='postal']").val(post);
            });
        }
    );
}

findNearMe = () => {
    navigator.geolocation.getCurrentPosition((pos) => {
        var req = "https://maps.googleapis.com/maps/api/geocode/json?" + "latlng=" + pos.coords.latitude + "," + pos.coords.longitude + "&sensor=true&key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY";

        $.get(req, {}, (data) => {
            var post = data.results[0].address_components.filter(item => item.types.includes("postal_code"))[0].long_name
.replace(/\s/g, '');
            window.location.href = "/static/results.html?postal=" + post;
            });
        }
    );
}
