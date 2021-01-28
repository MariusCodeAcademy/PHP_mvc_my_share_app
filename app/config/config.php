<?php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'my_share');

// aprrot wil be used when we need absloute path to our app dir
define('APPROOT', dirname(dirname(__FILE__)));

// URL ROOT will be the path in the url
define('URLROOT', 'http://localhost:8888/my_share');

// Site name 
define('SITENAME', 'MyShare');

// app version
define("APPVERSION", "1.0.0");



// Table users 
// CREATE TABLE `my_share`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `created_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
