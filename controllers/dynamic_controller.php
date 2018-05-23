<?php
  class DynamicController {
    public function home() {
      require_once('views/dynamic/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>