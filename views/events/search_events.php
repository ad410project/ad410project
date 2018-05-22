<?php
/**
 * Created by PhpStorm.
 * User: Harry
 * Date: 5/8/2018
 * Time: 3:55 PM
 */

?>


<!DOCTYPE html>
<html xmlns:float="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../styles/styles.css">

    <script src="../scripts/main.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf6m35Pbc-BmCZzxrlUlCWmMpHOrWyMms&callback=initMap">
    </script>
</head>
<body>
<div class="container">
    <h3>Search Events</h3>
    <br>
    <section id="tabs_section">

        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#map">Map</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#list">List</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#calendar">Calendar</a></li>
        </ul>
        <div class="tab-content">
            <div id="map" class="container tab-pane active"></div>

            <div id="list" class="container tab-pane fade">
                <?php require('search_events_curlAPI.php'); ?>
            </div>

            <div id="calendar" class="container tab-pane fade">
                <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;height=400&amp;wkst=1&amp;
                bgcolor=%23FFFFFF&amp;src=n2arhrlms9u36kgjs3sb8c2ago%40group.calendar.google.com&amp;color=%23AB8B00&amp;ctz=America%2FLos_Angeles"
                        style="border-width:0" width="500" height="400" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </section>
    <section id="filter_section">

        <div class="col-lg-12">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
                </span>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Filter
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Filter 1</a>
                        <a class="dropdown-item" href="#">Filter 2</a>
                        <a class="dropdown-item" href="#">Filter 3</a>
                        <a class="dropdown-item" href="#">Filter 4</a>
                    </div>
                </div>
            </div>
        </div>


    </section>
</div>

</body>
</html>

