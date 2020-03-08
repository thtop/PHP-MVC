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
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);

// Match the requested route
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
  echo '<pre>';
  var_dump($router->getParams());
  echo '</pre>';
} else {
  echo "No route found for URL '$url' ";
}