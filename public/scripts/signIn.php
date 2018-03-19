<?php
require '../../vendor/autoload.php';
include '../static/creds.php';
use \Firebase\JWT\JWT;

session_start();
$conn = new PDO("mysql:host=$serv;dbname=$name", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email = $_POST["email"];
$pass = $_POST["pass"];

$sql = 'SELECT id, firstName, password FROM Users WHERE email = "'. $email . '" LIMIT 1';
$user = $conn->query($sql)->fetchAll();

if (sizeof($user) == 1) {
    if(password_verify($pass, $user[0]["password"])) {
        $issuedAt = time();
        $notBefore  = $issuedAt + 10;             //Adding 10 seconds
        $expire     = $notBefore + 60;            // Adding 60 seconds

        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'nbf'  => $notBefore,        // Not before
            'exp'  => $expire,           // Expire
            'data' => [                  // Data related to the signer user
                'userId'   => $user[0]["id"] // userid from the users table
            ]
        ];

        $jwt = JWT::encode(
            $data,      //Data to be encoded in the JWT
            $signingKey, // The signing key
            'HS512'     // Algorithm used to sign the token, see
        );

        $unencodedArray = ['jwt' => $jwt, 'resp' => 'valid user'];
        $_SESSION["id"] = $user[0]["id"];
        $_SESSION["name"] = $user[0]["firstName"];
        echo json_encode($unencodedArray);
    } else {
        $unencodedArray = ['resp' => 'invalid user'];
        echo json_encode($unencodedArray);
    }
} else {
    $unencodedArray = ['resp' => 'invalid user'];
    echo json_encode($unencodedArray);
}

$conn = null;
?>
