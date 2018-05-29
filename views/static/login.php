<?php
//Start the Session
//session_start();

$link = Db::getInstance();
$isSuccessfulLogin = true;

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
        $isSuccessfulLogin = true;
        header('Location: ?controller=dynamic&action=home');
    } else {
        $isSuccessfulLogin = false;
    }
}

?>

    <form class="form-signin" method="POST">

        <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="emailAddress" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>


            <label>
                TEST
            </label>

            <?php
            if (!$isSuccessfulLogin) {
            ?>
                <label> <?php echo 'Invalid login credentials.' ?> </label>
            <?php
            }
            ?>
        </div>

    </form>

