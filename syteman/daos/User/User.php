<?php 

class User extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'user';
        $this->feature_table = 'users';

        // Columns for RD
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.role,'
            . $this->feature_table . '.is_active,'
            . $this->feature_table . '.username,'
            . $this->feature_table . '.email,'
            . $this->feature_table . '.first_name,'
            . $this->feature_table . '.last_name,'
            . $this->feature_table . '.profile,'
            . $this->feature_table . '.image';

        // Define columns for CU
        $this->feature_table_columns = [
            $this->feature_table . '.role' => 'role',
            $this->feature_table . '.is_active' => 'is_active',
            $this->feature_table . '.username' => 'username',
            $this->feature_table . '.email' => 'email',
            $this->feature_table . '.hashed_password' => 'password',
            $this->feature_table . '.first_name' => 'first_name',
            $this->feature_table . '.last_name' => 'last_name',
            $this->feature_table . '.profile' => 'profile',
            $this->feature_table . '.image' => 'image'
        ];

        // $this->preview_template = 'user-preview.html';
        // $this->detail_template = 'user-detail.html';
        // $this->edit_template = 'user-edit.html';

    }
    

    // Fetch Site_options data and create constants from them to be used sitewide. 
    function create_site_information_constants() 
    {
        
        $site_options = parent::fetch_all_features();

        // Create Constants for General Site Information
        foreach ($site_options as $option => $values) {
            
            if (isset($values['name'])) defined($values['name']) or define($values['name'], $values['content']);
            
        }
        
    }

}