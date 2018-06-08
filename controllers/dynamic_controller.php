<?php
  class DynamicController {
    public function home() {
      require_once('views/dynamic/home.php');
    }

    public function error() {
      require_once('views/static/error.php');
    }

    public function searchEvents() {
        require_once('views/dynamic/search_events.php');
    }

    public function registration() {

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
                    header('Location: ?controller=dynamic&action=login');
                } else {
                    echo "User Registration Failed" . $link->error;
                }
            } else {
                echo 'nothing';
            }
        } else {
            echo 'not set bbo';
        }
        require_once('views/dynamic/registration.php');
    }

    public function login() {
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
                header('Location: ?controller=dynamic&action=profile');
            } else {
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
                echo "Invalid Login Credentials." . $link->error;
            }
        }
        require_once('views/dynamic/login.php');
    }

    public function profile() {
        require_once('views/dynamic/userProfile.php');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?controller=static&action=landing');
//        require_once('views/dynamic/logout.php');
    }

    public function contact() {
        require_once('views/dynamic/contact.php');
    }

    public function organization_events() {
        require_once('views/dynamic/organization_events.php');
    }

    public function addEvent() {
          require_once('views/dynamic/addEvent.php');
    }

    public function editEvent() {
          require_once('views/dynamic/editEvent.php');
    }
  }
?>
