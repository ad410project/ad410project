<?php

class StaticController {

    public function landing() {
        require_once('views/static/landing.php');
    }

    public function error() {
        require_once('views/static/error.php');
    }

    public function registration() {
        require_once('views/static/registration.php');
    }

    public function searchEvents() {
        require_once('views/static/search_events.php');
    }

    public function login() {
        require_once('views/static/login.php');
    }

    public function profile() {
        require_once('views/static/profile.php');
    }

    public function logout() {
        require_once('views/static/logout.php');
    }

}

?>