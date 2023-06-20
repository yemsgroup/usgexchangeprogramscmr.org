<?php

return [
    '' => [
        'controller' => 'show-content.php',
        'process' => 'show_page_with_standard_content'
    ],

    ' ' => [
        'controller' => 'show-content.php',
        'process' => 'show_page_with_standard_content'
    ],

    'index' => [
        'controller' => 'show-content.php',
        'process' => 'show_page_with_standard_content'
    ],

    '404' => [
        'controller' => 'show-content.php',
        'process' => 'show_page_with_standard_content'
    ],

    'standard' => [
        'controller' => 'show-content.php',
        'process' => 'show_page_with_standard_content'
    ],

    'variable_data' => [
        'controller' => 'show-content.php',
        'process' => 'show_page_with_variable_content',
        'method' => 'GET',
        'data' => '',
        'select' => ''
    ]
];