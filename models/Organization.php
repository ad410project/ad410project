<?php
    class Organization {
        
        private $orgId;           // ID Ex: <to be defined>
        private $orgName;         // Name            Ex: The Summer Camp Group
        private $orgPhoneNumber;  // Phone Number    Ex: 123-456-7891
        private $orgDescription;  // Description     Ex: 'Summer Kids Camp etc.'
        private $orgWebsite;      // Website URL     Ex: www.example.com
        private $orgAdminId;      // Admin User ID   Ex: <to be defined>
        private $addressId        // Address ID      Ex. 17 - within the database
        private $addressLine1;    // Address Line 1  Ex: 1600 Amphitheatre Pkwy.
        private $addressLine2;    // Address Line 2  Ex: Unit 2
        private $addressCity;     // City            Ex: Mountain View
        private $addressState;    // State           Ex: CA
        private $addressZipCode;  // Postal Zipcode  Ex: 94043
        
        /* 
        * Construct an Organization 
        *
        * @param Integer        $orgId           Organization ID              Ex: <to be defined>
        * @param String         $orgName         Organization Name            Ex: The Summer Camp Group
        * @param Integer        $orgPhone        Organization Phone Number    Ex: 123-456-7891
        * @param String         $orgDescription  Organization Description     Ex: test@example.com
        * @param String         $orgWebsite      Organization Website URL     Ex: www.example.com
        * @param Integer        $orgAdminId      Organization Admin User ID   Ex: <to be defined>
        * @param Integer        $addressId       Organization Address ID      Ex. 2
        * @param String         $addressLine1    Organization Street address  Ex: 1600 Amphitheatre Pkwy.
        * @param String         $addressCity     Organization State           Ex: CA
        * @param String         $addressState    Organization City            Ex: Mountain View
        * @param Integer        $addressZipCode  Organization Postal Zipcode  Ex: 94043
        */
        public function __construct($orgId, $orgName, $orgPhone, $orgDescription, $orgWebsite, $admin_id, 
            $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode) {
            
            $this->orgId            = $orgId; 
            $this->orgName          = $orgName;            
            $this->orgPhone         = $orgPhone;
            $this->orgDescription   = $orgDescription;
            $this->orgWebsite       = $orgWebsite;
            $this->admin_id         = $admin_id;
            $this->addressId        = $addressId;
            $this->addressLine1	    = $addressLine1; 
            $this->addressLine2	    = $addressLine2;
            $this->addressCity	    = $addressCity; 
            $this->addressState     = $addressState;   
            $this->addressZipCode   = $addressZipCode;      
        }
        /* 
        * Add an Organization to the Database with the following attributes
        *
        * @param Integer        $orgId           Organization ID              Ex: <to be defined>
        * @param String         $orgName         Organization Name            Ex: The Summer Camp Group
        * @param Integer        $orgPhone        Organization Phone Number    Ex: 123-456-7891
        * @param String         $orgDescription  Organization Description     Ex: test@example.com
        * @param String         $orgWebsite      Organization Website URL     Ex: www.example.com
        * @param Integer        $orgAdminId      Organization Admin User ID   Ex: <to be defined>
        * @param Integer        $addressId       Organization Address ID      Ex. 2
        * @param String         $addressLine1    Organization Street address  Ex: 1600 Amphitheatre Pkwy.
        * @param String         $addressCity     Organization State           Ex: CA
        * @param String         $addressState    Organization City            Ex: Mountain View
        * @param String         $addressZipCode  Organization Postal Zipcode  Ex: 94043
        *
        */
        public static function addOrganization($orgId, $orgName, $orgDescription, $orgPhone, $orgWebsite, $admin_id, 
            $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode) {      
                
            $db = Db::getInstance();

            // Prepare query to create address record
            $req = $db->prepare('INSERT INTO addresses VALUES DEFAULT, ?, ?, ?, ?, ?;');

            // Bind parameters for address
            $req->bind_param('sssss', $addressLine1, $addressLine2 $addressCity, $addressState, $addressZipCode);

            $req->execute();

            // Prepare query to obtain the newly added address ID
            $req = $db->prepare('SELECT addressID 
                                    FROM addresses 
                                    WHERE addressLine1 = ?
                                        AND addressLine2 = ?
                                        AND city = ?
                                        AND state = ?
                                        AND postalCode = ?;');

            // Bind parameters for address
            $req->bind_param('sssss', $addressLine1, $addressLine2 $addressCity, $addressState, $addressZipCode);

            $req->execute();
            
            $req->bind_result($addressId);

            // Prepare query to insert new organization in the database
            $req = $db->prepare('INSERT INTO organizations VALUES (DEFAULT, ?, ?, ?, ?, ?, ?);');
       
            // Bind parameters for address
            $req->bind_param('issisi', $addressId, $orgName, $orgDescription, $orgPhone, $orgWebsite, $admin_id);
            
            // Prepare query to obtain the newly added organization ID
            $req = $db->prepare('SELECT organizationId FROM organizations WHERE addressId = ?;');

            // Bind parameters for address
            $req->bind_param('i', $addressId);

            $req->execute();
            
            $req->bind_result($orgId);

            // Close Connection
            $db->close();

            if ($orgId) { 
                return $orgId;
            }
            else {
                return 'New Organization could not be created';
            }
        }
        /* 
        * Edit an Organization in the Database including the following attributes for an organization. 
        *
        * @param Integer        $orgId           Organization ID              Ex: <to be defined>
        * @param String         $orgName         Organization Name            Ex: The Summer Camp Group
        * @param Integer        $orgPhone        Organization Phone Number    Ex: 123-456-7891
        * @param String         $orgDescription  Organization Description     Ex: test@example.com
        * @param String         $orgWebsite      Organization Website URL     Ex: www.example.com
        * @param Integer        $orgAdminId      Organization Admin User ID   Ex: <to be defined>
        * @param Integer        $addressId       Organization Address ID      Ex. 2
        * @param String         $addressLine1    Organization Street address  Ex: 1600 Amphitheatre Pkwy.
        * @param String         $addressCity     Organization State           Ex: CA
        * @param String         $addressState    Organization City            Ex: Mountain View
        * @param String         $addressZipCode  Organization Postal Zipcode  Ex: 94043
        *
        */
        public static function editOrganization($orgId, $addressId, $orgName, $orgDescription, $orgPhone, $orgWebsite, $admin_id, 
        $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode) {

            $db = Db::getInstance();

            // Prepare query to update address record
            $req = $db->prepare('UPDATE addresses 
                                    SET addressLine1=?, 
                                        addressLine2=?, 
                                        city=?, 
                                        state=?, 
                                        postalCode=?
                                    WHERE addressId = ?;');

            // Bind parameters for address update
            $req->bind_param('sssssi', $addressLine1, $addressLine2 $addressCity, $addressState, $addressZipCode, $addressId);

            $req->execute();

            // Prepare query to update organizations record
            $req = $db->prepare('UPDATE organizations 
                                    SET addressId=?, 
                                        organizationName=?, 
                                        organizationDescription=?, 
                                        phoneNumber=?, 
                                        organizationWebsite=?, 
                                        userId=?
                                    WHERE organizationId = ?;');

            // Bind parameters for organization update
            $req->bind_param('issisii', $addressId, $orgName, $orgDescription, $orgPhone, $orgWebsite, $admin_id, $orgId);

            $req->execute();
            
            // Close Connection
            $db->close();

            return 'Organization Updated';
        }
        /* 
        * Get an Organization from the database 
        *
        * @param Integer        $orgId Organization ID Ex: <to be defined>
        * 
        * @return Organization 
        */
        public static function getOrganization($orgId) {
            
            $db = Db::getInstance();
            
            // Prepare the query to get the organization 
            $req = $db->prepare('SELECT organizationId, addressId, organizationName, organizationDescription, phoneNumber, organizationWebsite, userId 
                                    FROM organizations 
                                    WHERE organizationId = ?;');
        
            // we make sure $orgId is an integer
            $orgId = intval($orgId);

            // with a valid organization id
            $req->bind_param('i', $orgId);
            $req->execute();

            // bind variables to prepared statement
            $req->bind_result($orgId, $addressId, $orgName, $orgDescription, $orgPhone, $orgWebsite, $admin_id);

            // fetch values
            $req->fetch();

            // Prepare the query to get the address
            $req = $db->prepare('SELECT addressLine1, addressLine2, city, state, postalCode
                                    FROM addresses
                                    WHERE addressId = ?;');

            // we make sure $addressId is an integer
            $addressId = intval($addressId);

            // with a valid organization id
            $req->bind_param('i', $addressId);
            $req->execute();

            // bind variables to prepared statement
            $req->bind_result($addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode);

            // fetch values
            $req->fetch();

            // Close Connection
            $db->close();

            return new Organization($orgId, $addressId, $orgName, $orgDescription, $orgPhone, $orgWebsite, $admin_id, 
            $addressLine1, $addressLine2, $addressCity, $addressState, $addressZipCode);
        }
        /* 
        * Remove an Organization and it's address from the database 
        *
        * @param Integer        $orgId Organization ID Ex: <to be defined>
        */
        public static function deleteOrganization($orgId) {
            
            $db = Db::getInstance();
        
            // Prepare the query to get the address ID
            $req = $db->prepare('SELECT addressId 
                                    FROM organizations 
                                    WHERE organizationId = ?;');
        
            // we make sure $orgId is an integer
            $orgId = intval($orgId);

            // with a valid organization id
            $req->bind_param('i', $orgId);
            $req->execute();

            // bind variables to prepared statement
            $req->bind_result($addressId);

            // fetch values
            $req->fetch();

            if ($addressId = null) {
                return "Invalid Organization ID";
            } else {
                // Prepare the query to delete the organization
                $req = $db->prepare('DELETE FROM organizations WHERE organizationId = ?;');

                // with a valid organization id
                $req->bind_param('i', $orgId);
                $req->execute();
                
                // Prepare the query to delete the address
                $req = $db->prepare('DELETE FROM addresses WHERE addressId = ?;');
            
                // we make sure $addressId is an integer
                $addressId = intval($addressId);

                // with a valid address id
                $req->bind_param('i', $addressId);
                $req->execute();

                // Close Connection
                $db->close();
            }
        }
        /* 
        * Update an organization's admin user id  in the database 
        *
        * @param Integer        $orgId Organization ID Ex: <to be defined>
        * @param Integer        $user_id         User ID         Ex: <to be defined>
        * 
        */
        public static function updateOrgAdmin($orgId, $user_id) {
            // Verify integers
            $orgId = intval($orgId);
            $user_id = intval($user_id);

            $db = Db::getInstance();
        
            // Prepare the query to update the admin id
            $req = $db->prepare('UPDATE organizations 
                                    SET userID = ?
                                    WHERE organizationId = ?;');
        
            // with a valid organization id
            $req->bind_param('ii',  $user_id, $orgId );

            $req->execute();

            // Prepare the query check the update
            $req = $db->prepare('SELECT userID WHERE organizationId = ?;');
        
            // with a valid organization id
            $req->bind_param('i', $orgId );

            $req->execute();

            // bind variables to prepared statement to get admin user ID
            $req->bind_result($adminId);

            // fetch values
            $req->fetch();

            // Close Connection
            $db->close();

            // Compare DB value with value originally submitted
            if ($user_id != $adminId) {
                return 'Organization Admin User Id Update Not Successful';
            } else {
                return 'Organization Admin User Id Update Successful'
            }

        }
        /* 
        * Get all events based on organization id 
        *
        * @param Integer        $orgId Organization ID Ex: <to be defined>
        */
        public static function getOrganizationEvents($orgId) {
            
            $db = Db::getInstance();
             
            // Prepare the query
            $stmt = $db->prepare("SELECT eventId FROM events WHERE organizationId = ?;")) {

            // we make sure $orgId is an integer
            $orgId = intval($orgId);

            // with a valid organization id
            $stmt->bind_param('i', $orgId);

            /* execute statement */
            $stmt->execute();

            /* bind result variables */
            $stmt->bind_result($eventId);

            // Create the Array
            $list = [];

            /* fetch values */
            while ($stmt->fetch()) {
                $list[]=  $eventId;
            }

            /* close statement */
            $stmt->close();

            return $list;
        }

        public function getOrgId()
        {
            return $this->$orgId; 
        }
                    
        public function getName()
        {
            return $this->$orgName; 
        }
                
        public function getPhone()
        {
            return $this->phone; 
        }
                
        public function getDescription()
        {
            return $this->orgDescription;   
        }
                    
        public function getURL()
        {
            return $this->url;  
        }
        
        public function getAdmin_id()
        {
            return $this->admin_id; 
        }
        
        public function getAddressId()
        {
            return $this->addressId; 
        }

        public function getaddressLine1()
        {
            return $this->addressLine1; 
        }
        public function getaddressLine2()
        {
            return $this->addressLine2; 
        }
            
        public function getAddressCity()
        {
            return $this->addressCity;      
        }
        
        public function getAddressState()
        {
            return $this->addressState; 
        }
        
        public function getAddressZipCode()
        {
            return $this->addressZipCode; 
        }

    }
?>