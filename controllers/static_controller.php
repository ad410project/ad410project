<?php

class StaticController {

    public function landing() {
        require_once('views/static/landing.php');
    }

    public function error() {
        require_once('views/static/error.php');
    }

    public function terms() {
        require_once('views/static/terms.php');
    }
}

?>