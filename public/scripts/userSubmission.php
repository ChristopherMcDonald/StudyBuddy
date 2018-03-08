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

$stmt = $conn->prepare("INSERT INTO Users (firstName, lastName, email, postal, password) VALUES (:firstName, :lastName, :email, :postal, :password)");
$stmt->bindParam(':firstName', $first);
$stmt->bindParam(':lastName', $last);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':postal', $postal);
$stmt->bindParam(':password', password_hash($pass, PASSWORD_BCRYPT));

try {
    $stmt->execute();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
