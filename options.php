<?php

/*
  toggle DEVEVELOPMENT|PRODUCTION|DEBUG Mode 
  Change any of these constants to true based on the environment you wish to be in.
*/
define('DEVELOPMENT', true);
define('DEBUG', true);


// Turn on Error Reporting in DEVELOPMENT MODE.
if (DEBUG) {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

}


/* Create App wide Constants */
// SERVER_NAME Constant
defined('SERVER_NAME') or define('SERVER_NAME', (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : ''));


// CREATE URI Constant
defined('REQUEST_URI') or define('REQUEST_URI', (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));


// CREATE PATH_INFO Constant
defined('PATH_INFO') or define('PATH_INFO', (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/'));


// CREATE REQUEST METHOD Constant
if (isset($_SERVER['REQUEST_METHOD'])) {

    defined('REQUEST_METHOD') or define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
    $requestMethod = $_SERVER['REQUEST_METHOD'];

}


// Create Base URL for absolute linking
$baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . SERVER_NAME;
if (defined('DEVELOPMENT')) {

    defined('LOCALHOST') or define('LOCALHOST', $baseURL . '/');

    $uri_paths = explode('/', REQUEST_URI);
    
    defined('PROJECT_NAME') or define("PROJECT_NAME", "/$uri_paths[1]");

} else {
  
	// if project is in a location other than root in PRODUCTION uncomment the following line with the appropriate location 
	// defined('PROJECT_NAME') or define('PROJECT_NAME', '/preview/');

}


defined('BASE_URL') or define('BASE_URL', $baseURL . (defined('PROJECT_NAME') ? PROJECT_NAME : ''));


// Create Root Directory Constant									                                
defined('ROOT_DIR') or define('ROOT_DIR', dirname(__FILE__));


// Create an array to hold App Feedback
$feedback = array();


// Fetch site_options info from the DB and 
// use the info to create site related Constants for use across the site such as SITE_TITILE, ACRONYM, etc.
$site_ops = new SiteOption;
$site_options = $site_ops -> create_site_information_constants();


// Get [from config] and Create constants for file (images, docs, vids, icons, etc) directories
foreach(require_once('config/directories.php') as $file => $dir)
    defined($file) or define($file, $dir);