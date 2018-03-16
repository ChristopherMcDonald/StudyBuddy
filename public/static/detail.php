<!-- page for a single item in database, expects id in URL -->
<!DOCTYPE html>
<html>
    <head>
        <?php include 'global.php'; getHeader('detail'); ?>
    </head>
    <body>
        <?php getNav(); ?>
        <div class="main">

            <div class="item">
                <!-- item consists of img on top, and two detail divs below it -->
                <?php
                include 'creds.php';

                // get ID from url, send to search if missing
                $id = $_GET["id"];
                if(!$id) {
                    echo '<script>window.location.href = "/search";</script>';
                }

                // build connection to MySQL DB
                $conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $spaceQuery = "SELECT s.*, sum(r.coffee)/count(*) as coffeeCount, avg(r.rating) as avgRate, avg(r.wifi) as avgWifi FROM Spaces s JOIN Reviews r ON s.id = r.spaceId WHERE s.id = ". $id . "  GROUP BY s.id;";

                foreach($conn->query($spaceQuery) as $row) {
                    // used below, will only run once due to ID where clause
                    $globalRow = $row;
                    $imgQuery = "SELECT si.* from SpaceImages si JOIN Reviews r ON si.reviewId = r.id JOIN Spaces s ON s.id = r.spaceId WHERE s.id = ".$row['id']." LIMIT 1;";

                    $imgRows = $conn->query($imgQuery)->fetchAll();

                    if(sizeof($imgRows) > 0) {
                        $row2 = $imgRows[0];
                        echo '<div class="img"><img src="'.$row2["imgLink"].'" alt="'.$row2["alt"].'"><div class="right-switch switch">
                            <i class="fa fa-3x fa-chevron-right" onclick="switchImage(\'right\');"></i>
                        </div>
                        <div class="left-switch switch">
                            <i class="fa fa-3x fa-chevron-left" onclick="switchImage(\'left\');"></i>
                        </div></div>';
                    } else {
                        echo '<div class="img"><img src="../img/coffee.jpg" alt="Coffee"><div class="right-switch switch">
                            <i class="fa fa-3x fa-chevron-right" onclick="switchImage(\'right\');"></i>
                        </div>
                        <div class="left-switch switch">
                            <i class="fa fa-3x fa-chevron-left" onclick="switchImage(\'left\');"></i>
                        </div></div>';
                    }

                    echo '<div class="detail pull-left">';
                    echo '<p>'.$row["name"].'</p>';
                    echo '<p>'.$row["address"].'</p>';
                    echo '<p>'.$row["city"].'</p>';
                    echo '<p>'.$row["province"].'</p>';
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
                    echo '<span class="sr-only">Wifi Rating: '.floor($row["avgWifi"]).'/5</span>';
                    echo '</div><br><br>';

                    echo '<div id="map"></div>';
                }

                $reviewQuery = "SELECT r.*, u.firstName FROM Spaces s JOIN Reviews r ON s.id = r.spaceId JOIN Users u ON r.userId = u.id WHERE s.id = ". $id . ";";

                echo '<div class="comments"><h2>Comments</h2>';
                foreach($conn->query($reviewQuery) as $row) {
                    $date = strtotime($row["visit"]);
                    echo '<div class="comment">
                        <!-- comment is split into two columns, and a footer for text -->
                        <div class="detail pull-left">';
                    echo '<p class="author">'.$row["firstName"].'</p><br>
                    <p class="date">Made on '.date('F d\, Y', $date).'</p><br></div>';
                    echo '<div class="detail pull-right">
                        <p class="rating">Rating: '.$row["rating"].'/5</p><br>';
                    if($row["coffee"] == 1) {
                        echo '<i class="fa fa-coffee pull-right" aria-hidden="true"></i><br><br>';
                    }
                    echo '<p>';
                    for($j = 0; $j < $row["wifi"]; $j = $j + 1) {
                        echo '<i class="fa fa-wifi" aria-hidden="true"></i>';
                    }
                    echo '</p><br></div>';
                    echo '<p class="content">'.$row["comment"].'</p></div>';
                }
                echo '</div>';

                if($_SESSION["id"]) {
                    echo '<div class="bottom-right"><button class="review-btn">Review</button></div>';
                }
                ?>
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
        // build custom SQL query for all Spaces
        $sql = "SELECT * FROM Spaces s WHERE id = ". $id;

        // builds lists of JSON objects to parse over
        echo 'var list = [';
        foreach($conn->query($sql) as $row) {
            // fill in objects with lat/lng, addresses and names
            echo '{lat: '.$row["lat"].', lng: '.$row["lng"].', id: "'.$row["id"].'", name: "'.$row["name"].'", address: "'.$row["address"].'", city: "'.$row["city"].'", province: "'.$row["province"].'", postal:"'.$row["postal"].'"},';
        }
        // close off list
        echo '];';
        ?>

        list = list.filter(item => item.lat !== -1 && item.lng !== -1);
        // build map object with Google Maps API
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: list[0] ? 10 : 0,           // how zoomed in view is
            center: list[0] ? list[0] : {lat: -1, lng: -1}      // where map is centered
        });

        list.forEach((item) => {
            var marker = new google.maps.Marker({
                position: {lat: item.lat, lng: item.lng},   // where to place
                map: map,                                   // what map to put on
                title: item.name                            // title of it
            });

            var info = new google.maps.InfoWindow({
                // what will show when clicked
                content: '<div><a href="/detail?id=' + item.id + '">' + item.name + '</a><p>' + item.address + '</p><p>' + item.city + '</p><p>' + item.postal + '</p></div>'
            });

            marker.addListener('click', function() {
                info.open(map, marker);
            });
        });
    }

    <?php
    $conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT si.imgLink FROM Spaces s JOIN Reviews r ON s.id = r.spaceId JOIN SpaceImages si ON si.reviewId = r.id WHERE s.id = " . $_GET["id"] .";";

    $rows = $conn->query($sql)->fetchAll();
    $row_cnt = sizeof($rows);

    if($row_cnt > 0) {
        echo 'var imgs = [';

        for($j = 0; $j < $row_cnt - 1; $j++) {
            $row = $rows[$j];

            echo '"'. $row["imgLink"] .'",';
        }

        echo '"'. end($rows)["imgLink"] .'"];';
    } else {
        echo 'var imgs = ["../img/coffee.jpg"];';
    }
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

    $(".review-btn").click(() => {
        <?php
            echo 'window.location = "/review?id='.$globalRow["id"].'&name='.$globalRow["name"].'&address='.$globalRow["address"].'&city='.$globalRow["city"].'&prov='.$globalRow["province"].'&postal='.$globalRow["postal"].'";';
        ?>
    });
    </script>
    <script src="../js/global.js"></script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAj6W1p_IKsLfigZ805LdoyrYWcj6samY&callback=initMap">
    </script>
</html>
