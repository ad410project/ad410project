<?php

class UserChild
{
    private $host = "HOST";
    private $username = "USERNAME";
    private $password = "PASSWORD";
    private $database = "DATABASE";
    private $port = "DB_PORT";
    private $connection;
    private static $instance;

    public $child_id;
    public $child_name;
    public $child_age;
    public $user_id;

    /*
    Get an instance from database
    @return Instance
    */
    public static function getInstance() {
        if(!self::$instance) {
            // If no instance
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // The Constructor
    private function __construct($child_id ,$user_id, $first_name, $last_name, $child_Dob,$childAllergies,$emergencyContactNum) {

        $this->connection = new mysqli($this->host, $this->username,
            $this->password, $this->database,$this->port);

        // Error
        if(mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
                E_USER_ERROR);
        }

        $this->user_id=$user_id;
        $this->child_id = $child_id;
        $this->first_name=$first_name;
        $this->last_name=$last_name;
        $this->child_Dob=$child_Dob;
        $this->childAllergies=$childAllergies;
        $this->emergencyContactNum=$emergencyContactNum;
    }

    public function addChild($child_id ,$user_id, $first_name, $last_name, $child_Dob,$childAllergies,$emergencyContactNum){
        //add child to the database
        $db = Database::getInstance();

        // Prepare the query
        $stmt = $db->prepare('INSERT INTO Children (childId, userId, firstName, lastName, childDob,childAllergies, emergencyContactNum)
               VALUES (?, ?, ?, ?)');

        $stmt->bind_param($child_id ,$user_id, $first_name, $last_name, $child_Dob,$childAllergies,$emergencyContactNum);

        $stmt->execute();

        $stmt->close();
    }

    public function removeChild($child_id){
        //remove child in the database
        $db = Database::getInstance();

        // Prepare the query
        $stmt = $db->prepare('DELETE FROM Children WHERE child_id = ?');

        $stmt->bind_param($child_id);

        $stmt->execute();

        $stmt->close();
    }

    public static function editChild($child_id ,$user_id, $first_name, $last_name, $child_Dob,$childAllergies,$emergencyContactNum){
		//edit child in the database

        $db = Database::getInstance();
        // Prepare the query
        $stmt = $db->prepare('UPDATE Children
        SET  userId=?, frist_name= ?, last_name=?, child_Dob=?, childAllergies = ?, emergencyContactNum=?
        WHERE childId = ?;');

        $stmt->bind_param($user_id, $first_name, $last_name, $child_Dob,$childAllergies,$emergencyContactNum);

        $stmt->execute();

        $stmt->close();
	}

    public static function findChild($child_id){
    //find child in the database

        $db = Database::getInstance();
        // Prepare the query
        $stmt = $db->prepare('SELECT childId, userId, firstName, lastName, childDob,childAllergies, emergencyContactNum FROM Children
        WHERE childId = ?');

        $stmt->bind_param('s',$child_id);

        $stmt->execute();

        $stmt->bind_result($col1,$col2,$col3,$col4,$col5, $col6, $col7, $col8);

        $stmt->fetch();

        $stmt->close();

        return new UserChild($col1,$col2,$col3,$col4, $col5, $col6, $col7, $col8);
    }

}
