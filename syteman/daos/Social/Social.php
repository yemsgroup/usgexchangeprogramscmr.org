<?php 

class Social extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'social';

        // For front end... the page on which the features will be displayed
        $this->feature_page = 'test_features';
        $this->template_preview = 'social-links-preview.html';

        // Feature related table(s)
        $this->feature_table = 'social_networks';

        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.is_active AS is_active,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.title AS title,'
            . $this->feature_table . '.url AS url,'
            . $this->feature_table . '.icon AS icon,'
            . $this->feature_table . '.image AS image'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.is_active' => 'is_active',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.title' => 'title',
            $this->feature_table . '.url' => 'url',
            $this->feature_table . '.icon' => 'icon',
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