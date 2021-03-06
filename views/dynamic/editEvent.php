<?php
$eventId = $_POST['eventId'];
require_once('connection.php');
$link = Db::getInstance();
$sql = "SELECT * FROM Events where eventId = $eventId"; // TODO: there should be a query to get events by user, for now selecting all events by event id.
$event = $link->query($sql);

$getEventName = null;
$getEventDesc = null;
$getMinAge = null;
$getMaxAge = null;
$getEventDate = null;
$getRegistrationOpenDate = null;
$getRegistrationCloseDate = null;

foreach ($event as $eachEvent) :
    $getEventName = $eachEvent['eventName'];
    $getEventDesc = $eachEvent['eventDescription'];
    $getMinAge = $eachEvent['minAge'];
    $getMaxAge = $eachEvent['maxAge'];

    if (!empty($eachEvent['eventDate'])) {
        $parsedEventDate = date('Y-m-d', strtotime($eachEvent['eventDate']));
        $getEventDate = $parsedEventDate;
    }

    if (!empty($eachEvent['registrationOpen'])) {
        $parsedRegOpenDate = date('Y-m-d', strtotime($eachEvent['registrationOpen']));
        $getRegistrationOpenDate = $parsedRegOpenDate;
    }

    if (!empty($eachEvent['registrationClose'])) {
        $parsedRegCloseDate = date('Y-m-d', strtotime($eachEvent['registrationClose']));
        $getRegistrationCloseDate = $parsedRegCloseDate;
    }

endforeach;
?>

?>
<br>
<br>
<br>

<!-- TODO: add action once the form is submitted-->
<form name="editEventsForm" action="#" method="post">

    <div class="container">

        <h3>Edit Event</h3>

        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="eventName" placeholder="Enter event name" name="eventName" value="<?php echo $getEventName?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <textarea class="form-control" rows="5" id="eventDescription" placeholder="Enter event description"
                          name="eventDescription"><?php echo $getEventDesc?>
                </textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="minAge">Min Age</label>
                <input type="text" class="form-control" id="ageMin" placeholder="Enter minimum age" name="ageMin"
                       value="<?php echo  $getMinAge?>">
            </div>

            <div class="form-group col-md-2">
                <label for="maxAge">Max Age</label>
                <input type="text" class="form-control" id="ageMax" placeholder="Enter maximum age" name="ageMax"
                       value="<?php echo  $getMaxAge?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="regOpenDate">Registration Open Date</label>
                <input type="date" class="form-control" id="registrationOpenDate"  name="registrationOpenDate"
                       value="<?php echo  $getRegistrationOpenDate?>">
            </div>

            <div class="form-group col-md-2">
                <label for="regCloseDate">Registration Close Date</label>
                <input type="date" class="form-control" id="registrationCloseDate"  name="registrationCloseDate"
                       value="<?php echo  $getRegistrationCloseDate?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-1">
                <label for="regOpenDate">Event Date</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="eventDate" placeholder="Enter event date" name="eventDate"
                       value="<?php print  $getEventDate?>">
            </div>
        </div>

        <button type="button" class="btn btn-light btn-rounded" onclick="window.history.back();" > Go Back </button>
        <button type="submit" class="btn btn-info btn-rounded">Update my event</button>

        <br><br><br>
    </div> <!-- end of div container -->


</form>