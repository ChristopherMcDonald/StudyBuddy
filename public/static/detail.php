<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>StudyBuddy</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Christopher McDonald">
        <meta name="description" content="A site for finding and reviewing Study Spaces!">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="../style/common.css">
        <link rel="stylesheet" href="../style/detail.css">

        <!-- FontAwesome CDN -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="header">
            <div class="left">
                <div class="name">
                    <a href="/">StudyBuddy</a>
                </div><!--.name-->
            </div><!--.left-->
            <div class="right">
                <i class="fa fa-bars hide-it" aria-hidden="true"></i>
                <div class="dropdown">
                        <ul class="nav">
                            <li><a href="/static/search.html">Custom Search</a></li>
                            <li><a href="/static/review.html">Review</a></li>
                            <li><a href="/static/signup.html">Sign Up</a></li>
                        </ul><!--.nav-->
                </div><!--.dropdown-->
            </div><!--.right-->
        </div><!--.header-->
        <div class="main">

            <div class="item">
                <!-- item consists of img on top, and two detail divs below it -->
                <?php
                include 'creds.php';

                $id = $_GET["id"];

                $conn = new mysqli($serv, $user, $pass, $name);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT s.id, s.name, s.address, s.city, s.postal, sum(r.coffee)/count(*) as coffeeCount, avg(r.rating) as avgRate, avg(r.wifi) as avgWifi FROM Spaces s JOIN Reviews r ON s.id = r.spaceId WHERE s.id = ". $id . " GROUP BY s.id;";
                $result = $conn->query($sql);

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();

                    $sql2 = "SELECT si.* from SpaceImages si JOIN Reviews r ON si.reviewId = r.id JOIN Spaces s ON s.id = r.spaceId WHERE s.id = ".$row['id']." LIMIT 1;";
                    $result2 = $conn->query($sql2);

                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        echo '<div class="img"><img src="'.$row2["imgLink"].'" alt="'.$row2["alt"].'"><div class="right-switch switch">
                            <i class="fa fa-3x fa-chevron-right" onclick="switchImage(\'right\');"></i>
                        </div>
                        <div class="left-switch switch">
                            <i class="fa fa-3x fa-chevron-left" onclick="switchImage(\'left\');"></i>
                        </div></div>';
                    } else {
                        // TODO handle
                        echo 'PROBLEM';
                    }

                    echo '<div class="detail pull-left">';
                    echo '<p>'.$row["name"].'</p>';
                    echo '<p>'.$row["address"].'</p>';
                    echo '<p>'.$row["city"].'</p>';
                    echo '<p>'.$row["postal"].'</p>';
                    echo '</div>';

                    echo '<div class="detail pull-right">';
                    echo '<p class="pull-right">Overall: '.floor($row["avgRate"]).'/5</p><br>';
                    if($row["coffeeCount"] > 0) {
                        echo '<i class="fa fa-coffee pull-right" aria-hidden="true"></i><br> <span class="sr-only">This place has coffee!</span>';
                    }
                    echo '<div class="wifis pull-right">';
                    for($i = 0; $i < floor($row["avgWifi"]); $i++) {
                        echo '<i class="fa fa-wifi" aria-hidden="true"></i>';
                    }
                    echo '</div>';
                    echo '<span class="sr-only">Wifi Rating: '.$row["avgWifi"].'/5</span>';
                    echo '</div><br><br>';
                }
                ?>



                <div id="map"></div>

                <div class="comments">
                    <h2>Comments</h2>
                    <div class="comment">
                        <!-- comment is split into two columns, and a footer for text -->
                        <div class="detail pull-left">
                            <p class="author">Chris</p><br>
                            <p class="date">Made on July 10, 2018</p><br>
                        </div>
                        <div class="detail pull-right">
                            <p class="rating">Rating: 4/5</p><br>
                            <i class="fa fa-coffee pull-right" aria-hidden="true"></i><br><br>
                            <p>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                            <p><br>
                        </div>
                        <p class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div><!--.comment-->

                    <div class="comment">
                        <div class="detail pull-left">
                            <p class="author">Chris</p><br>
                            <p class="date">Made on July 10, 2018</p><br>
                        </div>
                        <div class="detail pull-right">
                            <p class="rating">Rating: 4/5</p><br>
                            <i class="fa fa-coffee pull-right" aria-hidden="true"></i><br><br>
                            <p>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                        </p><br>
                        </div>
                        <p class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div><!--.comment-->

                    <div class="comment">
                        <div class="detail pull-left">
                            <p class="author">Chris</p><br>
                            <p class="date">Made on July 10, 2018</p><br>
                        </div>
                        <div class="detail pull-right">
                            <p class="rating">Rating: 4/5</p><br>
                            <i class="fa fa-coffee pull-right" aria-hidden="true"></i><br><br>
                            <p>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                            </p><br>
                        </div>
                        <p class="content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div><!--.comment-->
                </div><!--.comments-->
                <div class="bottom-right">
                    <button class="review-btn">Review</button>
                </div>
            </div><!--.item-->
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
    <script>
    /**
     * [initMap called by Google Maps API, initiates and binds to #map]
     * @return {none}
     */
    initMap = () => {
        <?php
        include 'creds.php';
        $conn = new mysqli($serv, $user, $pass, $name);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT s.id, s.name, s.address, s.city, s.postal FROM Spaces s WHERE s.id = " . $_GET["id"] .";";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            echo 'var list = [';
            $row_cnt = $result->num_rows;
            for($j = 0; $j < $row_cnt - 1; $j++) {
                $row = $result->fetch_assoc();

                echo '{lat: 43.260806, lng: -79.920407, id: "'.$row["id"].'", name: "'.$row["name"].'", address: "'.$row["address"].'", city: "'.$row["city"].'",postal:"'.$row["postal"].'"},';
            }
            $row = $result->fetch_assoc();

            echo '{lat: 43.260806, lng: -79.920407, id: "'.$row["id"].'", name: "'.$row["name"].'", address: "'.$row["address"].'", city: "'.$row["city"].'",postal:"'.$row["postal"].'"}];';
        } else {
            echo 'var list = [];';
        }
        ?>
        // build map object with Google Maps API
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,           // how zoomed in view is
            center: list[0]      // where map is centered
        });

        list.forEach((item) => {
            var marker = new google.maps.Marker({
                position: {lat: item.lat, lng: item.lng},   // where to place
                map: map,                                   // what map to put on
                title: item.name                            // title of it
            });

            var info = new google.maps.InfoWindow({
                // what will show when clicked
                content: '<div><a href="/static/detail.php?id=' + item.id + '">' + item.name + '</a><p>' + item.address + '</p><p>' + item.city + '</p><p>' + item.postal + '</p></div>'
            });

            marker.addListener('click', function() {
                info.open(map, marker);
            });
        });
    }

    <?php
    include 'creds.php';
    $conn = new mysqli($serv, $user, $pass, $name);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT si.imgLink FROM Spaces s JOIN Reviews r ON s.id = r.spaceId JOIN SpaceImages si ON si.reviewId = r.id WHERE s.id = " . $_GET["id"] .";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo 'var imgs = [';

        $row_cnt = $result->num_rows;
        for($j = 0; $j < $row_cnt - 1; $j++) {
            $row = $result->fetch_assoc();

            echo '"'. $row["imgLink"] .'",';
        }
        $row = $result->fetch_assoc();

        echo '"'. $row["imgLink"] .'"';
    } else {
        echo '"../img/coffee.jpg"';
    }
    echo '];'
    ?>

    /**
     * [switchImage switches the image in #img]
     * @param  {[String]} dir [left or right]
     * @return {[none]}
     */
    switchImage = (dir) => {
        console.log("ss");
        var index = imgs.indexOf($(".img > img").attr("src"));
        $(".img > img").attr("src", (dir == "right") ? imgs[(index + 1 + imgs.length) % imgs.length] : imgs[(index - 1 + imgs.length) % imgs.length]);
    }
    </script>
    <script src="../js/global.js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY&callback=initMap">
    </script>
</html>
