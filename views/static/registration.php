<?php
require_once('connection.php');
$link = Db::getInstance();

// If the values are posted, insert them into the database.
if (isset($_POST['emailAddress']) && isset($_POST['password_1'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];
    $numOfKids = $_POST['numOfKids'];
    $userRole = $_POST['userRole'];
    $password = $_POST['password_1'];

    $query = "SELECT * FROM Users WHERE email='$emailAddress'";
    $result = $link->query($query);
    $count = mysqli_num_rows($result);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 0) {
        $query = "INSERT INTO Users(email, password, firstName, lastName, phoneNumber, notificationState, UserTypeId) VALUES ('$emailAddress', '$password', '$firstName', '$lastName', '$phoneNumber', 1, 1)";
        $result = $link->query($query);
        if ($result) {
            //$smsg = "User Created Successfully.";
            header('Location: ?controller=static&action=login');
        } else {
            echo "User Registration Failed" . $link->error;
        }
    }else{
        echo 'nothing';
    }
}else{
    echo 'not set bbo';
}
?>

<h3>Registration Form</h3>
<form name="registrationForm" onsubmit="return validateForm()" method="post">
<div class = "container">
    <div id="img">
        <img id="avatar" src="views/images/img_avatar2.png"/>
        <h1>Register</h1>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstName" required>
        </div>

        <div class="form-group col-md-6">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" placeholder="Enter last name" name="lastName" required>
        </div>

        <div class="form-group col-md-6">
            <label for="emailAddress">Email Address</label>
            <input type="email" class="form-control" id="emailAddress" placeholder="Enter email address" name="emailAddress" required>
        </div>

        <div class="form-group col-md-6">
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" placeholder="Enter 10 digit phone number" name="phoneNumber" required
                   pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                    size="10">
        </div>

        <div class="form-group col-md-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password_1" required>
        </div>

        <div class="form-group col-md-4">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Re-enter password" name="password_2" required>
        </div>

        <div class="form-group col-md-12">
            <label for="userRole">Register as </label>
            <select name="userRole" id="userRole" required>
                <option value="">Select...</option>
                <option value="user">Individual User</option>
                <option value="admin">Admin</option>
                <option value="organization">Organization</option>
            </select>
        </div>

        <button type="submit" class="register-btn">Register</button>
    </div>
</div>
    <div class="container signin">
        <p>Already have an account? <a href="#">Log in</a>.</p>
    </div>
</form>