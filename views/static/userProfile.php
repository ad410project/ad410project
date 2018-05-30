<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 5/23/2018
 * Time: 6:00 AM
 */

session_start();

    if(isset($_SESSION['email']) && !isset($_POST['email']))
    {
        $userInfo = array_values(getUser());
    }


    if(isset($_POST['email']))
    {
        if(!isset($_SESSION['email']))
        {
            $_SESSION['email'] = $_POST['email'];
        }
        $userInfo = array_values(getUser());
    }

    function getUser()
    {
        require_once "../../connection.php";

        $mysqli = null;
        static $id;
        static $email;
        static $pWord;
        static $fName;
        static $lName;
        static $phone;
        static $notifState;
        static $userTypeId;

        $userInfo = array();

        try {
            //for now _SESSION or _POST provides email address
            $userEmail = $_SESSION['email'];

            //connect, get all info about a specific user
            $mysqli = Db::getInstance();
            //Stored procedure doesn't work ?
            //$stmt = $mysqli->prepare("CALL getUserProfile('$userEmail')");
            $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param('s', $userEmail);
            $stmt->execute();
            $stmt->bind_result($id, $email, $pWord, $fName, $lName, $phone, $notifState, $userTypeId);
            while ($stmt->fetch())
                $stmt->close();
        } catch (Exception $e) {
            print $e->getMessage();
        }

        $userInfo[0] = $id;
        $userInfo[1] = $email;
        $userInfo[2] = $pWord;
        $userInfo[3] = $fName;
        $userInfo[4] = $lName;
        $userInfo[5] = $phone;
        $userInfo[6] = $notifState;
        $userInfo[7] = $userTypeId;

        return array_values($userInfo);
    }

    if(isset($_POST['q1']))
    {
        updateUserProfile($userInfo/*$email, $pWord, $fName, $lName, $phone, $notifState, $userTypeId,*/, $_POST['q1']);
    }

    function updateUserProfile($userInfo,/*$email, $pWord, $fName, $lName, $phone, $notifState, $userTypeId,*/ $vals)
    {
        require_once "../../connection.php";

        $userId = null;
        $email = null;
        $pWord = null;
        $fName = null;
        $lName = null;
        $phone = null;
        $notifState = null;
        $userTypeId = null;

        $numKids = null;
        $mysqli2 = null;

        try
        {

            //connect, update profile for logged in user
            $mysqli = Db::getInstance();

            $fN = '%' . $_POST['q2']['fN'] . '%';
            $lN = '%' . $_POST['q2']['lN'] . '%';
            $ph =  '%' .$_POST['q2']['ph'] . '%';
            $em = '%' . $_POST['q2']['em'] . '%';
            $pW = '%' . $_POST['q2']['pw'] . '%';


            $stmt2 = $mysqli->prepare("UPDATE `Users` SET
                                      `email` = ?,
                                      `password` = ?,
                                      `firstName` = ?,
                                      `lastName` = ?,
                                      `phoneNumber`= ?,
                                      `notificationState` = ?,
                                      `userTypeId` = ? 
                                      WHERE `userId` = ?");
            $stmt2->bind_param("sssssiii",$em,$pW,$fN,$lN,$ph,$userInfo[6],$userInfo[7],$userInfo[0]);

            $stmt2->execute();
            $stmt2->close();

            //update children table
            $stmt3 = null;
            for ($k = 0; $k < count($vals); $k++)
            {
                $val = $vals[$k]['fN'];
                $val2 = $vals[$k]['lN'];
                $val3 = $vals[$k]['age'];
                try
                {
                    $stmt3 = $mysqli->prepare("INSERT INTO Children (`childId`,`userId`,`firstName`,`lastName`,`childDob`,`childAllergies`,`emergencyContactNum`) VALUES (
                                                        DEFAULT, 
                                                          '$userId', 
                                                          '$val', 
                                                          '$val2',
                                                          '$val3', 
                                                          NULL,
                                                          NULL) ON DUPLICATE KEY UPDATE 
                                                          userId = '$userInfo[0]', 
                                                          firstName = '$val', 
                                                          lastName = '$val2',
                                                          childDob = '$val3'");
                    $stmt3->execute();
                }catch (Exception $ex)
                {
                    //do nothing, continue loop
                }
            }
            $stmt3->close();
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
        $mysqli->close();
        //session_destroy();
    }
    //session_destroy();
?>
<!DOCTYPE html>
<html xmlns:float="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../styles/styles.css">
    <script type="application/javascript" src="../scripts/main.js"></script>

</head>
<body>
<div class="container">
    <section id="top-nav_section">
        <div class="d-flex justify-content-between">
            <div class="p-2 my-flex-item">Welcome <?php print ' ' . $userInfo[1] ?></div>
            <div class="p-2 my-flex-item">
                <a href="#">
                    <span class="glyphicons glyphicons-home">Home</span>
                </a>
            </div>
            <div class="p-2 my-flex-item"><a href="">Logout</a></div>
        </div>
    </section>
    <br>

    <!-- copied from registration page -->
   <div class="form-group col-md-6 float-left">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="fName" placeholder="<?php print $userInfo[3] ?>" name="firstName" required>
   </div>

    <div id="updateChild" class="form-group col-md-6 float-right align-top">
        <label for="numberKids">Number of Kids </label>
        <!-- <form action="userProfile.php" method="post"> -->
        <select name="numOfKids" id="numberKids" onchange="displayEditChildForm()">
            <option id="editChildSelectDropdown" value="">Select...</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>

        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lName" placeholder="<?php print $userInfo[4] ?>" name="lastName" required>
    </div>

    <div class="form-group col-md-6">
        <label for="emailAddress">Email Address</label>
        <input type="email" class="form-control" id="email" placeholder="<?php print $userInfo[1] ?>" name="emailAddress" required>
    </div>

    <div class="form-group col-md-6">
        <label for="phoneNumber">Phone Number</label>
        <input type="tel" class="form-control" id="phone" placeholder="<?php print $userInfo[5] ?>" name="phoneNumber" required
               pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
               size="10">
    </div>

    <div class="form-group col-md-4">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="pWord" placeholder="<?php print $userInfo[2] ?>" name="password" required>
    </div>

    <!-- <form method="post" action="userProfile.php"> -->
        <button type="button" class="col-md-12 btn btn-secondary" name="btnUpdateProfile" onclick="sendValuesToPHP()">Update</button>
    <!-- </form> -->

    <section id="bottom-nav_section">
        <div class="d-flex justify-content-center fixed-bottom">
            <div class="p-2 my-flex-item"><a href="">Contact us</a></div>
            <div class="p-2 my-flex-item"><a href="">Terms of use</a></div>
            <div class="p-2 my-flex-item"><a href="">FAQs</a></div>
        </div>
    </section>

</div>
</body>
</html>
