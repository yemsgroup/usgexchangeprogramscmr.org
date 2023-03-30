<?php

// Include the autoload register
require_once 'autoload.php';


// Include a Sessions file 
include_once 'sessions.php';

// Authenticate
Auth::do_logout();