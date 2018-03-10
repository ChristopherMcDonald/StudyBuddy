<?php
session_start();
include '../static/creds.php';
require '../../vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
$credentials = new Aws\Credentials\Credentials($apikey,$secret);

$conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_SESSION["id"];
if(!$id) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

$name =     $_POST["name"];
$address =  $_POST["address"];
$city =     $_POST["city"];
$postal =   $_POST["postalcode"];
$wifi =     $_POST["wifi"];
$coffee =   $_POST["coffee"];
$comment =  $_POST["comment"];
$coffeeDiff = strcmp($coffee,"yes");
if($coffeeDiff == 0) {
    $coffeeBool = 1;
} else {
    $coffeeBool = 0;
}

if(strlen($name) == 0 || strlen($address) == 0 || strlen($city) == 0) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

$postalExpression = '/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/';
$postalValid = (bool)preg_match($postalExpression, $postal);

if(!$postalValid) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

if(!$comment) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
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

    $stmt2 = $conn->prepare("INSERT INTO Reviews (userId, spaceId, coffee, rating, wifi, comment, visit) VALUES (:userId, :spaceId, :coffee, :rating, :wifi, :comment, NOW())");
    $stmt2->bindValue(':userId', $id, PDO::PARAM_INT);
    $stmt2->bindValue(':spaceId', $spaceId, PDO::PARAM_INT);
    $stmt2->bindValue(':coffee', $coffeeDiff, PDO::PARAM_INT);
    $stmt2->bindValue(':rating', $rating, PDO::PARAM_INT);
    $stmt2->bindValue(':wifi', $wifi, PDO::PARAM_INT);
    $stmt2->bindParam(':comment', $comment);

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
        $unencodedArray = ['resp' => 'valid', 'id' => $spaceId];
        echo json_encode($unencodedArray);
        return;
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>