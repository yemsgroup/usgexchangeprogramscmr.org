<?php

spl_autoload_register(function ($class_name) {

    if (file_exists('../../lib/' . $class_name . '.php')) include_once '../../lib/' . $class_name . '.php';
    if (file_exists('../../daos/' . $class_name . 's/' . $class_name . '.php')) include_once '../../daos/' . $class_name . 's/' . $class_name . '.php';
        elseif (file_exists('../../daos/' . $class_name . '/' . $class_name . '.php')) include_once '../../daos/' . $class_name . '/' . $class_name . '.php';

});