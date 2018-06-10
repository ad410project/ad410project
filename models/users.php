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

//  public function addUser($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId){
//
//      //instance of db
//      $db = Db::getInstance();
//
//      //add user to database
//      $req = $db->prepare('INSERT INTO users (firstName, lastName, email, password, phoneNumber, notificationState, userTypeId
//                                                       VALUES ?, ?, ?, ?, ?, ?, ?)';
//
//        $req->bind_param($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId);
//        $req->execute();
//  }

    public static function editUser($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId, $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode){

        //instance of db
        $db = Db::getInstance();

        //edit address
        $req = $db->prepare('UPDATE addresses 
                SET addressLine1 = ?,
                    addressLine2 = ?,
                    city = ?,
                    state = ?,
                    postalcode = ?,
                WHERE addressId = ?;');

        // Bind parameters for address update
        $req->bind_param('sssssi', $addressLine1, $addressLine2 $addressCity, $addressState, $addressZipCode, $addressId);

        $req->execute();


        // Prepare query to update organizations record
        $req = $db->prepare('UPDATE users 
                                SET addressId=?, 
                                    firstName=?, 
                                    lastName=?, 
                                    email=?, 
                                    password=?,
                                    phoneNumber=?, 
                                    notificationState=?
                                    userId=?
                                WHERE userId = ?;');

        $req->bind_param('issisii', $userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userId);

        $req->execute();
        // Close Connection
        $db->close();

        return 'User Updated';
    }

    public function deleteUser($user_id){
        //instance of db
        $db = Db::getInstance();

        $query = 'DELETE FROM users WHERE user_id = ?';
        return ($this->db->query($query));
    }

    public function getUserById($user_id){
        //instance of db
        $db = Db::getInstance();
        
        // Prepare the query 
        $req = $db->prepare('SELECT column_name FROM table_name WHERE id = ?');
        return ($this->db->query($req));
    }
}
?>