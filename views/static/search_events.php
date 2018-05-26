<!doctype HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script defer src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script defer
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <title>Kamps For Kids</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="views/styles/styles.css">
    <script defer src="views/scripts/main.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>

</head>
<body>
<div class="container" id ="searchEvents">
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
                <button class="btn btn-danger" type="button">Go!</button>
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

