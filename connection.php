<?php
require('configuration.php');

// singleton class for Db instance
class Db
{
    // issue 1 - $instance field should be initialized to NULL
    private static $instance = 		;

    // issue 2 - constructor missing its closing curly brace
    private function __construct()
    {


        // issue 3 - the isset parameter in the if statement of getInstance() function should be self::$instance
        // issue 4 - getInstance() function missing the 'new' keyword before mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        // issue 5 - the instantiation of mysqli in the getInstance() function is missing its last parameter (should be: DB_PORT);
        // issue 6 - getInstance() function should return self::$instance
    }
    public static function getInstance()
    {
        if (!isset( 		)) {
            self::$instance = 	 	mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE,			);
        }
        return 		;
    }

}
?>