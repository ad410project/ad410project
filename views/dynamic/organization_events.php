<?php

require_once('connection.php');
$link = Db::getInstance();
$sql = "SELECT * FROM Events"; // TODO: there should be a query to get events by user, for now selecting all events, need to be a backend call.
$allEvents = $link->query($sql);

$action = filter_input(INPUT_POST, 'action');
if ($action == 'delete_event') {
    $eventId = filter_input(INPUT_POST, 'eventId', FILTER_VALIDATE_INT);
    if ($eventId != NULL) {
        $query = "DELETE FROM Events WHERE eventId = $eventId"; // TODO: this needs to be a backend call
        $deletionResult = $link->query($query);
        $allEvents = $link->query($sql);
    }
}

//Prints output from WEB service (http://developer.active.com/docs/read/Activity_APIs)
$current_date = date('Y-m-d');
$api_key = "rjq7yk9u6bmm6fs5zhyx6dd2";
$ch = curl_init();
$url = "http://api.amp.active.com/v2/search?kids=true&category=event&start_date=" . $current_date . "..&near=Seattle,WA,US&radius=50&sort=date_asc&per_page=50&api_key=" . $api_key;

//Set the URL that you want to GET by using the CURLOPT_URL option.
curl_setopt($ch, CURLOPT_URL, $url);
//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//Set method to GET
curl_setopt($ch, CURLOPT_HTTPGET, true);
//Execute the request.
$data = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
$json_output = json_decode($data);
$results = $json_output->results;
?>


<div class="container">

    <div class="container-fluid">
        <h1 class="text-center mb-3">Events</h1>

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner row w-100 mx-auto">

                <?php
                    foreach ($results as $k => $v) {
                            $topicName = $v->assetTopics[0]->topic->topicName;
                            $topicTaxonomy = $v->assetTopics[0]->topic->topicTaxonomy;
                            $registrationUrlAdr = $v->registrationUrlAdr;
                            $addressUrl = $v->urlAdr;

                            $activityStartDate = $v->activityStartDate;
                            $activityEndDate = $v->activityEndDate;

                            $parsedStartDate =  substr($activityStartDate, 0, 10);
                            $parsedEndDate = substr($activityEndDate, 0, 10);

                            $sDate = new DateTime($parsedStartDate);
                            $eDate = new DateTime($parsedEndDate);
                            $start_date = $sDate->format('M d Y');
                            $end_date = $eDate->format('M d Y');

                            $placeName = $v->place->placeName;
                            $onlineRegistration = $v->assetLegacyData->onlineRegistration;
                            $description = $v->assetComponents[0]->assetName;

                            if ($k == 1) { ?>
                                <div class="carousel-item col-md-4 active">
                                <?php
                            } else { ?>
                                <div class="carousel-item col-md-4">
                            <?php
                            } // end else
                            ?>

                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $topicName; ?></h4>
                                            <?php
                                                if ($onlineRegistration)
                                                { ?>
                                                    <p class="card-text register"> <a href="<?php echo $registrationUrlAdr; ?>" target="_blank"> Register </a> </p>
                                                <?php
                                                } else { ?>
                                                    <p class="card-text register"> Online Registration Not Available  <a href="<?php echo $registrationUrlAdr; ?>" target="_blank"> More Info </a></p>
                                                <?php
                                                }
                                            ?>

                                            <p class="card-text"> <?php echo $description; ?> </p>
                                            <p class="card-text"> Place: <?php echo $placeName; ?> </p>
                                            <p class="card-text"> Dates: <?php echo $start_date; ?> - <?php echo $end_date; ?></p>
                                        </div>
                                        <div class="card-footer">
                                            <button> Add to my event</button>
                                            <!-- TODO: Add function to add this event into events database-->
                                        </div>
                                    </div>
                                </div>



                            <?php

                    } // end for-each
                ?>


            </div> <!--  end carousel-inner row w-100 mx-auto -->

            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="org_events">

        <br>
        <h4> My Events </h4>
        <a href="?controller=dynamic&action=addEvent"> Add new event </a>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Date</th>
                <th></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($allEvents as $event) : ?>
                <tr class="delete_mem<?php echo $event['id'];?>">

                    <td><?php echo $event['eventName']; ?></td>
                    <td><?php echo $event['eventDescription']; ?></td>

                    <td><?php
                        if (!empty($event['eventDate'])) {
                            $parsedEventDate = date('Y-m-d', strtotime($event['eventDate']));
                        }
                        echo $parsedEventDate; ?></td>

                    <td>
                        <form action="?controller=dynamic&action=editEvent" method="POST">
                            <input type="hidden" name="action"
                                   value="edit_events">

                            <input type="hidden" name="eventId"
                                   value="<?php echo $event['eventId']; ?>">

                            <button type="submit" class="btn btn-primary" name="edit_event_btn" id="<?php echo $event['eventId'];?>">Edit</button>
                        </form>
                    </td>

                    <td>
                        <form action="?controller=dynamic&action=organization_events" method="post">
                            <input type="hidden" name="action"
                                   value="delete_event">

                            <input type="hidden" name="eventId"
                                   value="<?php echo $event['eventId']; ?>">

                            <button type="submit" class="btn btn-danger" id="<?php echo $event['eventId'];?>">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>


</div>