<?php
require ('config.php');
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION['emailAddress'])) {
    header("location: ?controller=static&action=login");
    exit;
} else {
    $emailAddress = $_SESSION['emailAddress'];
    $sql = "SELECT * FROM Users WHERE email='$emailAddress'";
    $result = $link->query($sql);

    echo '<h1>Profile</h1>';
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            //echo '<p>Name: ' . $row["username"] . '</p>';
            echo '<p>Email: ' . $row["email"] . '</p>';
            echo '<p>Firsname: ' . $row["firstName"] . '</p>';
            echo '<p>Lastname: ' . $row["lastName"] . '</p>';
            echo '<label class="medium">Phone:</label> <input name="phoneNumber" type="text" value=' . $row["phoneNumber"] . ' />';
            echo '<p><input class="btn btn-default btn-lg" type="submit" value="Update"></p>';
        }
    } else {
        echo "No profile";
    }
    //$link->close();
}
?>