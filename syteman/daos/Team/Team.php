<?php 

class Team extends Feature
{

    function __construct()
    {

        parent::__construct();

        // Define a name for the feature and it's category
        $this->feature = 'team';
        $this->feature_category = 'team_category';

        // For front end... the page on which the features will be displayed
        $this->feature_page = 'team';
        // $this->template_preview = 'default-feature-preview.html';

        // Define the names of the tables as on db
        $this->feature_category_table = 'team_categories';
        $this->feature_category_content_table = 'team_category_content';

        $this->feature_table = 'team';
        $this->feature_content_table = 'team_content';
        
        // Define the columns to join the feature content table to the feature table
        // $this->join_column = '';
        // ...and (if category_id was not used), the column to join the feature to the corresponding category content table, in the case of a categorized feature
        // $this->join_column_category = '';

        // Feature Category Columns to be included in RD Statements
        $this->select_category_columns = $this->feature_category_table . '.id AS id,'
            . $this->feature_category_table . '.is_active AS is_active,'
            . $this->feature_category_table . '.link AS link,'
            . $this->feature_category_table . '.image AS image,'
            . $this->feature_category_content_table . '.lang_id AS lang_id,'
            . $this->feature_category_content_table . '.title AS title,'
            . $this->feature_category_content_table . '.description AS description,'
            . $this->feature_category_content_table . '.image_caption AS image_caption'
        ;

        // Feature Category Columns to be included in CU statements
        $this->feature_category_table_columns = [
            $this->feature_table . '.is_active' => 'is_active',
            $this->feature_category_table . '.link' => 'link',
            $this->feature_category_table . '.image' => 'image'
        ];

        $this->feature_category_content_table_columns = [
            $this->feature_category_content_table . '.lang_id' => 'lang_id',
            $this->feature_category_content_table . '.title' => 'title',
            $this->feature_category_content_table . '.description' => 'description',
            $this->feature_category_content_table . '.image_caption' => 'image_caption'
        ];


        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.category_id AS category_id,'
            . $this->feature_table . '.is_active AS is_active,'
            . $this->feature_table . '.location_id AS location_id,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.first_name AS first_name,'
            . $this->feature_table . '.last_name AS last_name,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_table . '.from_date AS from_date,'
            . $this->feature_table . '.to_date AS to_date,'
            . $this->feature_table . '.facebook AS facebook,'
            . $this->feature_table . '.twitter AS twitter,'
            . $this->feature_table . '.youtube AS youtube,'
            . $this->feature_table . '.linkedin AS linkedin,'
            . $this->feature_table . '.email AS email,'
            . $this->feature_table . '.website AS website,'
            . $this->feature_content_table . '.position AS position,'
            . $this->feature_content_table . '.profile AS profile,'
            . $this->feature_content_table . '.image_caption AS image_caption'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.category_id' => 'category_id',
            $this->feature_table . '.is_active' => 'is_active',
            $this->feature_table . '.location_id' => 'location_id',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.first_name' => 'first_name',
            $this->feature_table . '.last_name' => 'last_name',
            $this->feature_table . '.image' => 'image',
            $this->feature_table . '.from_date' => 'from_date',
            $this->feature_table . '.to_date' => 'to_date',
            $this->feature_table . '.facebook' => 'facebook',
            $this->feature_table . '.twitter' => 'twitter',
            $this->feature_table . '.youtube' => 'youtube',
            $this->feature_table . '.linkedin' => 'linkedin',
            $this->feature_table . '.email' => 'email',
            $this->feature_table . '.website' => 'website'
        ];

        $this->feature_content_table_columns = [
            $this->feature_content_table . '.position' => 'position',
            $this->feature_content_table . '.profile' => 'profile',
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