/**
 * [validate validates input fields, navs to page / makes request on success]
 * @param  {[event]} ev [click event]
 * @return {none}
 */
validate = (ev) => {
    // prevents form from posting / getting
    ev.preventDefault();

    // pull all data from fields
    var fname = $(".form-entry > input[name='first']").val();
    var lname = $(".form-entry > input[name='last']").val();
    var email = $(".form-entry > input[name='email']").val();
    var postal = $(".form-entry > input[name='postal']").val();
    var pass = $(".form-entry > input[name='pass']").val();
    var cpass = $(".form-entry > input[name='conf-pass']").val();

    // allows string of valid email form
    var emailReg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    // test email validity
    if(!emailReg.test(email)) {
        displayError("Oops! The email doesn't look quite right...");
        return false;
    } else {
        console.log("Email is good!");
    }

    // regex for checking postal codes, only allows form: A1A1A1
    var postalReg = /([A-Z][0-9][A-Z][0-9][A-Z][0-9])/;

    // test postal validity
    if(!postalReg.test(postal)) {
        displayError("Oops! The postal code doesn't look quite right...");
        return false;
    } else {
        console.log("Postal is good!");
    }

    // restricts passwords to be 6 chars, include at least one letter and one number
    var passReg = new RegExp("^(?=.*[a-z|A-Z])(?=.*[0-9])(?=.{6,})");

    // test both passwords
    if(!passReg.test(pass)) {
        displayError("Oops! Your password should be 6 characters and have 1 letter and number.");
        return false;
    } else {
        console.log("Pass is good!");
    }

    if(!passReg.test(cpass)) {
        displayError("Oops! Your password should be 6 characters and have 1 letter and number.");
        return false;
    } else {
        console.log("Conf-Pass is good!");
    }

    // ensure passwords are identical
    if(pass !== cpass) {
        displayError("Oops! Your passwords don't match!");
        return false;
    } else {
        console.log("PASSes are good!");
    }

    // TODO run ajax
};
