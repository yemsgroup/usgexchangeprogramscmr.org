<?php 

class Theme extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'theme';
        $this->feature_table = 'themes';

        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.title AS title,'
            . $this->feature_table . '.description AS description,'
            . $this->feature_table . '.image AS image'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.title' => 'title',
            $this->feature_table . '.description' => 'description',
            $this->feature_table . '.image' => 'image'
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