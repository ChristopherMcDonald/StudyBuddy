<?php
include '../static/creds.php';
$conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$first = $_POST["first"];
$last = $_POST["last"];
$email = $_POST["email"];
$postal = $_POST["postal"];
$pass = $_POST["pass"];
$conf = $_POST["conf"];

if(strlen($first) == 0 || strlen($last) == 0) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

$postalExpression = '/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/';
// lower, no space
$postalValid = (bool)preg_match($postalExpression, $postal);

if(!$postalValid) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

// restricts passwords to be 6 chars, include at least one letter and one number
$passExpression = "/^(?=.*[a-z])(?=.*\\d).{6,}$/i";

$passValid = (bool)preg_match($passExpression, $pass);

if(!$passValid) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

$confValid = (bool)preg_match($passExpression, $conf);

if(!$confValid) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

if(strcmp($pass, $conf) !== 0) {
    $unencodedArray = ['resp' => 'invalid'];
    echo json_encode($unencodedArray);
    return;
}

$stmt = $conn->prepare("INSERT INTO Users (firstName, lastName, email, postal, password) VALUES (:firstName, :lastName, :email, :postal, :password)");
$stmt->bindParam(':firstName', $first);
$stmt->bindParam(':lastName', $last);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':postal', $postal);
$stmt->bindParam(':password', password_hash($pass, PASSWORD_BCRYPT));

try {
    $stmt->execute();
    $unencodedArray = ['resp' => 'valid'];
    echo json_encode($unencodedArray);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
