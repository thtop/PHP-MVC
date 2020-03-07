# Introduction: MVC concepts and development environment setup

## Introduction

The course

1. Introduction to MVC and project setup
2. Routing and the front controller
3. Advanced routing
4. Controllers and actions
5. Views
6. Package management with Composer
7. Modles
8. Application configuration and erro handling
9. Conclusion

How to get the most out of the course

- Building a framework form scratch
- Run the code yourself and experiment with it
- All code shown available to download with wach lecture
- Complete the activities and quizzes in each section
- Ask me anything!

---

## The problem with writing web applications: how NOT to structure your code

Writing a web application

```php
<?php

// php code...

?>

// html code...

```

- index.php
- posts.php
- show_post.php
- database.inc.php
- admin/users/php
- ...

URL = flie location

- /
  - index.php
  - posts.php
  - show_post.php
  - admin/
    - users.php

The problems

- **Difficult to maintain the code:** script files are unstrucuted, and you might even have horrid lines like this: `require '../../../../databae.inc.php`
- **Defficult to develop:** application logic is mixed up with presentation; a programmer and a designer can't work on the same file
- **Insecure:** database passwords are in a file in publicly-accessible folder

The solution: Use a framework

A framework is a **library** of code. It provides **structure** that you can use to build your application on.

- You can code **faster**.
- **More than one person** can work on the code at once.
- The code is less complicated, so therfore **easier to maintain**.
- **More secure:** database passwords etc. can be stored **outside** of the publicly accessible folder.

---

## The MVC pattern: What it is and how it can help you write better code

Controllers

- Controllers are what the user **interacts** with.
- They receive a **request** from the user, decide what to do, and send a **response** back.
- It's the only component that interacts with the models.

Models

- Models are where an application's **data** are stored.
- Responsible for **storing** and **retrieving** data.
- Know nothing about the user interface.

Views

- Views are what the user sees on the **screen**.
- They **present** the data to the user.
- Know nothing about the models.

Why user MVC?

Business logic separate from presentation: **separation of concerns**

- easier to reuse code
  - developing is **faster**
- code is more organised
  - easier to **understand** and **maintain**
  - easier to **test** the code
  - more **secure**

Developer spacialisation

- Designers can focus on the **front end** without worrying about the business logic
- The developers of the models can focus on the **business logic** or **back end** without worrying about the look and feel

---

## Install a web server, database server and PHP on your computer

Building a PHP MVC framework

- Required components:
  - A web server (for example, Apache)
    - [MAMP](https://www.mamp.info/) and MAMP Pro (Mac/Windows)
    - [XAMPP](https://www.apachefriends.org/index.html) (Mac/Windows/Linux)
    - [AMPPS](https://www.ampps.com/) (Mac/Windows/Linux)
  - PHP
  - A database (for example, MySQL)

- Optional:
  - phpMyAdmmin to namage the database

---

## Start writing framework: Create the folders and configura the web server

Framework folders

- /
  - App
    - Controllers
    - Models
    - Views
  - Core
  - logs
  - public
  - vendor

The **public** folder

- The **only** folder accessible to the web
- The **root** of the web server, i.e. for folder `http://localhost/` points to.
- The **front controller** and any **static files** (CSS, images etc.) go in here
- The big advantage is most of the code, including database passwords, is **not in a web accessible folder** and there fore is **more secure**.

---

## Addendum: Additional configuration for AMPPS on Windows

Addendum: Additional configuration for AMPPS on Windows

If you're using AMPPS on Windows, there's an additional change you need to make to the Apache configuration (not necessary for AMPPS on Linux as shown in the video).

In the Apache configuration file, towards the start of the file, you need to change the DocumentRoot value as shown in the following image:

`DocumentRoot "$path"/www/public`

And don't forget to restart Apache to make sure the changes are applied.

Of course, if you have any problems with the installation or configuration of your web server, please don't hesitate to ask a question.
