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
    private function __construct($child_id ,$user_id, $child_name, $child_age) {

        $this->connection = new mysqli($this->host, $this->username,
            $this->password, $this->database,$this->port);

        // Error
        if(mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
                E_USER_ERROR);
        }

        $this->user_id=$user_id;
        $this->child_id = $child_id;
        $this->child_name=$child_name;
        $this->child_age=$child_age;
    }

    public function addChild($child_id, $child_name, $user_id, $child_age){
        //add child to the database
        $db = Database::getInstance();

        // Prepare the query
        $stmt = $db->prepare('INSERT INTO table_name (childId, childName, userId, childAge)
               VALUES (?, ?, ?, ?)');

        $stmt->bind_param($child_id, $child_name, $user_id, $child_age);

        $stmt->execute();

        $stmt->close();
    }

    public function removeChild($child_id){
        //remove child in the database
        $db = Database::getInstance();

        // Prepare the query
        $stmt = $db->prepare('DELETE FROM table_name WHERE organization_id = ?');

        $stmt->bind_param($child_id);

        $stmt->execute();

        $stmt->close();
    }

    public static function editChild($child_id, $child_name, $user_id, $child_age){
		//edit child in the database

        $db = Database::getInstance();
        // Prepare the query
        $stmt = $db->prepare('UPDATE table_name
        SET  childName= ?, userId=?,childAge=?
        WHERE childId = ?;');

        $stmt->bind_param($child_name, $user_id, $child_age,$child_id);

        $stmt->execute();

        $stmt->close();
	}

    public static function findChild($child_id){
    //find child in the database

        $db = Database::getInstance();
        // Prepare the query
        $stmt = $db->prepare('SELECT childId, childName, userId, childAge FROM table_name
        WHERE childId = ?');

        $stmt->bind_param('s',$child_id);

        $stmt->execute();

        $stmt->bind_result($col1,$col2,$col3,$col4);

        $stmt->fetch();

        $stmt->close();

        return new UserChild($col1,$col2,$col3,$col4);
    }


}
