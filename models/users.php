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

}

	public function __construct($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId){

		$this->userId 					= $userId;
	    $this->firstName 				= $firstName;
	    $this->lastName 				= $lastName;
	    $this->email					= $email;
	    $this->password					= $password;
	    $this->phoneNumber  			= $phoneNumbe;
	    $this->notificationState 		= $notificationState;
		$this->userTypeId				= $userTypeId;
	}

	public function addUser($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId){

		//instance of db
		$db = Db::getInstance();

		//add user to database
		$req = $db->prepare('INSERT INTO users firstName, lastName, email, password, phoneNumber, notificationState, userTypeId 
                                                       VALUES ?, ?, ?, ?, ?, ?, ?)';  

        $req->bind_param($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId);
        $req->execute();                                               
	}

	public static function editUser($userId, $firstName, $lastName, $email, $password, $phoneNumber, $notificationState, $userTypeId){

		//instance of db
		$db = Db::getInstance();

		//edit user 
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

	public static function deleteUser($user_id){
		//instance of db
		$db = Db::getInstance();

		$query = 'DELETE FROM users WHERE user_id = ?';
		return ($this->db->query($query));
	}

	public static function getUserById($user_id){
		//instance of db
		$db = Db::getInstance();
		
		// Prepare the query 
        $req = $db->prepare('SELECT column_name FROM table_name WHERE id = ?');
		return ($this->db->query($query));
	}
?>