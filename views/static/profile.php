<?php

// Initialize the session
session_start();

require_once('connection.php');
$link = Db::getInstance();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['emailAddress'])) {
    header("location: ?controller=static&action=login");
    exit;
} else {
    $emailAddress = $_SESSION['emailAddress'];
    $sql = "SELECT * FROM Users WHERE email='$emailAddress'";
    $result = $link->query($sql);

    echo '<div style="margin:20px;margin-top:60px;">';
    echo '<h1>Profile</h1>';
    echo '<p><img src="https://diasporatchadienne.blob.core.windows.net/images/http://diasporatchadienne.blob.core.windows.net/images/508-CampusCool.jpg" style="height:150px;" /></p>';
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            //echo '<p>Name: ' . $row["username"] . '</p>';
            echo '<p>Email: ' . $row["email"] . '</p>';
            echo '<p>Firsname: ' . $row["firstName"] . '</p>';
            echo '<p>Lastname: ' . $row["lastName"] . '</p>';
            $role = "";
            if($row["userTypeId"] == 1){
                $role = "Individual User";
            }else{
                $role = "Organization";
            }
            echo '<p>Role: ' . $role . '</p>';
                        $notification = "";
            if($row["notificationState"] == 1){
                $notificationState = "Yes";
            }else{
                $notificationState = "No";
            }
            echo '<p>Notification: ' . $notificationState . '</p>';
            echo '<label class="medium">Phone:</label> <input name="phoneNumber" type="text" value=' . $row["phoneNumber"] . ' />';
            echo '<p><input class="btn btn-default btn-lg" type="submit" value="Update"></p>';
        }
    } else {
        echo "No profile";
    }
    //$link->close();
    echo '</div>';
}
?>