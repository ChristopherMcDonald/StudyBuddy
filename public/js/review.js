validate = (ev) => {
    ev.preventDefault();
    var name = $(".form-entry > input[name='name']").val();
    var address = $(".form-entry > input[name='address']").val();
    var city = $(".form-entry > input[name='city']").val();
    var postal = $(".form-entry > input[name='postalcode']").val();

    var postalReg = /([A-Z][0-9][A-Z][0-9][A-Z][0-9])/;
    if(!postalReg.test(postal)) {
        return false;
    } else {
        console.log("Postal is good!");
    }

    var wifi = $(".form-entry > input[name='wifi']").val();
    var coffee = $(".form-entry > input[name='coffee']").val();
    var rating = $(".form-entry > input[name='rating']").val();


    // TODO deal with images
    // TODO run ajax

};
