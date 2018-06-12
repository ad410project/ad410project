<?php
/**
 * Created by PhpStorm.
 * User: Harry
 * Date: 6/3/2018
 * Time: 10:41 AM
 */
//Prints output from WEB service (http://developer.active.com/docs/read/Activity_APIs)
$current_date = date('Y-m-d');
$api_key = "rjq7yk9u6bmm6fs5zhyx6dd2";
$ch = curl_init();
$url = "http://api.amp.active.com/v2/search/?near=Seattle%2CWA&radius=100&state=WA&kids=true&current_page=1&per_page=10&sort=distance&start_date=" . $current_date . "..&exclude_children=false&api_key="
    . $api_key;
//"http://api.amp.active.com/v2/search?query=running&category=event&start_date=2013-07-04..&near=Seattle,WA,US&radius=50&api_key="

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

foreach ($json_output as $k => $v) {
    if (0 == strcmp($k, "results")) {
        $geo_locals = array();
        for ($i = 0; $i < 10; $i++) {
            try {
                $type = $v[$i]->assetTopics[0]->topic->topicName;
                $name = $v[$i]->assetName;
                $sDate = $v[$i]->activityRecurrences[0]->activityStartDate;
                $eDate = $v[$i]->activityRecurrences[0]->activityEndDate;
                $e = substr($eDate, 0, 10);
                $s = substr($sDate, 0, 10);
                $s_date = new DateTime($s);
                $e_date = new DateTime($e);
                $start_date = $s_date->format('M d Y');
                $end_date = $e_date->format('M d Y');
                // print $update_date." - ".$type."<br>";
                $street = $v[$i]->place->addressLine1Txt;
                $city = $v[$i]->organization->addressCityName;
                $description = $v[$i]->assetDescriptions[0]->description;
                // print $name.", ".$address."<br><br>";
                $lat = $v[$i]->place->geoPoint->lat;
                $lng = $v[$i]->place->geoPoint->lon;
                $geo_locals[] = [$name, $description, $street, $city, $start_date, $end_date, $type];
                //print $geo_local."<br>";
            } catch (Exception $e) {
                print $e->getMessage();
            }

        }
    }


}
?>
<link rel="stylesheet" href="views/styles/org-carousel.css">

<div class="container">
    <div class="container-fluid">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner row w-100 mx-auto">

                <?php for ($i = 0; $i < count($geo_locals); $i++) : ?>

                <?php if ($i == 0) { ?>
                <div class="carousel-item col-md-4 active">
                    <?php } else {?>
                    <div class="carousel-item col-md-4">
                        <?php } ?>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $geo_locals[$i][0] ?></h4>
                                <p class="card-text"><?php echo $geo_locals[$i][4] . " - " . $geo_locals[$i][5] ?></p>
                                <p class="card-text"><?php echo $geo_locals[$i][2] . ", " . $geo_locals[$i][3] ?>, WA</p>
                            </div>
                            <div class="card-footer">
                                <div class="card-button">
                                    <a href="#">Add to my event</a>
                                </div>
                                <!-- TODO: Add function to add this event into events database-->
                            </div>
                        </div>
                    </div>

                    <?php endfor; ?>

                </div>
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

    </div>