<!DOCTYPE html>
<html>
    <head>
        <?php include 'global.php'; getHeader('review'); ?>
    </head>
    <body>
        <?php getNav(); ?>
        <div class="main">
            <h1 class="title">Found a Study Space?</h1><br><br>
            <form class="form" action="POST"  onsubmit="validate(event);" action="/scripts/detailSubmission.php">
                <div class="form-entry">
                    <label for="name">Name</label><br>
                    <input type="text" name="name" id="name" required minlength="2">
                </div><br>

                <div class="form-entry">
                    <label for="address">Address</label><br>
                    <input type="text" name="address" id="address" required minlength="2">
                </div><br>

                <div class="form-entry">
                    <label for="city">City</label><br>
                    <input type="text" name="city" id="city" required minlength="2">
                </div><br>

                <div class="form-entry">
                    <label for="postalcode">Postal Code</label><br>
                    <input type="text" name="postalcode" id="postalcode" required minlength="6" maxlength="6">
                </div><br>

                <div class="form-entry">
                    <label for="wifi">How good was their Wifi (1-5)?</label><br>
                    <input type="number" name="wifi" id="wifi" required>
                </div><br><br>

                <div class="form-entry">
                    <label>Did they have coffee?</label><br><br>
                    <input type="radio" name="coffee" value="yes" id="coffee-y" required>
                    <label for="coffee-y">Yes</label>
                    <input type="radio" name="coffee" value="no" id="coffee-n">
                    <label for="coffee-n">No</label>
                </div><br><br>

                <div class="form-entry">
                    <label for="rating">How good is this Study Space (1-5)?</label><br>
                    <input type="number" name="rating" id="rating" required>
                </div><br>

                <div class="form-entry">
                    <label for="image">Have a photo?</label><br>
                    <input name="images" type="file" id="image" multiple accept="image/x-png, image/gif, image/jpeg, image/jpg">
                </div><br>

                <input type="submit" class="submit">
            </form>
        </div><!--.main-->
        <div id="error-disp">
            <i class="fa fa-times" onclick="hideError();"></i><p> Some ERROR </p>
        </div><!--.error-disp-->
        <footer>
            <p>Built by: Christopher McDonald</p>
            <p class="pull-right">Contact:
                <a href="mailto:mail@christophermcdonald.me">mail@christophermcdonald.me</a>
            </p>
        </footer>
    </body>
    <script src="../js/review.js"> </script>
    <script src="../js/global.js"></script>
</html>
