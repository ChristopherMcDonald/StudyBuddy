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
        return false;
    } else {
        console.log("Postal is good!");
    }

    // pull the rest of data from form using input's name
    var wifi = $(".form-entry > input[name='wifi']").val();
    var coffee = $(".form-entry > input[name='coffee']").val();
    var rating = $(".form-entry > input[name='rating']").val();


    // TODO deal with images
    // TODO run ajax

};
