<?php

// Include the autoload register
require_once 'autoload.php';


// Include a Sessions file 
include_once 'sessions.php';


// Authenticate 
Auth::check_authentication();


// Require an options file which basically acts like a setup for the entire site... 
// fetches information about the website from the db
// and creates constants for use throughout the site. 
// also creates handy server and directory constants
require_once '../options.php';


if (isset($_POST['login'])) AUTH::do_login();


$page = new PageBuilder;

// Fetch Header
$page -> do_sym_header();


echo Run::render_template_with_content(
    PATH_TO_SYM_THEME . 'default.php',
    array(
        'login' => true,
        'title' => 'Welcome to Syteman',
        'content' => 'Login to your Website Content Manager to Proceed',
        'template' => 'login.html'
    )
);


// Pull up the Foot
$page -> do_sym_footer();


// Close the DB Connection
$db_connect = null;