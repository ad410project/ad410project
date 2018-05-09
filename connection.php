<?php
require ("configuration.php");
  class Db
  {
      private static $instance = NULL;

      private function __construct()
      {
      }

      public static function getInstance()
      {
          if (!isset(self::$instance)) {
              self::$instance = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
          }
          return self::$instance;
      }
  }
?>