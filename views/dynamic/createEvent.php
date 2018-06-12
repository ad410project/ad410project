<?php

function createEvent()
{

    $eventName = $_POST['eventName'];
    $eventDesc = $_POST['eventDescription'];
    $ageMin = $_POST['ageMin'];
    $ageMax = $_POST['ageMax'];
    $regOpenDate = $_POST['registrationOpenDate'];
    $regCloseDate = $_POST['registrationCloseDate'];
    $eventDate = $_POST['eventDate'];

    $event = new event($eventName, $eventDesc, '', '',
        '', '', '', $eventDate, '', 2, '',
        '', 1, $ageMin, $ageMax, $regOpenDate, $regCloseDate);

    $event->addEvent1($event);

    header('addEvent.php');
    echo $eventName;
    echo $eventDate;
    }

//    if (isset($_POST['eventName'])) {
    createEvent();
//    }
?>
