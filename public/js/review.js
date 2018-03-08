/**
 * [validate validates input fields, navs to page / makes request on success]
 * @param  {[event]} ev [click event]
 * @return {none}
 */
validate = (ev) => {
    // stops form from posting / getting
    ev.preventDefault();

    // pull first data from form using input's name
    var name = $(".form-entry > input[name='name']").val();
    var address = $(".form-entry > input[name='address']").val();
    var city = $(".form-entry > input[name='city']").val();
    var postal = $(".form-entry > input[name='postalcode']").val().toUpperCase();

    // regex for checking postal codes, only allows form: A1A1A1
    var postalReg = /([A-Z][0-9][A-Z][0-9][A-Z][0-9])/;
    if(!postalReg.test(postal)) {
        displayError("Ensure the postal code follows the form: A1A1A1");
        return false;
    }

    // pull the rest of data from form using input's name
    var wifi = $(".form-entry > input[name='wifi']").val();
    var coffee = $(".form-entry > input[name='coffee']").val();
    var rating = $(".form-entry > input[name='rating']").val();

    var fd = new FormData();
    var file_data = $('.form-entry > input[type=\'file\']')[0].files;
    fd.append("files", file_data);
    fd.append("name", name);
    fd.append("address", address);
    fd.append("city", city);
    fd.append("postal", postal);
    fd.append("wifi", wifi);
    fd.append("coffee", coffee == "YES" ? 1 : 0);
    fd.append("rating", rating);

    $.ajax({
        url: "../scripts/detailSubmission.php",
        data: new FormData($("form")[0]),
        processData: false,
        contentType: false,
        type: "POST",
        success: data => {
            console.log(data);
        },
        error: data => {
            console.log(data);
        }
    });
};
