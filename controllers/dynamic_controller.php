<?php
  class DynamicController {
    public function home() {
      require_once('views/dynamic/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }

    public function organization_events() {
        require_once('views/dynamic/organization_events.php');
    }

    public function addEvent() {
          require_once('views/dynamic/addEvent.php');
    }

    public function editEvent() {
          require_once('views/dynamic/editEvent.php');
    }
  }
?>