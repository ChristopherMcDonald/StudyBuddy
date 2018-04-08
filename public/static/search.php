<!DOCTYPE html>
<html>
    <head>
        <?php include 'global.php'; getHeader('search'); ?>
    </head>
    <body>
        <?php getNav(); ?>
        <div class="main">
            <h1 class="title">Find a Study Space!</h1><br><br>

            <form method="GET" class="form" action="/results">
                <div class="form-entry">
                    <label for="name">Name</label><br>
                    <input type="text" name="name" id="name">
                </div><br>

                <div class="form-entry">
                    <label for="postal">Postal Code</label><br>
                    <input type="text" name="postal" id="postal">
                </div><br>

                <div class="form-entry">
                    <label for="wifi">Wifi Rating (Minimum)</label><br>
                    <input type="number" name="wifi" id="wifi" min="1" max="5">
                </div><br><br>

                <div class="form-entry">
                    <label>Want Coffee?</label><br><br>
                    <input type="radio" name="coffee" value="yes" id="coffee-y">
                    <label for="coffee-y">Yes</label>
                    <input type="radio" name="coffee" value="no" id="coffee-n">
                    <label for="coffee-n">No</label>
                </div><br><br>

                <div class="form-entry">
                    <label for="rating">Overall Rating (Minimum)</label><br>
                    <input type="number" name="rating" id="rating" min="1" max="5">
                </div><br>

                <input type="hidden" name="lat" value="">
                <input type="hidden" name="lng" value="">

                <input type="submit" class="submit">
                <input type="button" class="submit near-me" value="Find Near Me" onclick="findNearMe();">
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
    <script src="../js/search.js"> </script>
    <script src="../js/global.js"></script>
</html>
