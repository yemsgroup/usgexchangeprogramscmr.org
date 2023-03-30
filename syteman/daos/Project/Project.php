<?php 

class Project extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'project';

        // For front end... the page on which the features will be displayed
        $this->feature_page = 'activities';
        $this->template_preview = 'project-preview.html';

        $this->feature_table = 'projects';
        $this->feature_content_table = 'project_content';
        
        $this->join_column = 'project_id';


        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.cycle AS cycle,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_table . '.video AS video,'
            . $this->feature_table . '.location AS location,'
            . $this->feature_table . '.date_from AS date_from,'
            . $this->feature_table . '.date_to AS date_to,'
            . $this->feature_table . '.impact AS impact,'
            . $this->feature_content_table . '.lang_id AS lang_id,'
            . $this->feature_content_table . '.title AS title,'
            . $this->feature_content_table . '.description AS description,'
            . $this->feature_content_table . '.content AS content,'
            . $this->feature_content_table . '.image_caption AS image_caption'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.project_id' => 'project_id',
            $this->feature_table . '.cycle' => 'cycle',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.image' => 'image',
            $this->feature_table . '.video' => 'video',
            $this->feature_table . '.location' => 'location',
            $this->feature_table . '.date_from' => 'date_from',
            $this->feature_table . '.date_to' => 'date_to',
            $this->feature_table . '.impact' => 'impact'
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