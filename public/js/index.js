/**
 * [signIn sends request to signin]
 * @return {[none]}
 */
signIn = () => {

    mail = $(".index-search-form > input[name='email']").val();
    pass = $(".index-search-form > input[name='pass']").val();

    $.post("../scripts/signIn.php", {
        email: mail,
        pass: pass
    }).then(data => {
        ret = JSON.parse(data);
        if(ret.resp == "valid user") {
            window.location = "/static/search.php";
        } else {
            displayError("Wrong Password! Please try again.");
        }
    });
}

$(".index-search-form > input[name='pass']").keyup(function(event) {
    if (event.keyCode === 13) {
        signIn();
    }
});

$(".index-search-form > input[name='email']").keyup(function(event) {
    if (event.keyCode === 13) {
        signIn();
    }
});
