<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 5/23/2018
 * Time: 6:00 AM
 */
session_start();

static $numKids;

require_once("models/UserChild.php");

if(isset($_SESSION['emailAddress']) && !isset($_POST['emailAddress']))
{
    $userInfo = array_values(getUser());
}


if(isset($_POST['emailAddress']))
{
    if(!isset($_SESSION['emailAddress']))
    {
        $_SESSION['emailAddress'] = $_POST['emailAddress'];
    }
    $userInfo = array_values(getUser());
}

function getUser()
{
    $mysqli = null;
    static $id;
    static $email;
    static $pWord;
    static $fName;
    static $lName;
    static $phone;
    static $notifState;
    static $userTypeId;
    static $userAddressId;

    //Address
    static $addrLine1;
    static $addrLine2;
    static $city;
    static $state;
    static $postal;



    $userInfo = array();

    try {
        //for now _SESSION or _POST provides email address
        $userEmail = $_SESSION['emailAddress'];

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

        //get user's address
        $stmtUserAddress = $mysqli->prepare("SELECT Addresses.addressId,`addressLine1`, `addressLine2`, `city`,`state`,`postalCode` FROM Addresses
                                                    JOIN UserAddresses ON userId = Addresses.addressId
                                                    WHERE userId = ?");
        $stmtUserAddress->bind_param('i', $id);
        $stmtUserAddress->execute();
        $stmtUserAddress->bind_result($userAddressId, $addrLine1, $addrLine2, $city, $state, $postal);
        while ($stmtUserAddress->fetch())
            $stmtUserAddress->close();


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

    //for address info
    $userInfo[8] = $addrLine1;
    $userInfo[9] = $addrLine2;
    $userInfo[10] = $city;
    $userInfo[11] = $state;
    $userInfo[12] = $postal;

    return array_values($userInfo);
}

if(isset($_POST['q']))
{
    updateUserProfile($userInfo);
}

if(isset($_POST['q3']))
{
    $numKids = array_values(showUserKids());
}


function showUserKids()
{
    //child
    static $childId;
    static $userId;
    static $childFName;
    static $childLName;
    static $childDOB;
    static $childAllergies;
    static $childEmergcyCt;
    $mysqli = null;
    $userInfo = array_values(getUser());

    $mysqli = Db::getInstance();

    //retrieve users' kids
    $stmtChildren = $mysqli->prepare("SELECT * FROM Children WHERE userId = ?");
    $stmtChildren->bind_param("i",$userInfo[0]);
    $stmtChildren->execute();
    $stmtChildren->bind_result($childId, $userId, $childFName, $childLName, $childDOB, $childAllergies, $childEmergcyCt);
    $i = 0;
    $cFN = [];
    $cLN = [];
    $retVals = [];
    print "<ul class=\"list-group\">";

    while($stmtChildren->fetch()) {
        //populate a grid with a all the user's kids
        $cFN[$i] = $childFName;
        $cLN[$i] = $childLName;
        $retVals[$i] = $childFName . ", " . $childLName;
        //print "<li class=\"list-group - item\">'$cFN[$i] . \", \" . '$cLN[$i]'</li>";

        $i++;

    }

    print "</ul>";

    $stmtChildren->close();
    return $retVals; //random return value for now
}

function updateUserProfile($userInfo)
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

        $fN = $_POST['q']['fN'];
        $lN = $_POST['q']['lN'];
        $ph = $_POST['q']['ph'];
        $em = $_POST['q']['em'];
        $pW = $_POST['q']['pw'];

        //Address
        $str  = $_POST['q']['str'];
        $str2 = $_POST['q']['str2'];
        $ct   = $_POST['q']['ct'];
        $sta  = $_POST['q']['sta'];
        $zip  = $_POST['q']['zp'];


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

        //Update address
        $stmt3 = $mysqli->prepare("UPDATE Addresses 
                                          JOIN UserAddresses ON Addresses.addressId = UserAddresses.userId
                                          SET `addressLine1` = ?,
                                              `addressLine2` = ?,
                                               `city` = ?,
                                               `state` = ?,
                                               `postalCode` = ?
                                          WHERE UserAddresses.userId = ?");
        $stmt3->bind_param("sssssi",$str,$str2,$ct,$sta,$zip,$userInfo[0]);
        $stmt3->execute();
        $stmt3->close();
    }
    catch (Exception $e)
    {
        print $e->getMessage();
    }
    $mysqli->close();

    session_destroy(); //Is this correct ?
}

if(isset($_POST['q2']))
{
    $kidValues = array();
    $kidValues = array_values($_POST['q2']);

    addKid($kidValues);
}

function addKid($kidValues)
{
    $userInfo = getUser();

    try {
        $uChild =  new UserChild(null, $userInfo[0], $kidValues[0], $kidValues[1], intval(str_replace('-', '', $kidValues[2])), "", "");
        $uChild->addChild($uChild->user_id, $uChild->first_name, $uChild->last_name, $uChild->child_Dob, $uChild->childAllergies, $uChild->emergencyContactNum);
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    catch (Error $er)
    {
        echo $er->getMessage();
    }
}

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

    <!--<link rel="stylesheet" href="../styles/styles.css"> -->


</head>
<body>
<form  method="post" id="editUserFormContainer" class="needs-validation" novalidate>
    <br>
    <br>
    <div class="container">
        <section id="top-nav_section">
            <div class="d-flex justify-content-between">
                <div class="p-2 my-flex-item">Welcome <?php print ' ' . $userInfo[1] ?></div>
            </div>
        </section>

        <div class="row">

            <!-- copied from registration page -->
            <div class="form-group col-md-6" id="editUserForm">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control form-control-sm" id="fName" placeholder="<?php print $userInfo[3] ?>" name="firstName" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <!-- </div> -->

                <!-- <div class="form-group col-md-6"> -->
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control form-control-sm" id="lName" placeholder="<?php print $userInfo[4] ?>" name="lastName" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <!--  </div> -->

                <!--  <div class="form-group col-md-6"> -->
                <label for="emailAddress">Email Address</label>
                <input type="email" class="form-control form-control-sm" id="email" placeholder="<?php print $userInfo[1] ?>" name="emailAddress" required>
                <div class="invalid-feedback">
                    Please edit email address.
                </div>

                <!-- 4 fields for address -->
                <label for="street">Street Address1</label>
                <input type="text" class="form-control form-control-sm" id="street" placeholder="<?php print $userInfo[8] ?>" name="street" required>
                <div class="invalid-feedback">
                    Please edit home address.
                </div>

                <label for="street">Street Address2</label>
                <input type="text" class="form-control form-control-sm" id="street2" placeholder="<?php print $userInfo[9]?>" name="street2" required>
                <div class="invalid-feedback">
                    Please edit home address.
                </div>

                <label for="city">City</label>
                <input type="text" class="form-control form-control-sm" id="city" placeholder="<?php print $userInfo[10] ?>" name="city" required>
                <div class="invalid-feedback">
                    Please edit home address.
                </div>

                <label for="state">State</label>
                <input type="text" class="form-control form-control-sm" id="state" placeholder="<?php print $userInfo[11] ?>" name="state" required>
                <div class="invalid-feedback">
                    Please edit home address.
                </div>

                <label for="zip">Zip</label>
                <input type="text" class="form-control form-control-sm" id="zip" placeholder="<?php print $userInfo[12] ?>" name="zip" required>
                <div class="invalid-feedback">
                    Please edit home address.
                </div>
                <!--  </div> -->

                <!--   <div class="form-group col-md-6"> -->
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" class="form-control form-control-sm" id="phone" placeholder="<?php print $userInfo[5] ?>" name="phoneNumber" required
                       pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                       size="10">
                <div class="invalid-feedback">
                    Please provide a phone number.
                </div>
                <!--  </div> -->

                <!--   <div class="form-group col-md-4"> -->
                <label for="password">Password</label>
                <input type="password" class="form-control form-control-sm" id="pWord" placeholder="<?php print $userInfo[2] ?>" name="password" required>
                <div class="invalid-feedback">
                    Please provide a password.
                </div>
            </div>

            <div id="updateChild" class="form-group col-md-1 align-top">
                <!-- show user's kids here ?-->
                <ul class="list-group">
                    <?php for($i = 0; $i < count($numKids); $i++)
                    {
                        print "<li class=\"list-group-item\">'$numKids[$i]'</li>";
                    }
                    ?>
                </ul>


                <span>Add Kid<button type="button" class="btn btn-secondary" onclick="displayEditChildForm()">+</button></span>
            </div>

            <button type="submit" class="col-md-12 btn btn-secondary" name="btnUpdateProfile" onsubmit="">Update</button>

        </div> <!-- end row -->
        <!-- <form method="post" action="userProfile.php"> -->

    </div>
    <br>
    <br>
</form>
</body>
</html>

