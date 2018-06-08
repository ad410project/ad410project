<?php
/**
 * Created by PhpStorm.
 * User: Harry
 * Date: 6/3/2018
 * Time: 10:40 AM
 */
//Prints output from WEB service (http://developer.active.com/docs/read/Activity_APIs)
$current_date = date('Y-m-d');
$api_key = "rjq7yk9u6bmm6fs5zhyx6dd2";
$ch = curl_init();
$url = "http://api.amp.active.com/v2/search/?radius=100&city=Seattle&state=WA&kids=true&current_page=1&per_page=10&sort=date_asc&start_date=" . $current_date . "..&exclude_children=false&api_key="
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
        $geo_locals_date = array();
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
                $geo_locals_date[] = [$name, $description, $street, $city, $start_date, $end_date, $type];
                //print $geo_local."<br>";
            } catch (Exception $e) {
                print $e->getMessage();
            }

        }


    }


}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="carousel-container">
            <ul>
                <?php for ($i = 0; $i < count($geo_locals_date); $i++) : ?>
                    <li>
                        <div class="card">
                            <!--                        <img class="card-img-top img-fluid" src="http://placehold.it/318x180" alt="Card image cap">-->
                            <div class="card-block">
                                <p class="card-title"><?php echo $geo_locals_date[$i][0] ?></p>
                                <p class="card-text"><?php echo $geo_locals_date[$i][4] . " - " . $geo_locals_date[$i][5] ?></p>
                                <p class="card-text"><?php echo $geo_locals_date[$i][2] . ", " . $geo_locals_date[$i][3] ?>
                                    , WA</p>
                                <div class="card-button" style="width: 100%">
                                    <a style="width: 150px" href="#myModal1" data-id="<?php echo $i ?>"
                                       class="open-AddBookDialog1 btn btn-info btn-sm" data-toggle="modal">More Info</a>
                                </div>
                            </div>
                        </div>
                    </li>  <?php endfor; ?>
            </ul>
        </div>
    </div>
</div>
<div class="modal" id="myModal1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Event Information</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="description"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on("click", ".open-AddBookDialog1", function () {
        var local = <?php echo json_encode($geo_locals_date) ?>;
        var myBookId = $(this).data('id');
        var value = local[myBookId][1];
        $(".modal-body #description").html(value);
        $('#AddBookDialog1').modal('show');
    });
</script>
