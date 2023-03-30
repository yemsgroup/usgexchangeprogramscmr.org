<?php

class Menu extends Feature {

    public function __construct() 
    {
        
        parent::__construct();

        $this->feature = 'nav_link';
        $this->feature_category = 'navs';
        
        $this->join_column = 'nav_id';

        $this->feature_category_table = 'navs';
        $this->feature_table = 'nav_links';
        $this->feature_content_table = 'nav_link_content';


        // Feature Category Columns to be included in RD Statements
        $this->select_category_columns = $this->feature_category_table . '.id AS id,'
            . $this->feature_category_table . '.title AS title,'
            . $this->feature_category_table . '.description AS description'
        ;

        // Feature Category Columns to be included in CU statements
        $this->feature_category_table_columns = [
            $this->feature_category_table . '.title' => 'title',
            $this->feature_category_table . '.description' => 'description'
        ];


        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.nav_id AS nav_id,'
            . $this->feature_table . '.position AS position,'
            . $this->feature_table . '.parent AS parent,'
            . $this->feature_table . '.link_type AS link_type,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_table . '.icon AS icon,'
            . $this->feature_table . '.is_active AS is_active,'
            . $this->feature_content_table . '.lang_id AS lang_id,'
            . $this->feature_content_table . '.title AS title,'
            . $this->feature_content_table . '.description AS description'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.nav_id' => 'category_id',
            $this->feature_table . '.position' => 'position',
            $this->feature_table . '.parent' => 'parent',
            $this->feature_table . '.link_type' => 'link_type',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.image' => 'image',
            $this->feature_table . '.icon' => 'icon',
            $this->feature_table . '.is_active' => 'is_active'
        ];

        $this->feature_content_table_columns = [
            $this->feature_content_table . '.title' => 'title',
            $this->feature_content_table . '.description' => 'description'
        ];

    }


    public function select_navigation() 
    {
        
        // Write Method to select which Nav to display.

    }
    

    public function get_navigation() 
    {
        
        $sql_params['table_name'] = $this->feature_table;
        $sql_params['join'] = [
            $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.nav_link_id'
        ];
        $sql_params['condition'] = $this->feature_table . '.parent IS NULL AND ' . $this->feature_table . '.is_active=1';
        $sql_params['sort'] = 'position ASC';

        $nav_links = parent::select_data($sql_params);
        
        return $nav_links;

    }

}