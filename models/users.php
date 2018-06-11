<?php
class  user{
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $phoneNumber;
    public $notificationState;
    public $userTypeId;

    public function __construct($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId){

        $this->userId                   = $userId;
        $this->firstName                = $firstName;
        $this->lastName                 = $lastName;
        $this->email                    = $email;
        $this->password                 = $password;
        $this->phoneNumber              = $phoneNumber;
        $this->notificationState        = $notificationState;
        $this->userTypeId               = $userTypeId;
    }

    // temporary registration function - auth team can add their code here
    public static function addUser()
    {
        $db = Db::getInstance();
        global $first_name, $last_name, $email, $password, $phone, $usertype_id;
        $first_name = mysqli_real_escape_string($db, trim(($_POST['firstName'])));
        $last_name = mysqli_real_escape_string($db, trim(($_POST['lastName'])));
        $email = mysqli_real_escape_string($db, trim(($_POST['emailAddress'])));
        $phone = ($_POST['phone']);
        $password_1 = ($_POST['password_1']);
        $password_2 = ($_POST['password_2']);
        if ($password_1 != $password_2) {
            echo "The two passwords do not match" .'<br>';
        } else {
            $password = md5($password_1);//get Auth team encryption - this is a stand in
        }
        $user_type = ($_POST['userRole']);
        if (strcmp($user_type,"admin") == 0) {
            $usertype_id = 4;
        } else if (strcmp($user_type,"organization") == 0) {
            $usertype_id = 3;
        } else {
            $usertype_id = 2; // registered user
        }
        //Users table columns - userId, email, password, firstName, lastName, phoneNumber, notificationState, userTypeId
        $query = "INSERT INTO users (email, password, firstName, lastName, phoneNumber, notificationState, userTypeId) 
                      VALUES('$email', '$password', '$first_name', '$last_name', '$phone', 0, $usertype_id)";
        $result = mysqli_query($db, $query) or die ("Could not add user to the DB." . mysqli_error());
        header("location: ?controller=dynamic&action=home");
    }

    // temporary function for logging in existing user
    public static function login()
    {
        $db = Db::getInstance();
        // grab from values
        $email = mysqli_real_escape_string($db, trim(($_POST['email'])));
        $password = mysqli_real_escape_string($db, trim(($_POST['password'])));
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) { // user found
            header("location: ?controller=dynamic&action=home");
        } else {
            echo "Wrong username/password combination" . '<br>';
        }
    }

    // edit user profile
    public static function editUser($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId, $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode){
        //instance of db
        $addressId = "";
        $db = Db::getInstance();
        //check if user has address in database yet
        $stmt = $db->prepare('SELECT addressId
                                    FROM userAddresses
                                    WHERE userId = ?;');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->bind_result($addressId);
        // if user does not yet have address in database
        if ($result->num_rows == 0) {
            // add a user address to database
            $req = $db->prepare('INSERT INTO addresses(addressLine1, addressLine2, city, state, postalCode) VALUES(?, ?, ?, ?, ?)');
            $req->bind_param('sssss', $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode);
            $req->execute();
            // Prepare query to obtain the newly created address ID
            $req = $db->prepare('SELECT addressId 
                                    FROM addresses 
                                    WHERE addressLine1 = ?
                                        AND addressLine2 = ?
                                        AND city = ?
                                        AND state = ?
                                        AND postalCode = ?;');
            // Bind parameters for address
            $req->bind_param('sssss', $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode);
            $req->execute();
            $req->bind_result($addressId);
            $req->fetch(); // gets addressId value
            // insert $addressId and $userId into linking table
            $req = $db->prepare('INSERT INTO userAddresses(userId, addressId) VALUES(?,?)');
            $req->bind_param('ii', $userId, $addressId);
            $req->execute();
        } else { // if num_rows > 0 - so user address is already in database
            $stmt->fetch(); // get $addressId from userAddresses linking table
            //edit address
            $req = $db->prepare('UPDATE addresses 
                SET addressLine1 = ?,
                    addressLine2 = ?,
                    city = ?,
                    state = ?,
                    postalcode = ?,
                WHERE addressId = ?;');
            // Bind parameters for address update
            $req->bind_param('sssssi', $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode, $addressId);
            $req->execute();
        }
        // Prepare stmt to update user name
        $req = $db->prepare('UPDATE users 
                                SET email=?, 
                                    password=?,
                                    firstName=?, 
                                    lastName=?, 
                                    phoneNumber=?, 
                                    notificationState=?,
                                    userTypeId=?
                                WHERE userId = ?;');
        $req->bind_param('sssssiii', $email, $password, $firstName, $lastName, $phoneNumber, $notificationState, $userTypeId, $userId);
        $req->execute();
        // Close Connection
        $db->close();
    }

    // get user by email
    public static function getUserByEmail($email) {
        //instance of db
        $db = Db::getInstance();
        $userId = 0;
        $password = "";
        $firstName = "";
        $lastName = "";
        $phoneNumber = "";
        $notificationState = 0;
        $userTypeId = 0;
        // Prepare the query
        $req = $db->prepare('SELECT userId, password, firstName, lastName, phoneNumber, notificationState, userTypeId FROM users WHERE email = ?');
        $req->bind_param('s', $email);
        $req->execute();
        $req->bind_result($userId, $password, $firstName, $lastName, $phoneNumber, $notificationState, $userTypeId);
        return new user($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId);
    }

    // get user by userId
    public static function getUserById($userId) {
        //instance of db
        $db = Db::getInstance();
        $email = "";
        $password = "";
        $firstName = "";
        $lastName = "";
        $phoneNumber = "";
        $notificationState = 0;
        $userTypeId = 0;
        // Prepare the query
        $req = $db->prepare('SELECT email, password, firstName, lastName, phoneNumber, notificationState, userTypeId FROM users WHERE userId = ?');
        $req->bind_param('i', $userId);
        $req->execute();
        $req->bind_result($email, $password, $firstName, $lastName, $phoneNumber, $notificationState, $userTypeId);
        return new user($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId);
    }
}

?>