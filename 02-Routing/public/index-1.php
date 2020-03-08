<?php

/**
 * Front controller
 * 
 * PHP Version 7.4.1
 */

// $queryString = $_SERVER['QUERY_STRING'];
// echo "Requested URL = '$queryString'";


/**
 * Routing
 */
require '../Core/Router.php';
$router = new Router();
// echo get_class($router);

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('Posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('Posts/new', ['controller' => 'Posts', 'action' => 'new']);

// Display the routing table
echo '<pre>';
var_dump($router->getRoutes());

/*

array(3) {
  [""]=>
  array(2) {
    ["controller"]=>
    string(4) "Home"
    ["action"]=>
    string(5) "index"
  }
  ["Posts"]=>
  array(2) {
    ["controller"]=>
    string(5) "Posts"
    ["action"]=>
    string(5) "index"
  }
  ["Posts/new"]=>
  array(2) {
    ["controller"]=>
    string(5) "Posts"
    ["action"]=>
    string(3) "new"
  }
}

*/

echo '</pre>';
