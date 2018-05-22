<?php
//session_start();

class User
{
    public $user_id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $phone;
    public $notification_state;
    public $usertype_id;
//    public $zip_code;
//    public $address;
//    public $number_of_kids; // not sure whether need to store this value initially

    //array for error checking
    public $errors = array();

    // construct a new user object
    public function __construct($user_id, $email, $password, $first_name, $last_name, $phone, $notification_state, $usertype_id) // , $zip_code, $address
    {
        $this->user_id = $user_id;
        $this->email = $email;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->usertype_id = $usertype_id;
        $this->phone = $phone;
        $this->notification_state = $notification_state;
//        $this->zip_code = $zip_code;
//        $this->address = $address;
    }


    // add a user to the database - basic user - no profile created yet
    public static function addNewUser()
    { // gets all the values from POST method
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
        mysqli_query($db, $query);
        $result = mysqli_query($db, $query) or die ("Could not add user to the DB." . mysqli_error());
//            $logged_in_user_id = mysqli_insert_id($db);
//            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
//            $_SESSION['user_logged_in'] = true;
//            $_SESSION['success']  = "You are now logged in";
//            global $user_id;
//            $query2 = "SELECT id FROM users ORDER BY id DESC LIMIT 1;";
//            $results2 = mysqli_query($db, $query2) or die ("Could not get user_id from DB." . mysqli_error());
//            $user_id = mysqli_fetch_assoc($results2);
//            $_SESSION['user_id'] = $user_id;
//            // get session id of the created user
        //header("location: ?controller=event&action=search_events");
        header("location: views/events/search_events.php"); // temporary header - this is not MVC
    }

    // login existing user
    public static function login()
    {
        $db = Db::getInstance();
        global $username, $password;
        // grab from values
        $username = mysqli_real_escape_string($db, trim(($_POST['user-name'])));
        $password = mysqli_real_escape_string($db, trim(($_POST['psw'])));
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) { // user found
    //                $logged_in_user = mysqli_fetch_assoc($results);
    //                $_SESSION['user'] = $logged_in_user;
    //                $_SESSION['success'] = "You are now logged in";
    //                global $user_id;
    //                $query2 = "SELECT id FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    //                $results2 = mysqli_query($db, $query2) or die ("Could not get user_id from DB." . mysqli_error());
    //                $user_id = mysqli_fetch_assoc($results2);
    //                $_SESSION['user_id'] = $user_id;
            //header("location: ?controller=event&action=search_events");
        } else {
            echo "Wrong username/password combination" . '<br>';
        }
    }

	public static function editUser($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId){
		//edit user
		$db = Db::getInstance();
        $req = $db->prepare('UPDATE TABLE_NAME SET 
                firstName = ?,
                lastName = ?,
                email = ?,
                password = ?,
                phoneNumber = ?,
                notificationState = ?,
                userTypeId = ? WHERE id = ?');

        $req->bind_param('$userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId');
        $req->execute();
	}

	public function deleteUser($user_id){
        $db = Db::getInstance();
		$query = 'DELETE FROM users WHERE user_id = ?';
		return ($this->db->query($query));
	}

	public function getUserById($user_id){
        $db = Db::getInstance();
		// Prepare the query
        $query = $db->prepare('SELECT column_name FROM table_name WHERE id = ?');
		return ($this->db->query($query));
	}
}
?>