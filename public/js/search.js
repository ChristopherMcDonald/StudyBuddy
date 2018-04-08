/**
 * [findNearMe directly navigates to search page using postal code, uses HTML5 geolocation]
 * @return {none}
 */
findNearMe = () => {
    navigator.geolocation.getCurrentPosition((pos) => {
        $("form input[name='lng']").val(pos.coords.longitude);
        $("form input[name='lat']").val(pos.coords.latitude);

        $("form").submit();
    });
}
