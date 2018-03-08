<?php
include '../static/creds.php';
require '../../vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
$credentials = new Aws\Credentials\Credentials($apikey,$secret);

$conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$name =     $_POST["name"];
$address =  $_POST["address"];
$city =     $_POST["city"];
$postal =   $_POST["postalcode"];
$wifi =     $_POST["wifi"];
$coffee =   $_POST["coffee"];
$coffeeDiff = strcmp($coffee,"yes");
if($coffeeDiff == 0) {
    $coffeeBool = 1;
} else {
    $coffeeBool = 0;
}

$rating =   $_POST["rating"];
$files =    $_FILES['images'];

$stmt = $conn->prepare("INSERT INTO Spaces (name, address, city, postal) VALUES (:name, :address, :city, :postal)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':city', $city);
$stmt->bindParam(':postal', $postal);

try {
    $stmt->execute();



    $spaceId = $conn->lastInsertId();

    $stmt2 = $conn->prepare("INSERT INTO Reviews (userId, spaceId, coffee, rating, wifi) VALUES (:userId, :spaceId, :coffee, :rating, :wifi)");
    $stmt2->bindValue(':userId', 2, PDO::PARAM_INT);
    $stmt2->bindValue(':spaceId', 2, PDO::PARAM_INT);
    $stmt2->bindValue(':coffee', 0, PDO::PARAM_INT);
    $stmt2->bindValue(':rating', 3, PDO::PARAM_INT);
    $stmt2->bindValue(':wifi', 2, PDO::PARAM_INT);

    $stmt2->execute();

    $reviewId = $conn->lastInsertId();

    $sharedConfig = [
        'region'  => 'ca-central-1',
        'version' => 'latest',
        'credentials' => $credentials
    ];

    $s3Client = new S3Client($sharedConfig);
    $bucket = "studybuddyimages";
    $file = $_FILES['images'];
    try {
        $result = $s3Client->putObject([
            'Bucket'     => $bucket,
            'ContentType' => $file['type'],
            'Key'        => $file['name'],
            'SourceFile' => $file['tmp_name']
        ]);

        $stmt = $conn->prepare("INSERT INTO SpaceImages (reviewId, alt, imgLink) VALUES (:reviewId, :alt, :imgLink)");
        $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->bindValue(':alt', $file['name']);
        $stmt->bindValue(':imgLink', $result['ObjectURL']);

        $stmt->execute();
        echo "added";
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
