<?php
/**
 * Created by PhpStorm.
 * User: Harry
 * Date: 6/3/2018
 * Time: 10:39 AM
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.transitions.min.css'>

    <link rel="stylesheet" href="../styles/styles.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

</head>
<body id="events_body">
<center><h2>Public Events</h2></center>
<div id="main_content">

    <center>Filter by: <button type="button" onclick="swap_search_date()" onclass="btn btn-outline-dark">By Date</button>
        <button type="button" onclick="swap_search_distance()" onclass="btn btn-outline-dark">By Distance</button></center>

    <div id="distance_search_content" style="display: none" class="container">
        <?php include ('events_by_distance.php')?>
    </div>
    <div id="date_search_content" style="block" class="container">
        <?php include ('events_by_date.php') ?>
    </div>
</div>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

<script  src="../scripts/main.js"></script>
</body>
</html>
