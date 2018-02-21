validate = (ev) => {
    ev.preventDefault();
    var fname = $(".form-entry > input[name='first']").val();
    var lname = $(".form-entry > input[name='last']").val();
    // name is handled in HTML
    var emailReg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var email = $(".form-entry > input[name='email']").val();

    if(!emailReg.test(email)) {
        return false;
    } else {
        console.log("Email is good!");
    }

    var postalReg = /([A-Z][0-9][A-Z][0-9][A-Z][0-9])/;
    var postal = $(".form-entry > input[name='postal']").val();

    if(!postalReg.test(postal)) {
        return false;
    } else {
        console.log("Postal is good!");
    }

    var passReg = new RegExp("^(?=.*[a-z|A-Z])(?=.*[0-9])(?=.{6,})");
    var pass = $(".form-entry > input[name='pass']").val();
    var cpass = $(".form-entry > input[name='conf-pass']").val();

    if(!passReg.test(pass)) {
        return false;
    } else {
        console.log("Pass is good!");
    }
    if(!passReg.test(cpass)) {
        return false;
    } else {
        console.log("Conf-Pass is good!");
    }
    if(pass !== cpass) {
        return false;
    } else {
        console.log("PASSes are good!");
    }

    // TODO run ajax
};
