<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 5/19/2018
 * Time: 11:00 AM
 */

$today = new DateTime();
$today->format('Y-m-d H:i:s');
$twoMonths = new DateInterval("P2M" );
$inTwoMonths = date_add($today,$twoMonths );

$myEvents = event::getEventsByDateRange($today,$inTwoMonths);//Returns an array of events that will happen in the next two months

?>
<!DOCTYPE html>
<html xmlns:float="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../styles/styles.css">

    <script type="application/javascript" src="../scripts/main.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf6m35Pbc-BmCZzxrlUlCWmMpHOrWyMms&callback=initMap">
    </script>
</head>
<body>
<div class="container">
    <section id="top-nav_section">
        <div class="d-flex justify-content-between">
            <div class="p-2 my-flex-item">Welcome, user</div>
             <div class="p-2 my-flex-item">
                <a href="#">
                    <span class="glyphicons glyphicons-home">Home</span>
                </a>
            </div>
            <div class="p-2 my-flex-item"><a href="">Logout</a></div>
        </div>
    </section>
    <br>
    <section id="tabs_section" class="w-60 p-3 float-left clearfix">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#map" onclick="showMapHideCal()">Map</a></li>
            <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#list">List</a></li>-->
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#calendar" onclick="hideMapShowCal()">Calendar</a></li>
            <!-- search + filter -->
            <li id="filter_section" class="nav-item">
                <div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
                </span>
                        <div class="dropdown">
                            <div>

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
                </div>
            </li>
        </ul>
        <div class="col-sm-3">
            <div id="map" class="container tab-pane active"></div>
            <!-- require php script here to load variables but don't display on page -->
            <div id="list" class="container tab-pane fade" style="height: 0; width: 0">

            </div>
            <div id="calendar" class="container tab-pane fade align-top">
                <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;height=400&amp;wkst=1&amp;
                bgcolor=%23FFFFFF&amp;src=n2arhrlms9u36kgjs3sb8c2ago%40group.calendar.google.com&amp;color=%23AB8B00&amp;ctz=America%2FLos_Angeles"
                        style="border-width:0" width="500" height="400" frameborder="0" scrolling="no"></iframe>
            </div>
        </div>
    </section>
    <div class="col-sm-4 float-right clearfix">
        <ul class="list-group">
            <h3>Event List</h3>
            <li class="list-unstyled">All events <button type="button" class="btn float-right btn-primary dropdown-toggle" data-toggle="dropdown">
                    Filter by Kid
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Kid 1</a>
                    <a class="dropdown-item" href="#">Kid 2</a>
                    <a class="dropdown-item" href="#">Kid 3</a>
                    <a class="dropdown-item" href="#">Kid 4</a>
                </div></li>
                <?php
                    $eventCard = "%s";

                    for($i = 0; $i < 5; $i++)
                    {
                        printf($eventCard, $myEvents[$i]::getName());
                    }
                ?>
        </ul>
    </div>
    <section id="bottom-nav_section">
        <div class="d-flex justify-content-center fixed-bottom">
            <div class="p-2 my-flex-item"><a href="">Contact us</a></div>
            <div class="p-2 my-flex-item"><a href="">Terms of use</a></div>
            <div class="p-2 my-flex-item"><a href="">FAQs</a></div>
        </div>
    </section>
</div>
</body>
</html>
