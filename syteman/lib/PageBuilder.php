<?php 

class PageBuilder extends Db
{

    public function __construct() 
    {

        parent::__construct();

        $this->uri = explode('/', REQUEST_URI);

    }


// Syteman Methods
    public function do_sym_header() 
    {

        // Pull up the Head
        echo Run::render_template_with_content(
            PATH_TO_SYM_THEME . '/web/views/head.html', 
            [
                'title' => 'Welcome to your Dashboard',
                'description' => 'This is the welcome Page'
            ]
        );

        echo Run::render_template_with_content(
            PATH_TO_SYM_THEME . '/web/views/header.html', 
            [
                'title' => 'Welcome to your Dashboard',
                'description' => 'This is the welcome Page',
                'nav_links_to_use' => [
                    ['title' => 'Preview Site', 'link' => '../../', 'target' => '_blank'],
                    // ['title' => 'Settings', 'icon' => 'cogs', 'link' => 'settings']
                ]
            ]
        );

    }


    public function do_sym_page_body() 
    {

        $feature = $page = Route::get_base_page();
        $features = $this->get_feature_list();
        
        if ($page == '' || $page == 'dashboard' || $page == 'home') {

            // If this is the Dashboard
            echo Run::render_template_with_content(
                PATH_TO_SYM_THEME . '/default.php',
                [
                    'title' => 'Welcome to your Dashboard',
                    'description' => '',
                    'content' => '',
                    'template_file' => 'admin-features.html',
                    'features' => $features,
                    'page' => $feature
                ]
            );
        
        } elseif (array_key_exists($feature, $features)) {
            
            // This is a created feature for the site
            // active features are indicated in the /config/features.php file
            $feature_info = $features[$feature];
            $object = new $feature_info['class'];

            // Fetch and create constants for all Features and Categories.
            define('FEATURES', $object->fetch_all_features());
            if (isset($object->feature_category_table)) define('FEATURE_CATEGORIES', $object->fetch_all_feature_categories());
                else define('FEATURE_CATEGORIES', null);

            // Create a variable and rules for paginating features
            $results_per_page = 8;
            $current_page = (Route::is_paginated() != null) ? Route::is_paginated() : 1;
            $results_limit = (($current_page - 1) * $results_per_page) . ',' . $results_per_page;
            
            // Check for and process a Form submission 
            if (!empty($_POST)) {
                
                if (isset($_POST['add-feature'])) $result = $object->add_feature_data();
                elseif (isset($_POST['update-feature'])) $result = $object->update_feature_data();
                elseif (isset($_POST['delete-feature'])) $result = $object->delete_feature_data();
                elseif (isset($_POST['add-feature-category'])) $result = $object->add_feature_category_data();
                elseif (isset($_POST['update-feature-category'])) $result = $object->update_feature_category_data();
                elseif (isset($_POST['delete-feature-category'])) $result = $object->delete_feature_category_data();
                    
                echo '<div class="col-12 py-3 bg-light text-center">';
                    if (isset($result)) {

                        if (is_array($result)) foreach ($result as $feedback) echo $feedback . '<br>';
                            else echo $result;

                    }
                echo '</div>';

            }
            
            if (Route::is_feature_page() != false) {

                // A single featuredata has been selected for RUD 

                $feature = Route::is_feature_page()[1];
                $feature_data = $object->fetch_data_for_this_feature($feature);

                if (Route::is_edit_page() != false) {

                    $edit_array = Route::is_edit_page();
                    $id_to_edit = Route::get_id_to_edit();
    
                    $data_to_edit = $object->fetch_data_for_this_feature($id_to_edit);
                    
                    echo Run::render_template_with_content(
                        PATH_TO_SYM_THEME . '/default.php',
                        [
                            'title' => 'Edit "' . (isset($data_to_edit[0]['title']) ? $data_to_edit[0]['title'] : '') . '"',
                            'description' => '',
                            'content' => '', 
                            'template_file' => 'default-feature-edit.html',
                            'features' => $data_to_edit,
                            'page' => $page
                        ]
                    );
    
                } elseif (Route::is_delete_feature_page() != false) {

                    $delete_array = Route::is_delete_feature_page();
                    $id_to_delete = Route::get_id_to_delete();
    
                    $data_to_delete = $object->fetch_data_for_this_feature($id_to_delete);
                    
                    echo Run::render_template_with_content(
                        PATH_TO_SYM_THEME . '/default.php',
                        [
                            'title' => isset($data_to_delete[0]['title']) ? 'Delete "' . $data_to_delete[0]['title'] . '"' : '',
                            'description' => '',
                            // 'content' => 'Here are the various properties that have been defined', 
                            'template_file' => 'default-feature-delete.html',
                            'features' => $data_to_delete,
                            'page' => $page
                        ]
                    );
                    
                } else {

                    if (!isset($feature_data['error']))
                        echo Run::render_template_with_content(
                            PATH_TO_SYM_THEME . '/default.php',
                            [
                                'template_file' => 'default-feature-view.html',
                                'features' => $feature_data,
                                'page' => $page
                            ]
                        );
                    else 
                        echo Run::render_template_with_content(
                            PATH_TO_SYM_THEME . '/default.php',
                            [
                                'content' => 'Feature Not Found<br> <a href=' . $page . '>Go Back</a>',
                                'template_file' => 'default-feature-view.html',
                                // 'features' => $feature_data,
                                'page' => $page
                            ]
                        );

                }

            } elseif (Route::is_add_feature_page() != false) {
                
                // Add a New Feature
                if (in_array('c', Route::is_add_feature_page()))
                    echo Run::render_template_with_content(
                        PATH_TO_SYM_THEME . '/default.php',
                        [
                            'title' => 'Add New ' . $page . ' Category',
                            'description' => '',
                            'template_file' => 'default-feature-category-add.html',
                            'page' => $page,
                            'add' => '',
                        ]
                    );
                else 
                    echo Run::render_template_with_content(
                        PATH_TO_SYM_THEME . '/default.php',
                        [
                            'title' => 'Add New ' . (substr($page, -1) == 's' ? substr($page, 0, -1) : $page),
                            'description' => '',
                            'template_file' => 'default-feature-add.html',
                            'page' => $page,
                            'add' => '',
                        ]
                    );

            } else {
                
                // Create an Add Button at the top.
                echo '<div class="add-button position-fixed start-50 translate-middle text-center">
                    <a
                        class="btn btn-custom-secondary text-white text-center" 
                        tabindex="0" role="button" 
                        data-bs-toggle="popover" 
                        data-bs-placement="bottom" 
                        data-bs-html="true" 
                        data-bs-trigger="focus" 
                        data-bs-content=\'<strong><a href="' . REQUEST_URI . '/new">' 
                            . strtoupper(
                                substr($feature, -1) == 's' 
                                    ? substr($feature, 0, -1) 
                                    : $feature
                            ) 
                            . '</a><br><a href="' . REQUEST_URI . '/new/c">' . strtoupper('Category') . '</a></strong>\'
                    ><i class="fas fa-plus"></i></a>
                </div>';

                // If Catetgory is selected
                if (Route::is_category_page()) {
                    
                    $category_id = Route::is_category_page();
                    $data_to_edit = $category_info = $object->fetch_data_for_this_category($category_id);

                    $all_features = $object->fetch_features_by_category($category_id);
                    $features = $object->fetch_features_by_category($category_id, ['limit' => $results_limit]);

                    if (Route::is_edit_page() != false) {
                        
                        echo Run::render_template_with_content(
                            PATH_TO_SYM_THEME . '/default.php',
                            [
                                'title' => 'Edit Category "' . $category_info[0]['title'] . '"',
                                'template_file' => 'default-feature-edit.html',
                                'features' => $category_info,
                                'page' => $page
                            ]
                        );

                    } elseif (Route::is_delete_feature_page() != false) {
                        
                        echo Run::render_template_with_content(
                            PATH_TO_SYM_THEME . '/default.php',
                            [
                                'title' => isset($category_info[0]['title']) ? 'Delete Category "' . $category_info[0]['title'] . '"' : '',
                                'template_file' => 'default-feature-delete.html',
                                'features' => $category_info,
                                'page' => $page
                            ]
                        );

                    } else {

                        // Fetch and List all of the data of this category in the feature's DB - Table

                        if (!isset($features['error']))
                            echo Run::render_template_with_content(
                                PATH_TO_SYM_THEME . '/default.php',
                                [
                                    'title' => $feature_info['title'],
                                    'description' => '',
                                    'content' => (!empty($features) ? '' : 'No Data has been added to table'),
                                    'categories' => FEATURE_CATEGORIES, 
                                    'features' => $features,
                                    'page' => $page
                                ]
                            );
                        else 
                            echo Run::render_template_with_content(
                                PATH_TO_SYM_THEME . '/default.php',
                                [
                                    'title' => $feature_info['title'],
                                    'description' => '',
                                    'content' => (!empty($features) ? '' : 'No Data has been added to table'),
                                    'categories' => FEATURE_CATEGORIES, 
                                    // 'features' => $features,
                                    'page' => $page
                                ]
                            );

                    }
                    
                } else {

                    // Fetch and List all of the data in the feature's DB - Table
                    $all_features = FEATURES;
                    $features = $object->fetch_all_features(['limit' => $results_limit]);

                    echo Run::render_template_with_content(
                        PATH_TO_SYM_THEME . '/default.php',
                        [
                            'title' => $feature_info['title'],
                            'description' => '',
                            'content' => (!empty($features) ? '' : 'No Data has been added to table'),
                            'categories' => FEATURE_CATEGORIES, 
                            'features' => $features,
                            'template_file' => (isset($object->preview_template) ? $object->preview_template : null),
                            'page' => $page
                        ]
                    );

                }

                $number_of_pages = ceil(count($all_features) / $results_per_page);
                if ($number_of_pages > 1) echo Run::paginate($number_of_pages, $page, $current_page);

            }

        } else {

            // This is not an existing feature for this site

            echo Run::render_template_with_content(
                PATH_TO_SYM_THEME . '/default.php',
                [
                    'title' => PATH_INFO . ' page instructions pending',
                    'description' => '',
                    'content' => ''
                ]
            );

        }

    }


    public function get_feature_list() 
    {
        
        // Require a feature_config file which stores information about all the features that 
        // site uses and can manage.
        return require_once 'config/features.php';
        
    }


    public function fetch_and_list_features() 
    {}
    

    public function do_sym_footer() 
    {

        echo Run::render_template_with_content(PATH_TO_SYM_THEME . '/web/views/footer.html');
        echo Run::render_template_with_content(PATH_TO_SYM_THEME . '/web/views/foot.html');

    }


// ------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------------------------------------
// Methods for front site
    public function do_header($page_info=null) {
        
        // var_dump($page_info);
        
        // Resolve the meta_data information
        if ($page_info != null) {

            $meta_data = $this->extract_relevant_meta($page_info);
            $url = '';

            $feature_array = Run::check_for_feature($page_info['content']);

            if (isset($feature_array['feature'])) {
                
                $feature_class = ucfirst($feature_array['feature']);

                // Create an instance of the feature at play.
                $object = new $feature_class;

                if (Route::is_feature_page() != false) {

                    $feature_link = Route::is_feature_page()[1];
                    $new_meta = $feature_data = $object->fetch_data_for_this_feature($feature_link)[0];

                } elseif (Route::is_category_page()) {

                    $category = Route::is_category_page();
                    $new_meta = $category_data = $object->fetch_data_for_this_category($category)[0];
                
                }

                if (isset($new_meta)) $meta_data = $this->extract_relevant_meta($new_meta);
                $url = '';

            }

            

        } else {

            $meta_data = null;

        }

        // Get and display the basic head file which loads up the head tag and it's essential dependencies
        echo Run::render_template_with_content(
            PATH_TO_THEME . '/web/views/head.html',
            [
                'title' => $meta_data['title'],
                'keywords' => defined('SITE_KEYWORDS') ? SITE_KEYWORDS : '',
                'author' => isset($meta_data['author']) ? $meta_data['author'] : (defined('SITE_TITLE') ? SITE_TITLE : ''),
                'description' => isset($meta_data['description']) ? strip_tags($meta_data['description']) : '',
                'image' => isset($meta_data['image']) ? $meta_data['image'] : 'default-site-image.jpg',
                'url' => $url
            ]
        );


        // Render the selected theme header with Navigation
        $navigation = new Menu;
        $nav_links = $navigation->get_navigation();

        if (!empty($nav_links)) $nav_links_to_use = $nav_links;
            else $nav_links_to_use = null; // ['No Links have been Defined'] 

        // Get and display the page's chosen header file which loads up what the theme's header looks like 
        echo Run::render_template_with_content(
            PATH_TO_THEME . '/web/views/header.html',
            [
                'nav_links_to_use' => $nav_links_to_use
            ]
        );

    }


    // Show a Standard Page with Content
    public function show_page_with_standard_content($page_data) {

        if ($page_data != null) {
            
            $layout = isset($page_data['layout_filename'])
                ? (
                    !empty($page_data['layout_filename'])
                        ? $page_data['layout_filename']
                        : 'default.php'
                )
                : 'default.php';


            $template = PATH_TO_THEME . 'web/views/' . (
                !empty($page_data['template_filename']) 
                    ? $page_data['template_filename'] 
                    : 'default.html'
            );

            echo Run::render_template_with_content(
                PATH_TO_THEME . $layout,
                [
                    'page_data' => $page_data,
                    'template' => $template
                ]
            );

        }

    }


    // For pages which show variable content with the possibility to click on each for more
    // i.e pages like Updates, Blog, Events, etc.
    public function show_page_with_variable_content($page_data) {
        
        if ($page_data != null) {

            $layout = isset($page_data['layout_filename'])
                ? (
                    !empty($page_data['layout_filename'])
                        ? $page_data['layout_filename']
                        : 'default.php'
                )
                : 'default.php';
            
            // var_dump($page_data);
            // Check for and capture the #Feature from the page_content column of page_data array and create a new Object of it.
            $feature_array = Run::check_for_feature($page_data['content']);

            if (isset($feature_array['feature'])) {

                if (isset($feature_array['paginated'])) $paginated = $feature_array['paginated'];
                if (isset($feature_array['categorized'])) $categorized = $feature_array['categorized'];
                
                $feature_class = ucfirst($feature_array['feature']);


                // Create an instance of the feature at play.
                $object = new $feature_class;


                // Fetch all of features in the feature's DB - Table
                $all_features = $features = $object->fetch_all_features();
                     
                // and if applicable, all feature Categories.
                if (isset($object->feature_category_table)) $feature_categories = $object->fetch_all_feature_categories();
                    else $feature_categories = null;


                // Create a variable and rules for paginating features
                $results_per_page = 15;
                $current_page = (Route::is_paginated() != null) ? Route::is_paginated() : 1;
                $results_limit = (($current_page - 1) * $results_per_page) . ',' . $results_per_page;


                if (Route::is_feature_page() != false) {

                    $feature_link = Route::is_feature_page()[1];
                    
                    $feature_data = $object->fetch_data_for_this_feature($feature_link)[0];
                    $template = Run::get_template_file($page_data['template'], $object->template_preview);
                    
                } else {
                    
                    // If Catetgory is selected
                    if (isset($feature_array['categorized']) || Route::is_category_page()) {
                        
                        if (Route::is_category_page()) {

                            $category = Route::is_category_page();

                            $category_data = $object->fetch_data_for_this_category($category)[0];
                            $all_features = $object->fetch_features_by_category($category);
                            $features = $object->fetch_features_by_category($category, ['limit' => $results_limit]);
                            $template = Run::get_template_file($page_data['template'], $object->template_preview);

                        } else {
                            
                            $all_features = $object->fetch_all_feature_categories();
                            $features = $object->fetch_all_feature_categories(['limit' => $results_limit]);
                            $template = Run::get_template_file($page_data['template'], 'default-feature-category-preview.html');
                            
                        }

                    } else {

                        $features = $object->fetch_all_features(['limit' => $results_limit]);
                        $template = Run::get_template_file($page_data['template'], $object->template_preview);

                    }

                }


                // Generate Pagination
                if (!Route::is_feature_page()) {

                    $number_of_pages = ceil(count($all_features) / $results_per_page);
                    if ($number_of_pages > 1)
                        $paginate = ['number_of_pages' => $number_of_pages, 
                            'page' => CURRENT_PAGE, 
                            'current_page' => $current_page
                        ];
                    else 
                        $paginate = null;

                }
                
                echo Run::render_template_with_content(
                    PATH_TO_THEME . $layout,
                    [
                        'page_data' => (isset($page_data) ? $page_data : null),
                        'categories' => (isset($categorized) ? $feature_categories : null), 
                        'features' => (isset($features) ? $features : null),
                        'feature_data' => (isset($feature_data) ? $feature_data : null),
                        'category_data' => (isset($category_data) ? $category_data : null),
                        'template' => (isset($template) ? $template : null),
                        'paginate' => (isset($paginate) ? $paginate : null),
                        'back' => CURRENT_PAGE
                    ]
                );
            }
        
        }

    }


    public function do_footer() {

        echo Run::render_template_with_content(PATH_TO_THEME . '/web/views/footer.html');
        echo Run::render_template_with_content(PATH_TO_THEME . '/web/views/foot.html');
    
    }

    
    function extract_relevant_meta($array) {

        $meta_data = array();

        foreach ($array as $item => $value) {

            if ($item == 'link') $meta_data[$item] = $value;
            if ($item == 'image') $meta_data[$item] = $value;
            if ($item == 'title') $meta_data[$item] = $value;
            if ($item == 'description') $meta_data[$item] = $value;
            if ($item == 'content') $meta_data[$item] = $value;

        }

        return $meta_data;

    }


    public function fetch_page_data($current_page) {

        $sql_params['table_name'] = $this->feature_table;
        $sql_params['columns'] = $this->select_columns;
        $sql_params['join'] = [
            $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.page_id',
            'theme_layouts' => 'pages.layout=theme_layouts.id',
            'theme_templates' => 'pages.template=theme_templates.id',
        ];
        $sql_params['condition'] = $this->feature_table . '.link="' . $current_page . '" AND ' . $this->feature_content_table . '.lang_id=' . LANG_ID;

        $page_data = parent::select_data($sql_params);

        if (!empty($page_data)) {
            
            return $current_page_data = $page_data[0];

        } else {

            return $page_data_404 = $this->return_404();

        }

    }


    static function return_404() {
        
        $page_data_404 = [
            '404' => true,
            'title' => 'Uh Oh!',
            'image' => '404.svg',
            'description' => 'Page Not Found',
            'content' => '<p><strong>Well This is Embarrassing!</strong></p> <p>We\'re sorry, This sort of thing hardly happens but the <strong><u>' . PATH_INFO . '</u></strong> page could not be found.</p><p>You can head back to the Homepage by <a href="">clicking here</a>.</p>',
            'template_filename' => '404.html'
        ];

        return $page_data_404;

    }

    
    // Instantiate an object from the current page's feature and get its data
    function get_feature_data($page_data) {

        // Then it is a variable Page... Fetch it's data for meta tags
        if ($page_data['controller'] == 'variable_data') $feature_array = Run::check_for_feature($page_data['content']);

        if ($feature_array != false) {

            $feature = ucfirst($feature_array['feature']);

            $variable_data = $this->check_url_for_variable_data($this->path_info_array, $feature);

            // Initialize the feature class here to get information to use for the meta of that page.
            $object = new $feature;

            if (isset($variable_data['category'])) {
                
                $feature_data_array = $object->fetch_data_for_this_category($variable_data['category']);
                if (!isset($feature_data_array['error'])) $feature_data = $feature_data_array[0];

            } elseif (isset($variable_data['feature'])) {
                
                $feature_data_array = $object->fetch_data_for_this_feature($variable_data['feature']);   
                if (!isset($feature_data_array['error'])) $feature_data = $feature_data_array[0];

            } else $feature_data = false;

        } else $feature_data = false;

        return $feature_data;

    }


    function get_page_feature() {

        if ($this->page_data['controller'] == 'variable_data') {

            $feature_array = Run::check_for_feature($this->page_data['content']);
        
            if (!empty($feature_array)) return $feature = $feature_array['feature'];
                else return null;

        }

    }

    
    function check_url_for_variable_data($path) {

        $variable_data = array();
        
        if ($path > 2 || !empty($_GET)) {

            // Check if a category is being requested by checking for a /c/ in the pathinfo or return null
            if (!is_null(Route::check_for_variable_url_param('c', $path))) 
                $variable_data['category'] = Route::check_for_variable_url_param('c', $path);


            // Check if pagination is what is being requested by checking for a /p/ in the pathinfo or return null
            if (!is_null(Route::check_for_variable_url_param('p', $path))) 
                $variable_data['pagination'] = Route::check_for_variable_url_param('p', $path);


            // Check if a feature is being directly requested through it's link or id
            $feature = $this->get_page_feature();
            if (!is_null($feature)) {
                
                // Check if a feature is what is being requested by checking for a corresponding $_GET (or what comes after the page in the pathinfo) or return null
                $check_for_GET = Route::check_for_variable_url_param(strtolower($feature), $path);

                if ($check_for_GET != null) 
                    $variable_data['feature'] = $check_for_GET;
                elseif (isset($path[2]) && $path[2] != 'c' && $path[2] != 'p' && $path[2] != '') 
                    $variable_data['feature'] = $path[2];
            
            }

        }

        return $variable_data;

    }

}