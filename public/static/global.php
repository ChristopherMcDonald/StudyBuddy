<?php
session_start();

function getHeader($page) {
    echo '<meta charset="utf-8">
    <title>StudyBuddy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Christopher McDonald">
    <meta name="description" content="A site for finding and reviewing Study Spaces!">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style/common.css">
    <link rel="stylesheet" href="../style/'.$page.'.css">

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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>';
}

function getNav() {
    echo '
    <div class="header">
        <div class="left">
            <div class="name">
                <a href="/">StudyBuddy</a></div><!--.name-->
            </div><!--.left-->
        <div class="right">
            <i class="fa fa-bars hide-it" aria-hidden="true"></i>
            <div class="dropdown">
                <ul class="nav">
                    <li><a href="/static/search.php">Custom Search</a></li>
                    <li><a href="/static/review.php">Review</a></li>';
    if($_SESSION["id"]) {
        echo '<li><a href="/static/logout.php">Log Out</a></li>';
    } else {
        echo '<li><a href="/static/signup.php">Sign Up</a></li>';
    }

    echo '</ul><!--.nav-->
            </div><!--.dropdown-->
        </div><!--.right-->
    </div><!--.header-->';
}
 ?>
