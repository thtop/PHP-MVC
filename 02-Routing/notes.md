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