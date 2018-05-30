<?php

class UserChild
{

    public $child_id;
    public $first_name;
    public $last_name;
    public $child_Dob;
    public $childAllergies;
    public $emergencyContactNum;
    public $child_age;
    public $user_id;

    // The Constructor
    private function __construct($child_id ,$user_id, $first_name, $last_name, $child_Dob,$childAllergies,$emergencyContactNum) {

        $this->user_id=$user_id;
        $this->child_id = $child_id;
        $this->first_name=$first_name;
        $this->last_name=$last_name;
        $this->child_Dob=$child_Dob;
        $this->childAllergies=$childAllergies;
        $this->emergencyContactNum=$emergencyContactNum;
    }

    public function addChild($child_id, $user_id, $first_name, $last_name, $child_Dob, $childAllergies, $emergencyContactNum){
        //add child to the database
        $db = Database::getInstance();

        // Prepare the query
        $stmt = $db->prepare('INSERT INTO Children (childId, userId, firstName, lastName, childDob, childAllergies, emergencyContactNum)
               VALUES (?, ?, ?, ?)');

        $stmt->bind_param('sssd',$child_id, $user_id, $first_name, $last_name, $child_Dob, $childAllergies, $emergencyContactNum);

        $stmt->execute();

        $stmt->close();
    }

    public function removeChild($child_id){
        //remove child in the database
        $db = Database::getInstance();

        // Prepare the query
        $stmt = $db->prepare('DELETE FROM Children WHERE child_id = ?');

        $stmt->bind_param('i',$child_id);

        $stmt->execute();

        $stmt->close();
    }

    public static function editChild($child_id,$user_id, $first_name, $last_name, $child_Dob,$childAllergies,$emergencyContactNum){
		//edit child in the database

        $db = Database::getInstance();
        // Prepare the query
        $stmt = $db->prepare('UPDATE Children
        SET  user_id=?, frist_name= ?, last_name=?, child_Dob=?, childAllergies = ?, emergencyContactNum=?
        WHERE childId = ?;');

        $stmt->bind_param('sssd',$user_id, $first_name, $last_name, $child_Dob, $childAllergies, $emergencyContactNum,$child_id);

        $stmt->execute();

        $stmt->close();
	}

	//Get a Child by Id
    public static function getChild($child_id){
    //find child in the database

        $db = Database::getInstance();
        // Prepare the query
        $stmt = $db->prepare('SELECT childId, userId, firstName, lastName, childDob,childAllergies, emergencyContactNum FROM Children
        WHERE childId = ?');

        $stmt->bind_param('i',$child_id);

        $stmt->execute();

        $stmt->bind_result($col1,$col2,$col3,$col4,$col5, $col6, $col7, $col8);

        $stmt->fetch();

        $stmt->close();

        return new UserChild($col1,$col2,$col3,$col4, $col5, $col6, $col7, $col8);
    }

}
