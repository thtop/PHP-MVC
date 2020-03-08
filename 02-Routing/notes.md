# Routing: how URLs are processed in an MVC Framework

## Create a central entry point to the framework: the front controller

- URL = file location is a bad idea
- The front controller
  - /index.php

Using a front controller

- The URL does **not** map th an individual PHP script
- All requests are sent through **one** page
- This is called a **Front Controller:**
  - Provides a **central entry point** for all requests
  - Handles everything **common to every request**, such as session handling etc.

The request is in the quesy string

- The **query string** is the part of the URL that comes after the first question mark 
  - `localhost.com/index.php?/home`
- We can use this to decide **where** to route the request (i.e **which controller**)
  - `localhost.com/index.php?/show_post/123`
  - `localhost.com/index.php?/posts?page=2`
- The wntire query string will be the **request URL** or **route**

---

## Configure the web servr to have pretty URLs

Remove the default page

- The default page is (most likely) **index.php**
  - `daveh.io/index.php` -> `daveh.io`
- So it can be remored from the URL:
  - `daveh.io/index.php?/posts` -> `daveh.io/?/posts`

Remove the questin mark

- We can also remove the question mark to have "pretty URLs"
  - `daveh.io/?/posts` -> `daveh.io/posts`
- Requires changing the web server configuration
  - `daveh.io/?/posts?page=1` -> `daveh.io/posts?page=1`

---

## Addendum: Possible additional configuration required for the Apache web server

Apache web server

```php
# Remove the question mark from the request but maintain the query string
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.*)$ index.php?$1 [L,QSA]
```

---

## Create and require (not include the router class)

The front controller

- go to `/index.php`

The router

Takes the **request URL** or **route** and decides what to do with it:

- `daveh.ioposts?page2` -> Router -> Controller

Each class in a separate file

Not required, but has advantages:

- Easier to find a specific class in your code -> **easier to maintain**
- Can load the class files **automatically**
  - Router.php
  - Post.php
  - User.php

require **or** included?

To use the class, we need to load the file it's in:

`include 'Router.php';`

or

`require 'Router.php';`

What's the difference?

If the file is not found, `require` will **stop the script** and **produce an error**. `include` will just carry on.

---

## Create the routing table in the router, and add some routes

The router

Decides which **controller** and **action** to run based on the **route**:

`daveh.io/posts?page=2` -> Router -> Controller -> Action

The routing table

The router contains a table that matches **routes** to **controllers** and **action**

| Route          | Controller  | Action |
| -------------- | ----------- | ------ |
| `/`            | Home        | index  |
| `/posts`       | Posts       | index  |
| `/show_post`   | Posts       | show   |
| `/admin/users` | Admin\Users | index  |
| `...`          |             |        |


index.php

```php
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

```

Router.php

```php
<?php

/**
 * Router
 * 
 * PHP version 7.4.1
 */
class Router
{
  /**
   * Associative array of routes (the routing table)
   * @var array
   */
  protected $routes = [];

  /**
   * Add a route to the routing table
   * 
   * @param string $route The route URL
   * @param array $params Parameters (controller, action, etc.)
   * 
   * @return void
   */

   public function add($route, $params) {
     $this->routes[$route] = $params;
   }

   /**
    * Get all the routes from the routing table
    * @return array
    */
    public function getRoutes()
    {
      return $this->routes;
    }
}
```

---

## Match the requested route to the list of routes in the routing table

Matching the request URL to the route

The router matches the **route** to a **conroller** and **action**:

| Route          | Controller  | Action |
| -------------- | ----------- | ------ |
| `/`            | Home        | index  |
| `/posts`       | Posts       | index  |
| `/show_post`   | Posts       | show   |
| `/admin/users` | Admin\Users | index  |
| `...`          |             |        |


- `daveh.io/posts` -> Router ->
  - controller = **Posts**
  - action = **index**

index.php

```php
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
```

Router.php

```php
# Routing: how URLs are processed in an MVC Framework

## Create a central entry point to the framework: the front controller

- URL = file location is a bad idea
- The front controller
  - /index.php

Using a front controller

- The URL does **not** map th an individual PHP script
- All requests are sent through **one** page
- This is called a **Front Controller:**
  - Provides a **central entry point** for all requests
  - Handles everything **common to every request**, such as session handling etc.

The request is in the quesy string

- The **query string** is the part of the URL that comes after the first question mark 
  - `localhost.com/index.php?/home`
- We can use this to decide **where** to route the request (i.e **which controller**)
  - `localhost.com/index.php?/show_post/123`
  - `localhost.com/index.php?/posts?page=2`
- The wntire query string will be the **request URL** or **route**

---

## Configure the web servr to have pretty URLs

Remove the default page

- The default page is (most likely) **index.php**
  - `daveh.io/index.php` -> `daveh.io`
- So it can be remored from the URL:
  - `daveh.io/index.php?/posts` -> `daveh.io/?/posts`

Remove the questin mark

- We can also remove the question mark to have "pretty URLs"
  - `daveh.io/?/posts` -> `daveh.io/posts`
- Requires changing the web server configuration
  - `daveh.io/?/posts?page=1` -> `daveh.io/posts?page=1`

---

## Addendum: Possible additional configuration required for the Apache web server

Apache web server

```php
# Remove the question mark from the request but maintain the query string
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.*)$ index.php?$1 [L,QSA]
```

---

## Create and require (not include the router class)

The front controller

- go to `/index.php`

The router

Takes the **request URL** or **route** and decides what to do with it:

- `daveh.ioposts?page2` -> Router -> Controller

Each class in a separate file

Not required, but has advantages:

- Easier to find a specific class in your code -> **easier to maintain**
- Can load the class files **automatically**
  - Router.php
  - Post.php
  - User.php

require **or** included?

To use the class, we need to load the file it's in:

`include 'Router.php';`

or

`require 'Router.php';`

What's the difference?

If the file is not found, `require` will **stop the script** and **produce an error**. `include` will just carry on.

---

## Create the routing table in the router, and add some routes

The router

Decides which **controller** and **action** to run based on the **route**:

`daveh.io/posts?page=2` -> Router -> Controller -> Action

The routing table

The router contains a table that matches **routes** to **controllers** and **action**

| Route          | Controller  | Action |
| -------------- | ----------- | ------ |
| `/`            | Home        | index  |
| `/posts`       | Posts       | index  |
| `/show_post`   | Posts       | show   |
| `/admin/users` | Admin\Users | index  |
| `...`          |             |        |


index.php

```php
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

```

Router.php

```php
<?php

/**
 * Router
 * 
 * PHP version 7.4.1
 */
class Router
{
  /**
   * Associative array of routes (the routing table)
   * @var array
   */
  protected $routes = [];

  /**
   * Add a route to the routing table
   * 
   * @param string $route The route URL
   * @param array $params Parameters (controller, action, etc.)
   * 
   * @return void
   */

   public function add($route, $params) {
     $this->routes[$route] = $params;
   }

   /**
    * Get all the routes from the routing table
    * @return array
    */
    public function getRoutes()
    {
      return $this->routes;
    }
}
```

---

## Match the requested route to the list of routes in the routing table

Matching the request URL to the route

The router matches the **route** to a **conroller** and **action**:

| Route          | Controller  | Action |
| -------------- | ----------- | ------ |
| `/`            | Home        | index  |
| `/posts`       | Posts       | index  |
| `/show_post`   | Posts       | show   |
| `/admin/users` | Admin\Users | index  |
| `...`          |             |        |


- `daveh.io/posts` -> Router ->
  - controller = **Posts**
  - action = **index**

index.php

```php
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
```
---

Router.php

```php
<?php

/**
 * Router
 * 
 * PHP version 7.4.1
 */
class Router
{
  /**
   * Associative array of routes (the routing table)
   * @var array
   */
  protected $routes = [];

  /**
   * Parameters from the matched route
   * @var array
   */
  protected $params = [];

  /**
   * Add a route to the routing table
   * 
   * @param string $route The route URL
   * @param array $params Parameters (controller, action, etc.)
   * 
   * @return void
   */

   public function add($route, $params) {
     $this->routes[$route] = $params;
   }

   /**
    * Match the route to the routes in the routing table, setting the $params property if a foute is found.
    * @param string $url The route URL
    *
    * @return boolean true if a match found, false otherwise
    */
    public function match($url)
    {
      foreach ($this->routes as $route => $params) {
        if ($url == $route) {
          $this->params = $params;
          return true;
        }
      }
      return false;
    }

    /**
     * Get the currently matched parameters
     * 
     * @return array
     */
    public function getParams()
    {
      return $this->params;
    }

   /**
    * Get all the routes from the routing table
    * @return array
    */
    public function getRoutes()
    {
      return $this->routes;
    }
}
```
