<?php
  function call($controller, $action) {
          require_once('controllers/' . $controller . '_controller.php');

          switch($controller) {
              case 'pages':
                  $controller = new PagesController();
                  break;
    }

    $controller->{ $action }();
  }

  // One entry for static pages, one for our Books controller
  $controllers = array('pages' => ['home', 'error']);

// check that the requested controller and action are both allowed
// if someone tries to access something else
// they will be redirected to the error action of the pages controller

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>