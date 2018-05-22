<?php
/**
 * Created by PhpStorm.
 * User: Harry
 * Date: 5/14/2018
 * Time: 1:20 PM
 */
//Prints output from WEB service (http://developer.active.com/docs/read/Activity_APIs)

$api_key = "rjq7yk9u6bmm6fs5zhyx6dd2";
$ch = curl_init();
    $url = "http://api.amp.active.com/v2/search?query=running&category=event&start_date=2013-07-04..&near=Seattle,WA,US&radius=50&api_key=" . $api_key;

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
                print $v[$i]->assetTopics[0]->topic->topicName;
                print ", ";
                print $v[$i]->place->addressLine1Txt;
                print "<br>";
                $lat = $v[$i]->place->geoPoint->lat;
                $lng = $v[$i]->place->geoPoint->lon;
                $geo_locals[] = [$lat, $lng];
                //print $geo_local."<br>";
            } catch (Exception $e) {
                print $e->getMessage();
            }

        }
/*        foreach ($geo_locals as $locale) {
            foreach($locale as $city){
            echo $city." ";}
            echo "<br>";
        }*/


    }


}

?>

<script>
    var locations = <?php echo json_encode($geo_locals) ?>;
</script>
<script src="../scripts/main.js"></script>

