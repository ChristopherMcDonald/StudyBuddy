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
        <link rel="stylesheet" href="../style/results.css">

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
            <br>
            <div class="map-wrap">
                <div id="map"></div><!--.map-->
            </div>
            <div class="tab">
                <?php
                include 'creds.php';

                $conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT s.id, s.name, s.address, s.city, s.postal, sum(r.coffee)/count(*) as coffeeCount, avg(r.rating) as avgRate, avg(r.wifi) as avgWifi FROM Spaces s JOIN Reviews r ON s.id = r.spaceId GROUP BY r.id";

                foreach($conn->query($sql) as $row) {
                    $sql2 = "SELECT si.* from SpaceImages si JOIN Reviews r ON si.reviewId = r.id JOIN Spaces s ON s.id = r.spaceId WHERE s.id = ".$row['id']." LIMIT 1;";

                    $rows = $conn->query($sql2)->fetchAll();

                    if (sizeof($rows) > 0) {
                        $row2 = $rows[0];
                        echo '<div class="item"><div class="img pull-left"><img src="'.$row2["imgLink"].'" alt="'.$row2["alt"].'"></div>';
                    } else {
                        echo '<div class="item"><div class="img pull-left"><img src="../img/coffee.jpg" alt="Sample Image"></div>';
                    }

                    echo '<div class="detail pull-left"><a href="/static/detail.html?id='.$row["id"].'">'.$row['name'].'</a>';
                    echo '<p class="">'.$row['address'].'</p>';
                    echo '<p class="">'.$row['city'].'</p>';
                    echo '<p class="">'.$row['postal'].'</p></div>';
                    echo '<div class="detail pull-right">';
                    echo '<p class="pull-right">Overall: '.floor($row['avgRate']).'/5</p><br>';
                    echo '<!-- coffee Count is '.$row["coffeeCount"].' -->';
                    if($row["coffeeCount"] > 0) {
                        echo '<i class="fa fa-coffee pull-right" aria-hidden="true"></i><br>';
                        echo '<span class="sr-only">This place has coffee!</span>';
                    }
                    echo '<div class="wifis pull-right">';
                    for($i = 0; $i < floor($row["avgWifi"]); $i++) {
                        echo '<i class="fa fa-wifi" aria-hidden="true"></i>';
                    }
                    echo '</div>';
                    echo '<span class="sr-only">Wifi Rating: '.floor($row["avgWifi"]).'/5</span></div>
                    </div><!--.item-->';
                }
                ?>
            </div><!--.tab-->
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
        $conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT s.id, s.name, s.address, s.city, s.postal FROM Spaces s;";
        $rows = $conn->query($sql)->fetchAll();
        $row_cnt = sizeof($rows);

        if($row_cnt > 0) {
            echo 'var list = [';
            for($j = 0; $j < $row_cnt - 1; $j++) {
                $row = $rows[$j];

                echo '{lat: 43.260806, lng: -79.920407, id: "'.$row["id"].'", name: "'.$row["name"].'", address: "'.$row["address"].'", city: "'.$row["city"].'",postal:"'.$row["postal"].'"},';
            }

            $row = end($rows);
            echo '{lat: 43.260806, lng: -79.920407, id: "'.$row["id"].'", name: "'.$row["name"].'", address: "'.$row["address"].'", city: "'.$row["city"].'",postal:"'.$row["postal"].'"}];';
        } else {
            echo "var list = [];";
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
                content: '<div id="content"><a href="/static/detail.html?id=' + item.id + '">' + item.name + '</a><p>' + item.address + '</p><p>' + item.city + '</p><p class="pull-left">' + item.postal + '</p></div>'
            });

            marker.addListener('click', function() {
                info.open(map, marker);
            });
        });
    }
    </script>
    <script src="../js/global.js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY&callback=initMap">
    </script>
</html>
