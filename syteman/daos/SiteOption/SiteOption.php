<?php 

class SiteOption extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'option';
        $this->feature_table = 'site_options';
        $this->feature_content_table = 'site_options_content';

        // Columns for RD
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.name AS name,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_content_table . '.lang_id AS lang_id,'
            . $this->feature_content_table . '.title AS title,'
            . $this->feature_content_table . '.description AS description,'
            . $this->feature_content_table . '.content AS content';

        // Define columns for CU
        $this->feature_table_columns = [
            $this->feature_table . '.name' => 'name',
            $this->feature_table . '.image' => 'image'
        ];

        $this->feature_content_table_columns = [
            $this->feature_content_table . '.lang_id' => 'lang_id',
            $this->feature_content_table . '.title' => 'title',
            $this->feature_content_table . '.description' => 'description',
            $this->feature_content_table . '.content' => 'content'
        ];

    }
    

    // Fetch Site_options data and create constants from them to be used sitewide. 
    function create_site_information_constants() 
    {

        $site_options = parent::fetch_all_features();

        // Create Constants for General Site Information
        foreach ($site_options as $option => $values) {
            
            if ($values['image'] != null) defined($values['name']) or define($values['name'], $values['image']);
                else defined($values['name']) or define($values['name'], $values['content']);
            
        }
        
    }

}