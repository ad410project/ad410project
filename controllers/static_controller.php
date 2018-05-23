<?php
class StaticController{
    public function landing() {
        require_once('views/static/landing.php');
    }

    public function error() {
        require_once('views/static/error.php');
    }

    public function registration() {
        if (isset($_POST['register_btn'])) {
            user::addUser();
        }
        require_once('views/static/registration.php');
    }

    public function searchEvents(){
        require_once('views/static/search_events.php');
    }

}

?>