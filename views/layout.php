<!doctype HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <title>Kamps For Kids</title>
    <link rel="stylesheet" href="views/styles/styles.css">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script defer src="views/scripts/main.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>

</head>
<body>
<?php
require_once "templates/header.php";
require_once "templates/footer.php";
require_once "routes.php";
?>
<div id="id01" class="modal">
    <!--action_page.php is the php file which will perform user validation when the 'submit' button is clicked -->
    <form class="modal-content animate" action="/action_page.php">
        <div class="img-container">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <div><img src="./views/images/KamparoosLogo.png" alt="Logo" class="logo"></div>
            <img src="./views/images/img_avatar2.png" alt="Avatar" class="avatar">

            <div>
                <!-- Add icon library from font-awesome -->
                <link rel="stylesheet"
                      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                <!-- Add font awesome icons -->
                <a href="#" class="fa fa-facebook"></a>
                <a href="#" class="fa fa-twitter"></a>
            </div>
        </div>

        <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="user-name" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <button type="submit">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

        <div class="container" style="background-color:#FAFC2F">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancel-btn">
                Cancel
            </button>
            <span class="psw">Forgot <a href="#">password?</a></span>

        </div>
    </form>
</div>

<div id="id02" class="modal">
    <!--action_page.php is the php file which will perform user validation when the 'submit' button is clicked -->
    <form class="modal-content animate" name="registrationForm" onsubmit="return validateForm()" method="post"
          action="/action_page.php">
        <div class="img-container">
            <h3>Registration Form</h3>
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            <div><img src="./views/images/KamparoosLogo.png" alt="Logo" class="logo"></div>
            <img src="./views/images/img_avatar2.png" alt="Avatar" class="avatar">
            <div>
                <!-- Add icon library from font-awesome -->
                <link rel="stylesheet"
                      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            </div>
        </div>
        <div class="container">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstName"
                       required>
            </div>

            <div class="form-group col-md-6">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Enter last name" name="lastName"
                       required>
            </div>

            <div class="form-group col-md-6">
                <label for="emailAddress">Email Address</label>
                <input type="email" class="form-control" id="emailAddress" placeholder="Enter email address"
                       name="emailAddress" required>
            </div>

            <div class="form-group col-md-6">
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" class="form-control" id="phoneNumber" placeholder="Enter 10 digit phone number"
                       name="phoneNumber" required
                       pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                       size="10">
            </div>


            <div class="form-group col-md-12">
                <label for="numOfKids">Number of Kids </label>
                <select name="numOfKids" id="numOfKids">
                    <option value="">Select...</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>


            <div class="form-group col-md-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password"
                       required>
            </div>

            <div class="form-group col-md-4">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Re-enter password"
                       name="confirmPassword" required>
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
        </div>
        </div>

        <button type="submit" class="btn btn-danger btn-success"
        ">Register</button>
    </form>
</div>

<script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, the modal with close
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Get the modal
    var modalTwo = document.getElementById('id02');

    // When the user clicks anywhere outside of the modal, the modal with close
    window.onclick = function (event) {
        if (event.target == modalTwo) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>

