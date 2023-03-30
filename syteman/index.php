<?php

// Include the autoload register
require_once 'autoload.php';


// Include a Sessions file 
include_once 'sessions.php';


// Authenticate
Auth::authenticate_admin();


// Require an options file which basically acts like a setup for the entire site... 
// fetches information about the website from the db
// and creates constants for use throughout the site. 
// also creates handy server and directory constants
require_once '../options.php';


// Initialize pageBuilder object
$page = new PageBuilder;


// Pull up the Header
$page -> do_sym_header();


// Pull up the body
$page -> do_sym_page_body();


// Pull up the Foot
$page -> do_sym_footer();


// Close the DB Connection
$db_connect = null;