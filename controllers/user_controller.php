<?php

class UserController {

    public function register() {
        if (isset($_POST['register_btn'])) {
            User::addNewUser();
        }
        require_once('views/user/registration.php');
    }

    public function login() {
        if (isset($_POST['login_btn'])) {
            User::login();
        }
        require_once('views/user/signUp.php');
    }

//    public function signout() {
//        require_once('views/user/signout.php');
//    }

}