<?php 
class  user{
	public $user_id;
	public $usertype_id;
	public $name;
	public $email_address;
	public $zip_code;
	public $address;
	public $phone;
	public $address;
}

	public function user($user_id, $usertype_id, $name, $email_address, $zip_code, $address, $phone){

		$this->user_id 			= $user_id;
		$this->usertype_id		= $usertype_id;
	    $this->name 			= $name;
	    $this->email_address 	= $email_address;
	    $this->zip_code 		= $zip_code;
	    $this->address 			= $address;
	    $this->phone 			= $phone;
	}

	public function addUser($user_id, $name, $email_address, $zip_code, $address, $phone){
		//add user to database
		try
       {
           
           $query = 'INSERT INTO users(name, email_address, zip_code, address, phone) 
                                                       VALUES($name, $email_address, $zip_code, $address, $phone)';
              
           $stmt->bindparam("name", $uname);
           $stmt->bindparam("email_address", $email_address);
           $stmt->bindparam("zip_code", $zip_code);            
           $stmt->bindparam("address", $address);            
           $stmt->bindparam("phone", $phone);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
	}

	public static function editUser($user_id, $name, $email_address, $zip_code, $address, $phone){
		//edit user
		if(isset($_POST['update'])){    
		    $id 		= escape_string($_POST['id']);
		    
		    $name 		= escape_string($_POST['name']);
		    $email 		= escape_string($_POST['email']);
		    $zip_code	= escape_string($_POST['zip_code']);
		    $address 	= escape_string($_POST['address']);
		    $phone 		= escape_string($_POST['phone']);
		     
		}
	}

	public static function deleteUser($user_id, $name, $email_address, $zip_code, $address, $phone){
		$query = 'DELETE FROM ? WHERE ? = "' . $user . '"';
		return ($this->db->query($query));
	}

	public static function getUserById($user_id, $name, $email_address, $zip_code, $address, $phone){
		$query = 'SELECT user, password, email, zip_code, address, phone FROM users';
		return ($this->db->query($query));
	}
?>