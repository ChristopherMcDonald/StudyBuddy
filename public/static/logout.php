<?php
// inits $_SESSION
session_start();

// effectively sign them out
$_SESSION["id"] = null;

// send to home
echo '<script>window.location.href = "/";</script>';

?>
