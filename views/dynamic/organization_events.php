<?php

//Prints output from WEB service (http://developer.active.com/docs/read/Activity_APIs)

$api_key = "rjq7yk9u6bmm6fs5zhyx6dd2";
$ch = curl_init();
$url = "http://api.amp.active.com/v2/search?kids=true&category=event&start_date=2018-06-12..&near=Seattle,WA,US&radius=50&sort=date_asc&per_page=50&api_key=" . $api_key;

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
                                                    <p class="card-text register"> <a href="<?php echo $registrationUrlAdr; ?>"> Register </a> </p>
                                                <?php
                                                } else { ?>
                                                    <p class="card-text register"> Online Registration Not Available  <a href="<?php echo $registrationUrlAdr; ?>"> More Info </a></p>
                                                <?php
                                                }
                                            ?>

                                            <p class="card-text"> <?php echo $description; ?> </p>
                                            <p class="card-text"> Place: <?php echo $placeName; ?> </p>
                                        </div>
                                        <div class="card-footer">
                                            <button> Add to my event</button>
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
        <h1> My Events </h1>

        <div>
            <a href="#" id="username">user name</a>
        </div>
    </div>


</div>