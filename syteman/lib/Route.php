<?php

class Route {
    
    public function __construct() 
    {

        // Mine the PATH_INFO data and create a CURRENT_PAGE Constant 
        // to be used to fetch data about said page from db
        $this->path_info_array = explode('/', PATH_INFO);
        $this->path_args = count($this->path_info_array);

        $this->current_page = $this->path_info_array[1];
        defined('CURRENT_PAGE') or define('CURRENT_PAGE', $this->current_page);

    }


    static function mine_path_info_constant() 
    {

        $path_info = substr(PATH_INFO, 1, strlen(PATH_INFO));
        $path_info_array = explode('/', $path_info);
        
        return $path_info_array;

    }


    static function get_base_page() 
    {
        return self::mine_path_info_constant()[0];

    }


    static function is_category_page()
    {
        
        return self::check_for_variable_url_param('c'); 

    }
    

    static function is_paginated()
    {
        
        return self::check_for_variable_url_param('p'); 

    }


    static function is_feature_page() 
    {

        $path = self::mine_path_info_constant();

        if (count($path) > 1 && ($path[1] != 'c' AND $path[1] != 'p' AND $path[1] != 'new')) {
            
            return $path;

        } elseif (!empty($_GET)) {

            if (!Route::is_category_page() AND !Route::is_paginated()) {

                $path = array();
                
                foreach ($_GET as $feature=>$value) {

                    $path[] = $feature;
                    $path[] = $value;

                }

                $new_path = '';
                foreach($path as $index=>$item) {
                    
                    if ($index != 0) $new_path .= '/' . $item;

                }

                $redirect_to = BASE_URL . PATH_INFO . $new_path;

                Run::redirect_to($redirect_to);
                
            } else return false;

        } else return false;

    }


    static function is_add_feature_page() 
    {

        $path = self::mine_path_info_constant();

        if (count($path) > 1 && ($path[1] == 'new')) return $path;
            else return false;

    }


    static function is_edit_page() 
    {

        $path = self::mine_path_info_constant();
        
        if (in_array('edit', $path)) return $path;
            else return false;

    }


    static function get_id_to_edit()
    {

        if (self::is_edit_page()) {
            
            $edit_info = self::is_edit_page();
            
            $edit_key = array_search('edit', $edit_info);
            $edit_item_key = $edit_key - 1;

            if (!empty($edit_item_key)) return $edit_info[$edit_item_key];
            else return 'boo';

        }

    }


    static function is_delete_feature_page() 
    {

        $path = self::mine_path_info_constant();
        if (count($path) > 1 && (in_array('delete', $path))) return $path;
            else return false;

    }


    static function get_id_to_delete()
    {

        if (self::is_delete_feature_page()) {
            
            $delete_info = self::is_delete_feature_page();
            
            $delete_key = array_search('delete', $delete_info);
            $delete_item_key = $delete_key - 1;

            if (!empty($delete_item_key)) return $delete_info[$delete_item_key];
                else return 'boo';

        }

    }

    
    // this method is used to check for special handlers in the URL like categories or pagination.
    // If they're found, their value is then returned to a set variable to be handled appropriately. 
    // It also checks to ensure that what follows it is not blank or is not another special handler - upon which it will return null.
    static function check_for_variable_url_param($string, $array=null) {

        if ($array != null) $path = $array;
            else $path = explode('/', PATH_INFO);

        $index = (array_search($string, $path));

        if (isset($path[$index + 1])) 
            $value_key = $index + 1;
        else 
            $value_key = $index;

        if (isset($_GET[$string]) && ($_GET[$string] != 'c' && $_GET[$string] != 'p' && $_GET[$string] != '')) {
            
            $new_path = BASE_URL . PATH_INFO . '/' . $string . '/' . $_GET[$string];
            Run::redirect_to($new_path);

        } elseif (in_array($string, $path)) {

            if ($path[$value_key] != 'p' && $path[$value_key] != 'c' && $path[$value_key] != '') 
                return $path[$value_key];
            else
                return null;

        } else {
            
            return null;

        }

    }


    static function resolve_pagination_in_uri($page, $uri=null) {

        if ($uri != null) $path = $uri;
            else $path = REQUEST_URI;

        if (Route::is_paginated($path)) {
            
            $current_page = Route::is_paginated($path);
            $new_page = $page;

            $new_uri = str_replace('p/' . $current_page, 'p/' . $new_page, $path);

        } else $new_uri = $path . '/p/' . $page;

        return $new_uri;

    }


    static function set_language_constant() 
    {
        
        if (isset($_COOKIE['lang'])) {

            switch($_COOKIE['lang']) {
        
                case 2:
        
                    define('LANG_ID', 2);
                    define('LOCALE', 'fr-FR');
                break;
        
                default:
        
                    define('LANG_ID', 1);
                    define('LOCALE', 'en-US');
                break;
        
            }
        
        } else {
            
            define('LANG_ID', 1);
            define('LOCALE', 'en-US');
            
        }

    }


    static function check_db_connection() 
    {}


    // Figure out what page is active and fetch the appropriate controller and process for handling its data.
    // Also, fetch page data from the DB (Basically controller will come from DB)
    function route($current_page=null) {

        if (!empty($_POST)) {
            
            $form = new FormProcess;

        }

        // fetch the page's data from the pages table in the Database
        if ($current_page != null) $check = $current_page;
            else $check = $this->current_page;


        // Create an array of Route info from the routing config file.
        $controllers = require_once ROOT_DIR . '/syteman/config/routing-controllers.php';

        
        // Initialize the Page Object 
        $page = new Page;


        // Get info about current page and call up the appropriate controllers.
        $page_info = $page->get_page_data($check);


        // If page_info returns a page controller value from the db, use it to fetch the appropriate route properties from route_info
        // else use the default standard route properties [from routing config]
        if (!isset($page_info['error'])) {

            $data = $page_info[0];
                
            $route_info = isset($controllers[$data['controller']]) 
                ? $controllers[$data['controller']] 
                : $controllers['standard']
            ;

            $route_info['page_data'] = $data;

        } else {

            // Return 404 data
            $route_info = $controllers['standard'];
            $route_info['page_data'] = PageBuilder::return_404();

        }

        
        // Include the Appropriate Controller from Route info
        include_once 'syteman/controllers/' . $route_info['controller'];


        // return $route_info;

    }

}