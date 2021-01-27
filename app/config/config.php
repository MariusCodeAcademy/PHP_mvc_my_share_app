<?php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', '_YOUR_DB_USER_');
define('DB_PASS', '_YOUR_DB_PASS_');
define('DB_NAME', '_YOUR_DB_NAME_');

// aprrot wil be used when we need absloute path to our app dir
define('APPROOT', dirname(dirname(__FILE__)));

// URL ROOT will be the path in the url
define('URLROOT', 'http://localhost:8888/my_share');

// Site name 
define('SITENAME', 'My share');


// need to change .htaccess in public
// RewriteBase /__YOUR_SITE_DIR__/public
// replace  __YOUR_SITE_DIR__ with root dir name of your site 
