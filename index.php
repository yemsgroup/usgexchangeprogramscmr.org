<?php

// Include the autoload register
require_once 'syteman/autoload.php';


// Include a Sessions file 
include_once 'syteman/sessions.php';


// Require an options file which basically acts like a setup for the entire site... 
// fetches information about the website from the db
// and creates constants for use throughout the site.
// also creates handy server and directory constants
require_once 'options.php';


// Route the Current Page.
// Should get information about the data fetched from DB about the current page and use it to render the page.
$route = new Route;
$route_info = $route -> route(CURRENT_PAGE);


// Optionally Dump Program Feedback in [only while in Development mode]
if(defined('DEVELOPMENT')) {
    
    if(isset($feedback)) {

        if(!empty($feedback)) {

            echo '<section class="error" style="padding:15px; margin-top:25px; background:#DDD;">';

                foreach($feedback as $message) 
                    foreach($message as $status => $info) 
                        echo $status . ': ' . $info . '<hr>';

            echo '</section>';

        }

    }

}