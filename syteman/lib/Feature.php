<?php

class Feature extends Db {

    public function __construct()
    {
        
        parent::__construct();

        $this->standard_column_names = ['id', 'category_id', 'status', 'link', 'image', 'lang_id', 'name', 'title', 'caption', 'description', 'content', 'image_caption'];

    }


    public function link_can_be_generated() {

        if ((isset($_POST['title']) && $_POST['title'] != '') || (isset($_POST['name']) && $_POST['name'] != '')) return true;
            else return false;

    }


    public function resolve_columns_to_insert_into($columns)
    {

        $columns_to_add = array();

        foreach ($columns as $column => $post) {

            if (isset($_POST[$post])) {

                if (!isset($_POST['update-feature'])) {
                    
                    if ($_POST[$post] != '') $columns_to_add[$column] = $post;
                
                } else $columns_to_add[$column] = $post;

            }
            
            if (!isset($_POST['update-feature']))
                if ($post == 'link' && $this->link_can_be_generated()) $columns_to_add[$column] = 'link';

            if (isset($_FILES[$post]) && File::check_if_file_is_submitted()) $columns_to_add[$column] = $post;                

        }

        return $columns_to_add;

    }


    public function resolve_values_to_insert($columns, &$feedback=null)
    {

        $values_to_insert = array();

        foreach ($columns as $column => $post_key) {

            if (isset($_POST[$post_key])) {

                if (!isset($_POST['update-feature'])) {

                    if ($_POST[$post_key] != '') $values_to_insert[$post_key] = $_POST[$post_key];
                
                } else $values_to_insert[$post_key] = $_POST[$post_key];

                if ($post_key == 'name') $values_to_insert[$post_key] = strtoupper(Run::create_link_from_string($_POST[$post_key], '_'));
            
            }

            if ($post_key == 'link') $values_to_insert['link'] = FormProcess::create_link_from_form_input($this->feature);

        }

        if (!empty($_FILES)) {

            // Check if a File has been submitted
            if (File::check_if_file_is_submitted()) {

                foreach ($columns as $column => $post_key) {
                
                    if (isset($_FILES[$post_key])) {

                        // Validate and create a name for (each) file for db
                        if (File::validate_file_type($_FILES[$post_key], 'image') != false) {

                            $filename[$post_key] = File::name_file(File::validate_file_type($_FILES[$post_key], 'image'), $this->feature . '-' . (isset($values_to_insert['link']) ? $values_to_insert['link'] : '') . '-' . $post_key);
                        
                        } else {

                            $filename[$post_key] = '';
                            $feedback[] = 'File Could not be Uploaded: [Accepted file types, include JPG, PNG, SVG or GIF]';
                            
                        }

                    }  

                }
                        
            } else $feedback[] = 'No file was attached';

            if (isset($filename))
                foreach ($filename as $key => $file_to_upload) $values_to_insert[$key] = $file_to_upload;
            
        }

        return $values_to_insert;

    }


    public function resolve_feature_table_params($params=null)
    {
        
        if ($params == null) {

            // Resolve columns for DB Query 
            $columns = $this->resolve_columns_to_insert_into($this->feature_table_columns);
            
            // Resolve submitted Values for each column
            $values = $this->resolve_values_to_insert($columns);

            $params = [
                'table_name' => $this->feature_table,
                'columns' => $columns,
                'values' => $values
            ];

            if (count($params['columns']) == count($params['values'])) {

                $sql_params = $params;

            } else {
                
                $feedback[] = 'Failed to insert Data into Default Feature Table... Columns/Value Count did not Match';
                $sql_params = false; 
            
            }

        } else {

            $sql_params = false; 
            $feedback[] = 'No params were passed';

        }
        return $sql_params; 

    }


    public function resolve_feature_content_table_params($link=null, $params=null)
    {
        
        if ($params == null) {

            // Resolve columns for SQL Query
            $columns = $this->resolve_columns_to_insert_into($this->feature_content_table_columns);
            if ($link != null) $columns[$this->feature_content_table . '.' . $this->feature . '_id'] = $this->feature . '_id';
            $columns[$this->feature_content_table . '.lang_id'] = 'lang_id';

            // Resolve POST values for columns
            $content_values = $this->resolve_values_to_insert($columns);
            if ($link != null) $content_values[$this->feature . '_id'] = $link;
            $content_values['lang_id'] = (!isset($_POST['lang_id']) ? LANG_ID : $_POST['lang_id']);

            $params = [
                'table_name' => $this->feature_content_table,
                'columns' => $columns,
                'values' => $content_values
            ];

            if (count($params['columns']) == count($params['values'])) {

                $sql_params = $params;

            } else {
                
                $feedback[] = 'Failed to insert Data into Default Feature Table... Columns/Value Count did not Match';
                $sql_params = false; 
            
            }

        } else {

            $sql_params = false; 
            $feedback[] = 'No params were passed';

        }

        return $sql_params;

    }


    public function resolve_feature_category_table_params($params=null)
    {
        
        if ($params == null) {

            // Resolve columns for DB Query 
            $columns = $this->resolve_columns_to_insert_into($this->feature_category_table_columns);
            
            // Resolve submitted Values for each column
            $values = $this->resolve_values_to_insert($columns);

            $params = [
                'table_name' => $this->feature_category_table,
                'columns' => $columns,
                'values' => $values
            ];

            if (count($params['columns']) == count($params['values'])) {

                $sql_params = $params;

            } else {
                
                $feedback[] = 'Failed to insert Data into Default Feature Table... Columns/Value Count did not Match';
                $sql_params = false; 
            
            }

        } else {

            $sql_params = false; 
            $feedback[] = 'No params were passed';

        }

        return $sql_params; 

    }


    public function resolve_feature_category_content_table_params($link=null, $params=null)
    {
        
        if ($params == null) {

            // Resolve columns for SQL Query
            $columns = $this->resolve_columns_to_insert_into($this->feature_category_content_table_columns);
            if ($link != null) $columns[$this->feature_category_content_table . '.' . (isset($this->join_column) ? $this->join_column : 'category_id')] = $this->feature . '_id';
            $columns[$this->feature_category_content_table . '.lang_id'] = 'lang_id';

            // Resolve POST values for columns
            $content_values = $this->resolve_values_to_insert($columns);
            if ($link != null) $content_values[$this->feature . '_id'] = $link;
            $content_values['lang_id'] = LANG_ID;

            $params = [
                'table_name' => $this->feature_category_content_table,
                'columns' => $columns,
                'values' => $content_values
            ];

            if (count($params['columns']) == count($params['values'])) {

                $sql_params = $params;

            } else {
                
                $feedback[] = 'Failed to insert Data into Default Feature Table... Columns/Value Count did not Match';
                $sql_params = false; 
            
            }

        } else {

            $sql_params = false; 
            $feedback[] = 'No params were passed';

        }

        // var_dump($sql_params);
        return $sql_params;

    }


    public function check_for_set_variable($needle, $haystack, $key=null) 
    {
        
        if (isset($haystack[$needle])) $result = $haystack[$needle];
            elseif (isset($key) && isset($haystack[$key . '_' . $needle])) $result = $haystack[$key . '_' . $needle];
                else $result = '';
        
        return $result;

    }


    // Prepend the Feature's Name (Database prepend) to generic column names... 
    // e.g. prepend "poem" to the generic "_title" to get "poem_title" and assign it back to the generic "title"
    public function assign_feature_values($feature, $key) 
    {

        if (isset($this->select_columns)) {

            $string = $this->select_columns;
            $array = explode(',', $string);
            $use = array();

            foreach ($array as $str) {

                if (strpos($str, 'AS') != false) $newstr = substr($str, (strpos($str, 'AS') + 3), strlen($str));
                    else $newstr = substr($str, (strpos($str, '.') + 1), strlen($str));

                $use[] = $newstr;

            }

        } else {
            $use = $this->standard_column_names;
        }

        foreach ($use as $column) {
            $variable[$column] = $this->check_for_set_variable($column, $feature, $key);
        }

        // var_dump($variable);
        return $variable;

    }


    public function assign_category_values($feature, $key_category) 
    {

        if (isset($this->select_category_columns)) {

            $string = $this->select_category_columns;
            $array = explode(',', $string);
            $use = array();

            foreach ($array as $str) {

                if (strpos($str, 'AS') != false) $newstr = substr($str, (strpos($str, 'AS') + 3), strlen($str));
                    else $newstr = substr($str, (strpos($str, '.') + 1), strlen($str));

                $use[] = $newstr;

            }

        } else {
            $use = $this->standard_column_names;
        }

        foreach ($use as $column) {
            $variable[$column] = $this->check_for_set_variable($column, $feature, $key_category);
        }

        return $variable;

    }


// CREATE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function add_feature_data($sql_params = null) 
    {

        if (isset($_POST['add-feature'])) {
            
            if ($sql_params != null) {
                
                // Object has sent it's params

            } else {

                // Use Default Params

                // Starting with static content for the feature table.
                // Identify submitted (POST) content and match to the defined feature DB columns

                // Log level of process.
                $feedback[] = 'attempting to add content for default Feature table.';

                $sql_params = $this->resolve_feature_table_params();

                if ($sql_params != false) {
                    
                    if (!empty($sql_params['columns'])) {

                        $transaction = $this->start_transaction();
                        $feedback[] = $transaction['message'];
                        
                        $insert_feedback = $this->insert_data_into_table($sql_params);

                        if (isset($_FILES) && File::check_if_file_is_submitted()) {

                            foreach ($sql_params['values'] as $check => $value)
                                if (isset($_FILES[$check])) $files_to_upload[$check] = $sql_params['values'][$check];

                        }

                        if (isset($sql_params['values']['image'])) $image = $sql_params['values']['image'];
                            
                        if ($insert_feedback['status'] == true) {
                            
                            // Log level of process.
                            $feedback[] = 'Successfully Added data for the feature table';

                            // Get the ID the feature table ID and use in feature content table
                            $inserted_id = $insert_feedback['inserted_id'];

                            // Where applicable, use the Inserted ID to add dynamic (language) content for the content table.
                            if (isset($this->feature_content_table_columns)) {

                                // Log level of process.
                                $feedback[] = 'attempting to add content for Feature [Content] table.';
                                
                                // Resolve columns for SQL Query
                                $sql_params = $this->resolve_feature_content_table_params($inserted_id);

                                if ($sql_params != false) {
                                    
                                    $insert_feedback = $this->insert_data_into_table($sql_params);

                                    if (isset($_FILES) && File::check_if_file_is_submitted()) {

                                        foreach ($sql_params['values'] as $check => $value)
                                            if (isset($_FILES[$check])) $files_to_upload[$check] = $sql_params['values'][$check];

                                    }

                                    // Log level of process
                                    if ($insert_feedback['status'] == true) {
                                        
                                        $feedback[] = 'Successfully added data for Feature [Content] Table';
                                        $transaction = $this->commit_transaction();
                                    
                                    } else {
                                        
                                        $feedback[] = 'Sorry, Feature [Content] data could not be Added, [Please Try again]<br>' . $insert_feedback['message'];
                                        $transaction = $this->roll_back_transaction();

                                    }

                                } else {
                                    
                                    $feedback[] = 'Could not resolve feature [content] table params/values';
                                    $transaction = $this->roll_back_transaction();
                                    
                                }
                                
                            } else {
                                
                                $transaction = $this->commit_transaction();

                            }

                            // If an Image was validated and included for upload
                            if (isset($files_to_upload)) {

                                $feedback[] = 'attempting to upload files';

                                foreach ($files_to_upload as $input => $name) {

                                    $upload_file = File::upload_file($_FILES[$input], $name, REL_PATH_TO_IMAGES);

                                    if ($upload_file == true) $feedback[] = 'Successfully uploaded attached Image';
                                        else $feedback[] = 'For some reason, we couldn\'t upload the file, [please try again]';

                                }

                            }

                        } else {
                            
                            $transaction = $this->roll_back_transaction();

                            $feedback[] = 'Sorry, Content could not be Added, [Please Try again]';
                            $feedback[] = $insert_feedback['message'];
                            
                        }

                        $feedback[] = $transaction['message'];

                    } else $feedback[] = 'Could not insert: No Data was submitted';

                } else $feedback[] = 'Could not resolve feature table params/values';

            }

        } else $feedback[] = 'No data was (POST) Submitted';

        return $feedback;

    }


    public function add_feature_category_data($sql_params = null) 
    {

        if (isset($_POST['add-feature-category'])) {
            
            if ($sql_params != null) {
                
                // Object has sent it's params

            } else {

                // Use Default Params

                // Starting with static content for the feature table.
                // Identify submitted (POST) content and match to the defined feature DB columns

                // Log level of process.
                $feedback[] = 'attempting to add content for default Feature Category table.';

                $sql_params = $this->resolve_feature_category_table_params();

                if ($sql_params != false) {
                    
                    if (!empty($sql_params['columns'])) {

                        $transaction = $this->start_transaction();
                        $feedback[] = $transaction['message'];
                        
                        $insert_feedback = $this->insert_data_into_table($sql_params);
                        if (isset($sql_params['values']['image'])) $image = $sql_params['values']['image'];
                            
                        if ($insert_feedback['status'] == true) {
                            
                            // Log level of process.
                            $feedback[] = 'Successfully Added data for the feature category table';

                            // Get the ID the feature table ID and use in feature content table
                            $inserted_id = $insert_feedback['inserted_id'];

                            // Where applicable, use the Inserted ID to add dynamic (language) content for the content table.
                            if (isset($this->feature_category_content_table_columns)) {

                                // Log level of process.
                                $feedback[] = 'attempting to add content for Feature Category [Content] table.';
                                
                                // Resolve columns for SQL Query
                                $sql_params = $this->resolve_feature_category_content_table_params($inserted_id);

                                // var_dump($sql_params);

                                if ($sql_params != false) {
                                    
                                    $insert_feedback = $this->insert_data_into_table($sql_params);

                                    // Log level of process
                                    if ($insert_feedback['status'] == true) {
                                        
                                        $feedback[] = 'Successfully added data for Feature [Content] Table';
                                        $transaction = $this->commit_transaction();
                                    
                                    } else {
                                        
                                        $feedback[] = 'Sorry, Feature Category [Content] data could not be Added, [Please Try again]<br>' . $insert_feedback['message'];
                                        $transaction = $this->roll_back_transaction();

                                    }

                                } else {
                                    
                                    $feedback[] = 'Could not resolve feature [content] table params/values';
                                    $transaction = $this->roll_back_transaction();
                                    
                                }
                                
                            } else {
                                
                                $transaction = $this->commit_transaction();

                            }

                            // If an Image was validated and included for upload
                            if (isset($image)) {

                                $feedback[] = 'attempting to upload image';

                                foreach ($_FILES as $file) {

                                    $upload_file = File::upload_file($file, $image, REL_PATH_TO_IMAGES);

                                    if ($upload_file == true) $feedback[] = 'Successfully uploaded attached Image';
                                        else $feedback[] = 'For some reason, we couldn\'t upload the file, [please try again]';

                                }

                            }

                        } else {
                            
                            $transaction = $this->roll_back_transaction();

                            $feedback[] = 'Sorry, Category Content could not be Added, [Please Try again]';
                            $feedback[] = $insert_feedback['message'];
                            
                        }

                        $feedback[] = $transaction['message'];

                    } else $feedback[] = 'Could not insert: No Data was submitted';

                } else $feedback[] = 'Could not resolve feature table params/values';

            }

        } else $feedback[] = 'No data was (POST) Submitted';

        return $feedback;

    }


// READ ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function fetch_data_for_features($sql_params) 
    {

        $features = parent::select_data($sql_params);

        // var_dump($features);

        return $features;

    }


    public function fetch_all_feature_categories($params=null) 
    {
        
        // if ($params == null) {
            
            $sql_params = [
                'table_name' => $this->feature_category_table,
                'columns' => $this->select_category_columns,
            ];

            if (isset($this->feature_category_content_table)) {

                $sql_params['join'] = [
                    $this->feature_category_content_table => $this->feature_category_table . '.id=' . $this->feature_category_content_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id')
                ];
            
            }

            if ($params != null)
                if (isset($params['limit'])) $sql_params['limit'] = $params['limit'];

            $feature_categories = $this->fetch_data_for_features($sql_params);

            $feature_data = array();
            foreach($feature_categories as $category) $feature_data[] = self::assign_category_values($category, $this->feature_category);

        // }

        // var_dump($feature_data);

        return $feature_data;

    }


    public function fetch_all_features($params=null) 
    {
        
        $sql_params = [
            'table_name' => $this->feature_table,
            'columns' => $this->select_columns,
        ];
        
        if (isset($this->feature_content_table)) {

            $sql_params['join'] = [
                $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.' . $this->feature . '_id'
            ];
            
        }

        if ($params != null) {

            if (isset($params['join'])) 
                $sql_params['join'] = $params['join'];

            foreach ($params as $set => $condition) $sql_params[$set] = $condition;
            
            if (isset($params['limit'])) $sql_params['limit'] = $params['limit'];

        }

        if (isset($this->feature_category_content_table)) 
            $sql_params['join'][$this->feature_category_content_table] = $this->feature_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id') . '=' . $this->feature_category_content_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id') . '';

        // var_dump($sql_params);

        $features = $this->fetch_data_for_features($sql_params);

        $feature_data = array();
        foreach($features as $feature) $feature_data[] = self::assign_feature_values($feature, $this->feature);

        return $feature_data;

    }


    public function fetch_data_for_this_feature($link, $params=null) 
    {
        
        if ($params == null) {

            $sql_params = [
                'table_name' => $this->feature_table,
                'columns' => $this->select_columns
            ];

            if (isset($this->feature_content_table)) {

                $sql_params['join'] = [
                    $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.' . $this->feature . '_id'
                ];
                
            }

            if (isset($this->feature_category_content_table)) 
                $sql_params['join'][$this->feature_category_content_table] = $this->feature_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id') . '=' . $this->feature_category_content_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id');
            
            if (is_numeric($link)) $sql_params['condition'] = $this->feature_table . '.id="' . $link . '"';
                else $sql_params['condition'] = $this->feature_table . '.link="' . $link . '"';

        } else $sql_params = $params;

        $features = $this->fetch_data_for_features($sql_params);

        // var_dump($features);

        if (empty($features)) $feature_data = ['error' => $link . ' was not found'];
            else foreach($features as $feature) $feature_data[] = self::assign_feature_values($feature, $this->feature);

        return $feature_data;

    }


    public function fetch_data_for_this_category($link, $params=null) 
    {

        if ($params == null) {

            $sql_params = [
                'table_name' => $this->feature_category_table,
                'columns' => $this->select_category_columns
            ];

            if (isset($this->feature_category_content_table)) {

                $sql_params['join'] = [
                    $this->feature_category_content_table => $this->feature_category_table . '.id=' . $this->feature_category_content_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id')
                ];
            
            }
            
            if (is_numeric($link)) $sql_params['condition'] = $this->feature_category_table . '.id="' . $link . '"';
                else $sql_params['condition'] = $this->feature_category_table . '.link="' . $link . '"';
                
        } else $sql_params = $params;

        $features = $this->fetch_data_for_features($sql_params);

        if (empty($features)) $feature_data = ['error' => 'No Data was found for this category: ' . $link];
            else foreach($features as $feature) $feature_data[] = self::assign_category_values($feature, $this->feature_category);

        // var_dump($sql_params);
        return $feature_data;

    }


    public function fetch_features_by_category($id, $params=null) 
    {

        $sql_params = [
            'table_name' => $this->feature_table,
            'columns' => $this->select_columns,
            'join' => [
                // $this->feature_content_table => $this->feature_table . '.id=' . $this->feature_content_table . '.' . $this->feature . '_id',
                $this->feature_category_table => $this->feature_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id') . '=' . $this->feature_category_table . '.id'
                // $this->feature_category_content_table => $this->feature_table . '.' . (isset($this->join_column) ? $this->join_column : 'category_id') . '=' . $this->feature_category_content_table . '.' . (isset($this->join_column) ? $this->join_column : 'category_id'),
            ]
        ];

        if (isset($this->feature_content_table)) {

            $sql_params['join'][$this->feature_content_table] =  $this->feature_table . '.id=' . $this->feature_content_table . '.' . $this->feature . '_id';
        
        }

        if (isset($this->feature_category_content_table)) {

            $sql_params['join'][$this->feature_category_content_table] =  $this->feature_category_table . '.id=' . $this->feature_category_content_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id');
        
        }

        if ($params != null) {

            if (isset($params['join']))
                foreach ($params['join'] as $table => $rule) $sql_params['join'][$table] = $rule;

        }

        if (is_numeric($id)) $sql_params['condition'] = $this->feature_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id') . '=' . $id . '';
            else $sql_params['condition'] = $this->feature_table . '.' . (isset($this->join_column_category) ? $this->join_column_category : 'category_id') . ' is ' . $id . '';
        
        if ($params != null) {
            if (isset($params['limit'])) $sql_params['limit'] = $params['limit'];
        }
        
        // var_dump($sql_params);

        $features = $this->fetch_data_for_features($sql_params);

        if (empty($features)) $feature_data = ['error' => 'No Data was found for this category: ' . $id];
            else foreach($features as $feature) $feature_data[] = self::assign_feature_values($feature, $this->feature);
        return $feature_data;

    }


// UPDATE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function update_feature_data($sql_params = null) 
    {
        
        if (isset($_POST['update-feature'])) {

            if ($sql_params != null) {
                
                // Object has sent it's params 

            } else {

                // Use Default Params
                
                // If image is being Updated
                if (!empty($_FILES)) {
                
                    if (File::check_if_file_is_submitted()) {
                    
                        foreach ($_FILES as $file => $info) {

                            if (isset($_POST[$file])) {

                                if (File::upload_file($info, $_POST[$file], REL_PATH_TO_IMAGES)) $feedback[] = 'File was successfully moved to your Library';
                                    else $feedback[] = 'For some reason, we could not move ' . $file['name'] . ' to your Library, [please try again]';

                            } else {

                                $sql_params = $this->resolve_feature_table_params();

                                if ($sql_params != false) {

                                    $sql_params['control'] = [
                                        'id' => $_POST['control']
                                    ];

                                    if (File::upload_file($info, $sql_params['values'][$file], REL_PATH_TO_IMAGES)) {

                                        $feedback[] = 'File was successfully moved to your Library';
                                        $feedback[] = 'Attempting to update file name in DB';

                                        if ($this->update_data_in_table($sql_params) == true) $feedback[] = 'Filename was successfully Updated in the Database';
                                            else $feedback[] = 'For some reason, we could not update the DB with ' . $info['name'] . ', [please try again]';

                                    } else $feedback[] = 'For some reason, we could not move ' . $file['name'] . ' to your Library, [please try again]';

                                }

                            }

                        }

                    } else $feedback[] = 'Sorry, the file you uploaded is either not recognized or too heavy, [Please Try again]';

                } else {

                    if (isset($this->feature_table_columns)) {

                        $sql_params = $this->resolve_feature_table_params();

                        if ($sql_params != false) {

                            $sql_params['control'] = [
                                'id' => $_POST['control']
                            ];

                            if ($this->update_data_in_table($sql_params) == true) $feedback[] = 'Feature Successfully Updated';
                                else $feedback[] = 'Sorry, Content could not be Updated, [Please Try again]';

                        }

                    }


                    // And/Or Update the rest of the feature content 
                    if (isset($this->feature_content_table_columns)) {

                        $sql_params = $this->resolve_feature_content_table_params();
                        // var_dump($sql_params); die;

                        if ($sql_params != false) {

                            $sql_params['control'] = [
                                $this->feature . '_id' => $_POST['control']
                            ];

                            if ($this->update_data_in_table($sql_params) == true) $feedback[] = 'Feature [Content] Successfully Updated';
                                else $feedback[] = 'Sorry, Content could not be Updated, [Please Try again]';

                        }

                    }

                }

            }

            return $feedback;

        }

    }
    
    
    public function update_feature_category_data($sql_params = null) 
    {
        
        if (isset($_POST['update-feature-category'])) {

            if ($sql_params != null) {
                
                // Object has sent it's params 

            } else {

                // Use Default Params

                // If image is being Updated
                if (!empty($_FILES)) {

                    foreach ($_FILES as $file) {

                        if (isset($_POST['image'])) {

                            if (File::upload_file($file, $_POST['image'], REL_PATH_TO_IMAGES)) $feedback[] = 'File was successfully moved to your Library';
                                else $feedback[] = 'For some reason, we could not move ' . $file['name'] . ' to your Library, [please try again]';

                        } else {

                            $sql_params = $this->resolve_feature_category_table_params();

                            if ($sql_params != false) {

                                $sql_params['control'] = [
                                    'id' => $_POST['control']
                                ];

                                if (File::upload_file($file, $sql_params['values']['image'], REL_PATH_TO_IMAGES)) {

                                    $feedback[] = 'File was successfully moved to your Library';
                                    $feedback[] = 'Attempting to update file name in DB';

                                    if ($this->update_data_in_table($sql_params) == true) $feedback[] = 'Filename was successfully Updated in the Database';
                                        else $feedback[] = 'For some reason, we could not update the DB with ' . $file['name'] . ', [please try again]';

                                } else $feedback[] = 'For some reason, we could not move ' . $file['name'] . ' to your Library, [please try again]';

                            }

                        }

                    }

                } else {

                    if (isset($this->feature_category_table_columns)) {

                        $sql_params = $this->resolve_feature_category_table_params();

                        if ($sql_params != false) {

                            $sql_params['control'] = [
                                'id' => $_POST['control']
                            ];
                            
                            if ($this->update_data_in_table($sql_params) == true) $feedback[] = 'Feature Category Successfully Updated';
                                else $feedback[] = 'Sorry, Content could not be Updated, [Please Try again]';

                        }

                    }


                    // And/Or Update the rest of the feature content 
                    if (isset($this->feature_category_content_table_columns)) {

                        $sql_params = $this->resolve_feature_category_content_table_params();

                        if ($sql_params != false) {

                            $sql_params['control'] = [
                                (isset($this->join_column) ? $this->join_column : 'category_id') => $_POST['control']
                            ];

                            var_dump($sql_params);

                            if ($this->update_data_in_table($sql_params) == true) $feedback[] = 'Feature Category [Content] Successfully Updated';
                                else $feedback[] = 'Sorry, Content could not be Updated, [Please Try again]';

                        }

                    }

                }

            }

            return $feedback;

        }

    }


// DELETE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function delete_feature_data($sql_params = null)
    {

        if (isset($_POST['delete-feature'])) {
            
            if ($sql_params != null) {
            } else {
                
                $sql_params = $this->resolve_feature_table_params();

                if ($sql_params != false) {

                    $sql_params['control'] = [
                        'id' => $_POST['control']
                    ];

                    $delete_feedback = $this->delete_data_from_table($sql_params);

                    if ($delete_feedback['status'] == true) $feedback[] = 'Data was Successfully Deleted';
                        else $feedback[] = 'Sorry, Data could not be Deleted from DB, [Please Try again]';
                    
                    return $feedback;

                }

            }

        }


    }


    public function delete_feature_category_data($sql_params = null)
    {

        if (isset($_POST['delete-feature-category'])) {
            
            if ($sql_params != null) {

            } else {
                
                $sql_params = $this->resolve_feature_category_table_params();

                if ($sql_params != false) {

                    $sql_params['control'] = [
                        'id' => $_POST['control']
                    ];

                    $delete_feedback = $this->delete_data_from_table($sql_params);

                    if ($delete_feedback['status'] == true) $feedback[] = 'Category Data was Successfully Deleted';
                        else $feedback[] = 'Sorry, Category Data could not be Deleted from DB, [Please Try again]';
                    
                    return $feedback;

                }

            }

        }


    }









    
// Front End Methods ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function list_features($feature, $params=null, $template_file=null) 
    {
        
        $object = new $feature; 

        $data = $object->fetch_all_features($params);
        $template = PATH_TO_THEME . '/web/views/' . (
            isset($template_file) 
                ? $template_file 
                : (isset($object->template_preview) ? $object->template_preview : 'default-feature-preview.html')
        );
        
        // var_dump($data);
        foreach ($data as $feature_data) {

            echo \Run::render_template_with_content(
                $template, 
                [
                    'feature_page' => $object->feature_page, 
                    'feature_data' => $feature_data
                ]
            );

        }

    }

    
    // Default method to display a carousel
    public function do_carousel($params=null)
    {

        if (!isset($params['condition'])) 
            $params['condition'] = $this->feature_table . '.category_id = 1 AND ' . $this->feature_table . '.is_active=1';

        $data = $this->fetch_all_features($params);

        $template = PATH_TO_THEME . '/web/views/' . (isset($template_file) ? $template_file : 'carousel.html');
        
        echo \Run::render_template_with_content($template, ['feature_data' => $data]);

    }
    

    // Default method to slick data
    public function slide_features($params=null, $template_file=null) 
    {
        
        $data = $this -> fetch_all_features($params);
        $template = PATH_TO_THEME . '/web/views/' . (isset($template_file) ? $template_file : 'default-feature-preview.html');
        
        // var_dump($data);
        echo \Run::render_template_with_content($template, ['feature_data' => $data]);

    }

}