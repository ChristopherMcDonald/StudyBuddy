/**
 * [displayError shows error as a banner, last 3 seconds and shows text only]
 * @param  {[String]} errorString [error to display, as a string]
 * @return {[none]}
 */
displayError = (errorString) => {
    $( "#error-disp > p" ).text(errorString);
    $( "#error-disp" ).animate({
        top: 0
    }, 500, () => {
        setTimeout(() => {
            $( "#error-disp" ).animate({
                top: '-8vh'
            }, 500);
            $( "#error-disp > p" ).text("");
        }, 3000);
    });
}

/**
 * [hideError hides the error banner]
 * @return {[none]}
 */
hideError = () => {
    $( "#error-disp" ).css('top','-8vh');
    $( "#error-disp > p" ).text("");
}
