<!DOCTYPE html>
<html>
    <?php include 'global.php'; getHeader('signup'); ?>
    <body>
        <?php getNav(); ?>
        <div class="main">
            <h1 class="title">Sign up for StudyBuddy!</h1>
            <br>
            <form class="form" action="POST" onsubmit="validate(event);">
                <div class="form-entry">
                    <label for="first">First Name</label><br>
                    <input type="text" name="first" id="first" required minlength="2">
                </div><br>

                <div class="form-entry">
                    <label for="first">Last Name</label><br>
                    <input type="text" name="last" id="last" required minlength="2">
                </div><br>

                <div class="form-entry">
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" required>
                </div><br>

                <div class="form-entry">
                    <label for="postal">Postal Code</label><br>
                    <input type="text" name="postal" id="postal" required minlength="6" maxlength="6">
                </div><br>

                <div class="form-entry">
                    <label for="pass">Password</label><br>
                    <input type="password" name="pass" id="pass" required minlength="6">
                </div><br>

                <div class="form-entry">
                    <label for="conf-pass">Confirm Password</label><br>
                    <input type="password" name="conf-pass" id="conf-pass" required minlength="6">
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
    <script src="../js/signup.js"> </script>
    <script src="../js/global.js"></script>
</html>
