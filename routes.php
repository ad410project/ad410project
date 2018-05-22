<?php

function call($controller, $action) {
    require_once('controllers/'. $controller .'_controller.php');

    switch($controller) {
        case 'static':
            $controller = new StaticController();
            break;
        case 'event':
            require_once('models/event.php');
            $controller = new EventController();
            break;
        case 'user':
            require_once('models/user.php');
            $controller = new UserController();
            break;
        case 'organization':
            require_once('models/organization.php');
            $controller = new OrganizationController();
            break;
    }

    $controller->{$action}();
}

$controllers = array('static' => ['landing', 'error'], 'event' => ['search_events'], 'user' => ['register', 'login'], 'organization' => []);

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
?>