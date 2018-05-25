<?php

function call($controller, $action) {
    require_once('controllers/'. $controller .'_controller.php');

    switch($controller) {
        case 'static':
            $controller = new StaticController();
            break;
        case 'dynamic':
//            require_once('model/model.php');
            $controller = new DynamicController();
            break;
    }

    $controller->{ $action }();
}

$controllers = array('static' => ['landing', 'error', 'registration', 'profile', 'login', 'logout', 'searchEvents']);

// check that the requested controller and action are both allowed
// if someone tries to access something else
// they will be redirected to the error action of the pages controller

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('static', 'error');
    }
} else {
    call('static', 'error');
}
