/**
 * [validate validates input fields, navs to page / makes request on success]
 * @param  {[event]} ev [click event]
 * @return {none}
 */
validate = (ev) => {
    // stops form from posting / getting
    ev.preventDefault();

    $(".form > .submit").attr("disabled", "disabled");

    post = "../scripts/detailSubmission.php";

    $.ajax({
        url: post,
        data: new FormData($("form")[0]),
        processData: false,
        contentType: false,
        type: "POST",
        success: data => {
            res = JSON.parse(data);
            if(res.resp == 'valid') {
                window.location = "/static/detail/" + res.id;
            } else {
                displayError("Something went wrong... Please reload and try again.")
            }
            $(".form > .submit").removeAttr("disabled");
        },
        error: data => {
            console.log(data);
            $(".form > .submit").removeAttr("disabled");
        }
    });
};
