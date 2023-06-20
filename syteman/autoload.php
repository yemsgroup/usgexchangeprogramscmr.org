<?php

// autoloading for front end files
$autoload = spl_autoload_register(function ($class_name) {

    if (file_exists('syteman/controllers/' . $class_name . '.php')) include_once 'syteman/controllers/' . $class_name . '.php';
    if (file_exists('syteman/lib/' . $class_name . '.php')) include_once 'syteman/lib/' . $class_name . '.php';
    if (file_exists('syteman/daos/' . $class_name . 's/' . $class_name . '.php')) include_once 'syteman/daos/' . $class_name . 's/' . $class_name . '.php';
        elseif (file_exists('syteman/daos/' . $class_name . '/' . $class_name . '.php')) include_once 'syteman/daos/' . $class_name . '/' . $class_name . '.php';
    
    $class = substr($class_name, 9, strlen($class_name));
    if (file_exists('content/features/' . $class . '/' . $class . '.php')) include_once 'content/features/' . $class . '/' . $class . '.php';

});

// autoloading for files in syteman
$autoload = spl_autoload_register(function ($class_name) {

    if (file_exists('controllers/' . $class_name . '.php')) include_once 'controllers/' . $class_name . '.php';
    if (file_exists('lib/' . $class_name . '.php')) include_once 'lib/' . $class_name . '.php';
    if (file_exists('daos/' . $class_name . 's/' . $class_name . '.php')) include_once 'daos/' . $class_name . 's/' . $class_name . '.php';
        elseif (file_exists('daos/' . $class_name . '/' . $class_name . '.php')) include_once 'daos/' . $class_name . '/' . $class_name . '.php';

});