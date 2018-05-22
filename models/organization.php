<?php
/**
 * Created by PhpStorm.
 * User: melsm
 * Date: 5/18/2018
 * Time: 3:02 PM
 */

class Organization
{
    public $organization_id; // Organization ID Ex: <to be defined>
    public $name;            // Name            Ex: The Summer Camp Group
    public $phone;           // Phone Number    Ex: 123-456-7891
    public $email;           // Email           Ex: test@example.com
    public $url;             // Website URL     Ex: www.example.com
    public $admin_id;        // Admin User ID   Ex: <to be defined>
    public $addressStreet;   // Street address  Ex: 1600 Amphitheatre Pkwy.
    public $addressCity;     // City            Ex: Mountain View
    public $addressState;    // State           Ex: CA
    public $addressZipCode;  // Postal Zipcode  Ex: 94043
    public $addressCountry;  // Country         Ex: USA

    /*
        * Construct an Organization
        *
        * @param Integer        $organization_id Organization ID              Ex: <to be defined>
        * @param String         $name            Organization Name            Ex: The Summer Camp Group
        * @param String         $phone           Organization Phone Number    Ex: 123-456-7891
        * @param String         $email           Organization Email           Ex: test@example.com
        * @param String         $url             Organization Website URL     Ex: www.example.com
        * @param Integer        $admin_id        Organization Admin User ID   Ex: <to be defined>
        * @param String         $addressStreet   Organization Street address  Ex: 1600 Amphitheatre Pkwy.
        * @param String         $addressCity     Organization State           Ex: CA
        * @param String         $addressState    Organization City            Ex: Mountain View
        * @param Integer        $addressZipCode  Organization Postal Zipcode  Ex: 94043
        * @param String         $addressCountry  Organization Country         Ex: USA
        */
    public function __construct($organization_id, $name, $phone, $email, $url, $admin_id, $addressStreet,
                                $addressCity, $addressState, $addressZipCode, $addressCountry ) {

        $this->organization_id  = $organization_id;
        $this->name             = $name;
        $this->phone            = $phone;
        $this->email            = $email;
        $this->url              = $url;
        $this->admin_id         = $admin_id;
        $this->addressStreet	= $addressStreet;
        $this->addressCity	    = $addressCity;
        $this->addressState     = $addressState;
        $this->addressZipCode   = $addressZipCode;
        $this->addressCountry   = $addressCountry;
    }

    /*
        * Add an Organization to the Database
        *
        * @param String         $name            Organization Name            Ex: The Summer Camp Group
        * @param String         $phone           Organization Phone Number    Ex: 123-456-7891
        * @param String         $email           Organization Email           Ex: test@example.com
        * @param String         $url             Organization Website URL     Ex: www.example.com
        * @param Integer        $admin_id        Organization Admin User ID   Ex: <to be defined>
        * @param String         $addressStreet   Organization Street address  Ex: 1600 Amphitheatre Pkwy.
        * @param String         $addressCity     Organization State           Ex: CA
        * @param String         $addressState    Organization City            Ex: Mountain View
        * @param Integer        $addressZipCode  Organization Postal Zipcode  Ex: 94043
        * @param String         $addressCountry  Organization Country         Ex: USA
        *
        */
    public static function addOrganization($organization_id, $name, $phone, $email, $url, $admin_id,
                                           $addressStreet, $addressCity, $addressState, $addressZipCode, $addressCountry) {

        $db = Db::getInstance();

        // Prepare the query
        $req = $db->prepare('INSERT INTO TABLE_NAME name, phone, email, url, admin_id, addressStreet, addressCity,
                addressState, addressZipCode, addressCountry 
                VALUES ?, ?, ?, ?, ?, ?, ?, ?, ?, ?');


        // Bind parameters
        $req->bind_param('ssssssssss', $name, $phone, $email, $url, $admin_id, $addressStreet,
            $addressCity, $addressState, $addressZipCode, $addressCountry);

        $req->execute();
    }

    /*
        * Get an Organization from the database
        *
        * @param Integer        $organization_id Organization ID Ex: <to be defined>
        *
        * @return Organization
        */

    public static function getOrganization($organization_id) {

        $db = Db::getInstance();

        // Prepare the query
        $req = $db->prepare('SELECT COLUMN_NAMES FROM TABLE_NAME WHERE id = ?');

        // we make sure $organization_id is an integer
        $organization_id = intval($organization_id);

        // with a valid organization id
        $req->bind_param('s', $organization_id);
        $req->execute();

        // bind variables to prepared statement
        $req->bind_result($col1,$col2);

        // fetch values
        $req->fetch();

        return new Organization($col1,$col2);
    }

    /*
    * Remove an Organization from the database
    *
    * @param Integer        $organization_id Organization ID Ex: <to be defined>
    */
    public static function deleteOrganization($organization_id) {

        $db = Db::getInstance();

        // Prepare the query
        $req = $db->prepare('DELETE FROM TABLE_NAME WHERE organization_id = ?');

        // with a valid organization id
        $req->bind_param('s',  $organization_id);

        $req->execute();
    }


}