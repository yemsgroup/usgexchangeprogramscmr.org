<?php

return [
    'PATH_TO_THEMES' => ROOT_DIR . '/content/themes/',
    'PATH_TO_THEME' => ROOT_DIR . '/content/themes/' . ((defined('THEME') && !is_null(THEME)) ? (THEME != '' ? THEME: 'default') : 'default') . '/',
    'PATH_TO_DAOS' => ROOT_DIR . '/daos/',
    
    'REL_PATH_TO_THEMES' => '/content/themes/',
    'REL_PATH_TO_THEME' => '/content/themes/' . ((defined('THEME') && !is_null(THEME)) ? (THEME != '' ? THEME: 'default') : 'default') . '/',
    'REL_PATH_TO_DAOS' => '/daos/',

    'PATH_TO_LIBRARY' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/content/library/',
    'REL_PATH_TO_LIBRARY' => '/content/library/',

    'PATH_TO_IMAGES' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/content/library/images/',
    'REL_PATH_TO_IMAGES' => '/content/library/images/', 
    'PATH_TO_ICONS' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/content/library/icons/',
    'PATH_TO_DOCS' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/content/library/documents/',
    'PATH_TO_VIDS' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/content/library/videos/',

    'PATH_TO_SYM_THEME' => ROOT_DIR . '/syteman/content/themes/default/',
    'REL_PATH_TO_SYM_THEME' => '/syteman/content/themes/default/',
    
    'PATH_TO_SYM_IMAGES' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/syteman/content/library/images/',
    'PATH_TO_SYM_ICONS' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/syteman/content/library/icons/',
    'PATH_TO_SYM_DOCS' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/syteman/content/library/documents/',
    'PATH_TO_SYM_VIDS' => (defined('DEVELOPMENT') ? LOCALHOST : '') . (defined('PROJECT_NAME') ? PROJECT_NAME : '') . '/syteman/content/library/videos/',
];