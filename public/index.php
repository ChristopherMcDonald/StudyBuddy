<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
    <head>
        <?php include 'static/global.php'; getHeader('index'); ?>

        <!-- OpenGraph Metadata -->
        <meta property="og:image" content="https://www.studybuddy.world/img/overhead-study-overlay-small.jpg">
        <meta property="og:description" content="Trying to find a Study Space? Want to submit one?">
        <meta property="og:title" content="StudyBuddy - Find Your Study Space">
        <meta property="og:url" content="https://www.studybuddy.world">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="en_US" />
        <meta property="og:site_name" content="IMDb" />

        <!-- Twitter Metadata -->
        <meta name="twitter:title" content="StudyBuddy - Find Your Study Space">
    </head>
    <body>
        <?php getNav(); ?>

        <div class="splash">
            <div class="content">
                <h1 style="color: #8EE4AF">Just because studying is hard,<br>doesn't mean finding a study spot has to be.</h1>
                <br>
                <h1 style="color: white">Start your search today!</h1>
                <br><br>

                <form class="index-search-form">
                    <!-- <input name="address" type="text" class="search" placeholder="1 Microsoft Way"> -->
                    <label for="email">Email Address</label>
                    <input name="email" type="email" class="search" placeholder="john@locke.com">
                    <label for="pass">Password</label>
                    <input name="pass" type="password" class="search" placeholder="Password">
                    <input class="submit" name="submit" type="button" value="Sign In" onclick="signIn();">
                </form>
            </div><!--.content-->
        </div><!--.splash-->
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
    <script src="js/index.js"></script>
    <script src="js/global.js"></script>
</html>
