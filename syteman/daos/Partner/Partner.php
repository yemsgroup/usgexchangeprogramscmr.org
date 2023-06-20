<?php 

class Partner extends Feature
{

    function __construct()
    {

        parent::__construct();

        // Define a name for the feature and it's category
        $this->feature = 'partner';

        // For front end... the page on which the features will be displayed
        $this->feature_page = 'partners';

        // Define the names of the tables as on db
        $this->feature_table = 'partners';


        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.is_active AS is_active,'
            . $this->feature_table . '.priority AS priority,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_table . '.url AS url,'
            . $this->feature_table . '.title AS title,'
            . $this->feature_table . '.description AS description'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.is_active' => 'is_active',
            $this->feature_table . '.priority' => 'priority',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.image' => 'image',
            $this->feature_table . '.url' => 'url',
            $this->feature_table . '.title' => 'title',
            $this->feature_table . '.description' => 'description'
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