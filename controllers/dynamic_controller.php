<?php
  class DynamicController {
    public function home() {
        $users = user::getUserById(2);
      require_once('views/dynamic/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
