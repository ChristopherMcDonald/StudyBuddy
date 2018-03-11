<!DOCTYPE html>
<html>
    <head>
        <?php include 'global.php'; getHeader('results');  ?>
    </head>
    <body>
        <?php getNav(); ?>
        <div class="main">
            <br>
            <div class="map-wrap">
                <div id="map"></div><!--.map-->
            </div>
            <div class="tab">
                <?php
                // pulls necessary variables into global scope, add custom creds.php for every machine
                include 'creds.php';

                // build connection to MySQL DB
                $conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // gets data for every Space, along with average ratings for wifi / reviews and if they have coffee or not
                $sql = "SELECT s.id, s.name, s.address, s.city, s.postal, s.province, sum(r.coffee)/count(*) as coffeeCount, avg(r.rating) as avgRate, avg(r.wifi) as avgWifi FROM Spaces s JOIN Reviews r ON s.id = r.spaceId GROUP BY r.id";

                // iterate over rows returned, accessible by $row
                foreach($conn->query($sql) as $row) {
                    // pulls top image submitted by users
                    $sql2 = "SELECT si.* from SpaceImages si JOIN Reviews r ON si.reviewId = r.id JOIN Spaces s ON s.id = r.spaceId WHERE s.id = ".$row['id']." LIMIT 1;";

                    // get row, in an array
                    $rows = $conn->query($sql2)->fetchAll();

                    // if image is available, else otherwise
                    if (sizeof($rows) > 0) {
                        $row2 = $rows[0];
                        echo '<div class="item"><div class="img pull-left"><img src="'.$row2["imgLink"].'" alt="'.$row2["alt"].'"></div>';
                    } else {
                        // inserts sample image
                        echo '<div class="item"><div class="img pull-left"><img src="../img/coffee.jpg" alt="Sample Image"></div>';
                    }

                    echo '<div class="detail pull-left"><a href="/static/detail.php?id='.$row["id"].'">'.$row['name'].'</a>';
                    echo '<p class="">'.$row['address'].'</p>';
                    echo '<p class="">'.$row['city'].'</p>';
                    echo '<p class="">'.$row['province'].'</p>';
                    echo '<p class="">'.$row['postal'].'</p></div>';
                    echo '<div class="detail pull-right">';
                    echo '<p class="pull-right">Overall: '.floor($row['avgRate']).'/5</p><br>';
                    echo '<!-- coffee Count is '.$row["coffeeCount"].' -->';
                    // if they have coffee...
                    if($row["coffeeCount"] > 0) {
                        echo '<i class="fa fa-coffee pull-right" aria-hidden="true"></i><br>';
                        echo '<span class="sr-only">This place has coffee!</span>';
                    }
                    echo '<div class="wifis pull-right">';
                    // for every wifi rating... e.g. twice for 2/5
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
        // build custom SQL query for all Spaces
        $sql = "SELECT * FROM Spaces s;";

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
                content: '<div id="content"><a href="/static/detail.php?id=' + item.id + '">' + item.name + '</a><p>' + item.address + '</p><p>' + item.city + '</p><p class="pull-left">' + item.postal + '</p></div>'
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
