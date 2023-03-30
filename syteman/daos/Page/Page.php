<?php 

class Page extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'page';
        $this->feature_category = 'page_category';
        $this->feature_category_table = 'page_categories';
        $this->feature_category_content_table = 'page_category_content';
        $this->feature_table = 'pages';
        $this->feature_content_table = 'page_content';

        // Feature Category Columns to be included in RD Statements
        $this->select_category_columns = $this->feature_category_table . '.id AS id,'
            . $this->feature_category_table . '.link AS link,'
            . $this->feature_category_table . '.image AS image,'
            . $this->feature_category_content_table . '.lang_id AS lang_id,'
            . $this->feature_category_content_table . '.title AS title,'
            . $this->feature_category_content_table . '.description AS description,'
            . $this->feature_category_content_table . '.content AS content'
        ;

        // Feature Category Columns to be included in CU statements
        $this->feature_category_table_columns = [
            $this->feature_category_table . '.link' => 'link',
            $this->feature_category_table . '.image' => 'image'
        ];

        $this->feature_category_content_table_columns = [
            $this->feature_category_content_table . '.title' => 'title',
            $this->feature_category_content_table . '.description' => 'description',
            $this->feature_category_content_table . '.content' => 'content',
            $this->feature_category_content_table . '.image_caption' => 'image_caption'
        ];


        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.parent AS parent,'
            . $this->feature_table . '.is_active AS is_active,'
            // . $this->feature_table . '.layout AS layout,'
            // . $this->feature_table . '.template AS template,'
            . $this->feature_table . '.controller AS controller,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_content_table . '.lang_id AS lang_id,'
            . $this->feature_content_table . '.nav_title AS nav_title,'
            . $this->feature_content_table . '.title AS title,'
            . $this->feature_content_table . '.description AS description,'
            . $this->feature_content_table . '.content AS content,'
            . $this->feature_content_table . '.image_caption AS image_caption,'
            . $this->feature_content_table . '.last_update AS last_update,'
            . $this->feature_content_table . '.last_update_by AS last_update_by,'
            . $this->feature_category_content_table . '.title AS category_title,'
            . 'theme_templates.id AS template_id,'
            . 'theme_templates.title AS template,'
            . 'theme_templates.filename AS template_filename,'
            . 'theme_layouts.id AS layout_id,'
            . 'theme_layouts.title AS layout,'
            . 'theme_layouts.filename AS layout_filename'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.parent' => 'parent',
            $this->feature_table . '.is_active' => 'is_active',
            $this->feature_table . '.layout' => 'layout',
            $this->feature_table . '.template' => 'template',
            $this->feature_table . '.controller' => 'controller',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.layout' => 'layout_id',
            $this->feature_table . '.template' => 'template_id',
            $this->feature_table . '.image' => 'image'
        ];

        $this->feature_content_table_columns = [
            $this->feature_content_table . '.lang_id' => 'lang_id',
            $this->feature_content_table . '.nav_title' => 'nav_title',
            $this->feature_content_table . '.title' => 'title',
            $this->feature_content_table . '.description' => 'description',
            $this->feature_content_table . '.content' => 'content',
            $this->feature_content_table . '.last_update' => 'last_update',
            $this->feature_content_table . '.last_update_by' => 'admin_id',
            $this->feature_content_table . '.image_caption' => 'image_caption'
        ];

    }


    public function get_page_data($page)
    {

        $params = [
            'table_name' => $this->feature_table,
            'columns' => $this->select_columns,
            'join' => [
                $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.' . $this->feature . '_id',
                'theme_layouts' => $this->feature_table . '.layout=' . 'theme_layouts.id',
                'theme_templates' => $this->feature_table . '.template=' . 'theme_templates.id'
            ]
        ];

        if (isset($this->feature_category_content_table)) 
            $params['join'][$this->feature_category_content_table] = $this->feature_table . '.category_id=' . $this->feature_category_content_table . '.category_id';
        
        if (is_numeric($page)) $params['condition'] = $this->feature_table . '.id="' . $page . '"';
            else $params['condition'] = $this->feature_table . '.link="' . $page . '"';

        return parent::fetch_data_for_this_feature($page, $params);

    }


    public function fetch_data_for_this_feature($link, $params=null) 
    {

        $params = [
            'table_name' => $this->feature_table,
            'columns' => $this->select_columns,
            'join' => [
                $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.' . $this->feature . '_id',
                'theme_layouts' => $this->feature_table . '.layout=' . 'theme_layouts.id',
                'theme_templates' => $this->feature_table . '.template=' . 'theme_templates.id'
            ]
        ];

        if (isset($this->feature_category_content_table)) 
            $params['join'][$this->feature_category_content_table] = $this->feature_table . '.category_id=' . $this->feature_category_content_table . '.category_id';
        
        if (is_numeric($link)) $params['condition'] = $this->feature_table . '.id="' . $link . '"';
            else $params['condition'] = $this->feature_table . '.link="' . $link . '"';

        return parent::fetch_data_for_this_feature($link, $params);

    }

    
    public function fetch_all_features($params=null) {

        $params = [
            'table_name' => $this->feature_table,
            'columns' => $this->select_columns,
            'join' => [
                $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.' . $this->feature . '_id',
                'theme_layouts' => $this->feature_table . '.layout=' . 'theme_layouts.id',
                'theme_templates' => $this->feature_table . '.template=' . 'theme_templates.id'
            ]
        ];

        return parent::fetch_all_features($params);

    }


    public function fetch_features_by_category($id, $params=null) 
    {

        $params = [
            'join' => [
                'theme_layouts' => $this->feature_table . '.layout=' . 'theme_layouts.id',
                'theme_templates' => $this->feature_table . '.template=' . 'theme_templates.id'
            ]
        ];

        return parent::fetch_features_by_category($id, $params);

    }

    
    function check_if_page_exists($page_link) {
        
        $sql_params['table_name'] = $this->feature_table;
        $sql_params['condition'] = 'page_name="' . $page_link . '"';

        $page = parent::select_data($this->feature_table, $condition);

        return $page;

    }

}