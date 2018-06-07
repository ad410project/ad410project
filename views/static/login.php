<?php
require_once('connection.php');
$link = Db::getInstance();

//3. If the form is submitted or not.
//3.1 If the form is submitted
if (!isset($_SESSION['emailAddress'])) {
//3.1.1 Assigning posted values to variables.
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];

    $options = array("cost" => 10);
    $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);

//3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM Users WHERE email='$emailAddress'";
    $result = $link->query($query);
    $count = mysqli_num_rows($result);
    
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1 && password_verify($password, $hashPassword)==$hashPassword) {
        $_SESSION['emailAddress'] = $emailAddress;
        $emailAddress = $_POST['emailAddress'];
        header('Location: ?controller=static&action=profile');
    } else {
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        //echo "Invalid Login Credentials." . $link->error;
    }
}
?>

<div class="container">
    <br>
    <br>
    <h1>Log In</h1>
    <form class="form-signin" method="POST">
        <div class="container" id="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="emailAddress" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login_btn">Login</button>
        </div>
    </form>
</div>



