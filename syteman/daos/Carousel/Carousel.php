<?php 

class Carousel extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'carousel';
        $this->feature_category = 'carousel_category';

        $this->feature_category_table = 'carousel_categories';
        $this->feature_category_content_table = 'carousel_category_content';
        $this->feature_table = 'carousel';
        $this->feature_content_table = 'carousel_content';

        // Feature Category Columns to be included in RD Statements
        $this->select_category_columns = $this->feature_category_table . '.id AS id,'
            . $this->feature_category_table . '.link AS link,'
            . $this->feature_category_table . '.image AS image,'
            . $this->feature_category_table . '.is_active AS is_active,'
            . $this->feature_category_content_table . '.lang_id AS lang_id,'
            . $this->feature_category_content_table . '.title AS title,'
            . $this->feature_category_content_table . '.description AS description,'
            . $this->feature_category_content_table . '.image_caption AS image_caption'
        ;

        // Feature Category Columns to be included in CU statements
        $this->feature_category_table_columns = [
            $this->feature_category_table . '.link' => 'link',
            $this->feature_category_table . '.image' => 'image',
            $this->feature_category_table . '.is_active' => 'is_active'
        ];

        $this->feature_category_content_table_columns = [
            $this->feature_category_content_table . '.title' => 'title',
            $this->feature_category_content_table . '.description' => 'description',
            $this->feature_category_content_table . '.image_caption' => 'image_caption'
        ];


        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.category_id AS category_id,'
            . $this->feature_table . '.is_active AS is_active,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_content_table . '.lang_id AS lang_id,'
            . $this->feature_content_table . '.title AS title,'
            . $this->feature_content_table . '.content AS content,'
            . $this->feature_content_table . '.image_caption AS image_caption'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.category_id' => 'category_id',
            $this->feature_table . '.name' => 'name',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.image' => 'image'
        ];

        $this->feature_content_table_columns = [
            $this->feature_content_table . '.title' => 'title',
            $this->feature_content_table . '.description' => 'description',
            $this->feature_content_table . '.content' => 'content',
            $this->feature_content_table . '.image_caption' => 'image_caption'
        ];

    }

    
    public function add_feature_data($sql_params=null)
    {
        
        return parent::add_feature_data();

    }

    
    public function update_feature_data($sql_params=null)
    {

        return parent::update_feature_data();

    }

    
    public function delete_feature_data($sql_params=null)
    {

        return parent::delete_feature_data();

    }

}