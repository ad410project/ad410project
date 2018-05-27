<?php
//Start the Session
//session_start();

require('connection.php');

$link = Db::getInstance();

//3. If the form is submitted or not.
//3.1 If the form is submitted
if (!isset($_SESSION['emailAddress'])) {
//3.1.1 Assigning posted values to variables.
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
//3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM Users WHERE email='$emailAddress' and password='$password'";

    $result = $link->query($query);
    $count = mysqli_num_rows($result);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1) {
        $_SESSION['emailAddress'] = $emailAddress;
        $emailAddress = $_POST['emailAddress'];
        header('Location: ?controller=static&action=profile');
    } else {
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        ///echo "Invalid Login Credentials." . $link->error;
    }
}

?>

<form class="form-signin" method="POST">
    <h2 class="form-signin-heading">Please Login</h2>
    <input style="width: 100%;" type="text" name="emailAddress" id="inputPassword" class="form-control" placeholder="Username" required>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    <a class="btn btn-lg btn-primary btn-block" href="?controller=static&action=registration">Register</a>
</form>