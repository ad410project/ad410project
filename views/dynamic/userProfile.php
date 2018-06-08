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
    static $userAddressId;
    static $addrLine1;
    static $addrLine2;
    static $city;
    static $state;
    static $postal;

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
    require_once "../../connection.php";
    require_once '../../models/UserChild.php';

    $userInfo = getUser();

    $uChild = new UserChild(NULL,$userInfo[0],$kidValues[0],$kidValues[1],intval(str_replace('-','',$kidValues[2])),NULL,NULL);

    $uChild->addChild($uChild->user_id, $uChild->first_name, $uChild->last_name, $uChild->child_Dob, $uChild->childAllergies, $uChild->emergencyContactNum);
}

?>


<body>
        <script>
        //userProfile form for editChild
        function displayEditChildForm()
        {
            //invalidate editUser form first to disallow changes
            $("#editUserFormContainer :input").prop('readonly', true);
            //do remove first
            try
            {
                var elem = document.getElementById('editChildRow');
                elem.remove();
                var elem2 = document.getElementById('editChildRow2');
                elem2.remove();
            }
            catch(Exception)
            {

            }

            var container = document.getElementById("updateChild");

            var myRow = document.createElement('DIV');
            myRow.id = 'editChildRow';
            myRow.style.display = 'inline-block';
            myRow.className = 'row';
            myRow.style.width = '600px';

            var myRow2 = document.createElement('DIV');
            myRow2.id = 'editChildRow2';
            myRow2.style.display = 'inline-block';
            myRow2.className = 'row';
            myRow2.style.width = '600px';

            var obj = document.createElement('DIV');
            obj.id = 'editChildfName';
            obj.className = 'form-group col-md-6';
            obj.style.display = 'inline-block';
            obj.innerHTML = "<label for=\"\">First Name</label>\n" +
                "            <input type=\"text\" class=\"form-control form-control-sm\" id=\"child-first_name" + "\"placeholder=\"\"  required>";

            var obj2 = document.createElement('DIV');
            obj2.id = 'editChildlName';
            obj2.className = 'form-group col-md-6';
            obj2.style.display = 'inline-block';
            obj2.innerHTML = "<label for=\"\">Last Name</label>\n" +
                "            <input type=\"text\" class=\"form-control form-control-sm \" id=\"child-last_name"  + "\"placeholder=\"\"  required>";

            myRow.appendChild(obj);
            myRow.appendChild(obj2);


            var obj3 = document.createElement('DIV');
            obj3.id = 'editChildlAge';
            obj3.className = 'form-group col-md-6';
            obj3.style.display = 'inline-block';
            obj3.innerHTML = "<label for=\"\">Date of birth</label>\n" +
                "            <input type=\"date\" class=\"form-control form-control-sm \" id=\"child-age" + "\"placeholder=\"\"  required>";

            var obj4 = document.createElement('DIV');
            obj4.id='btnEditChildSubmitCancel';
            obj4.className = 'form-group col-md-6';
            obj4.style.display = 'inline-block';
            obj4.innerHTML = "<button class=\"btn btn-primary col-md-3\" type=\"submit\" onclick='addKid()'>Submit</button>" +
                "               <button class=\"btn btn-secondary col-md-3\" type=\\\"button\\\" onclick='removeEditChildForm()'>Cancel</button>";

            myRow2.appendChild(obj3);
            myRow2.appendChild(obj4);

            container.appendChild(myRow);
            container.appendChild(myRow2);

            return container;
        }
    </script>
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


    <form id="editUserFormContainer" class="needs-validation" novalidate>
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

                <label for="address">Home Address</label>
                <input type="text" class="form-control form-control-sm" id="address" placeholder="<?php print $userInfo[8] . ", " . $userInfo[9] . ", " . $userInfo[10] . ", ". $userInfo[11] . " " . $userInfo[12] ?>" name="address" required>
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
                <span>Add Kid<button type="button" class="btn btn-secondary" onclick="displayEditChildForm()">+</button></span>
            </div>
        </div> <!-- end row -->
        <!-- <form method="post" action="userProfile.php"> -->
        <button type="submit" class="col-md-12 btn btn-secondary" name="btnUpdateProfile" onsubmit="">Update</button>
    </form>

    <section id="bottom-nav_section">
        <div class="d-flex justify-content-center fixed-bottom">
            <div class="p-2 my-flex-item"><a href="">Contact us</a></div>
            <div class="p-2 my-flex-item"><a href="">Terms of use</a></div>
            <div class="p-2 my-flex-item"><a href="">FAQs</a></div>
        </div>
    </section>


    <!--</div> <!-- end row2 -->
</div>
</body>
</html>
