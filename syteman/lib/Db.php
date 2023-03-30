<?php

class Db {

    public function __construct() 
    {

        $db_info = include ROOT_DIR . '/config/db.php';

        // Test the DB info from config/db.php or redirect to onboard for the right dsn details to be set
        try {

            $this->db = new PDO($db_info['dsn'], $db_info['username'], $db_info['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e) {

            // If the Test DB connection fails... 
            // Redirect to the onboard.php file where you can set the correct information.
            Run::redirect_to(BASE_URL . '/onboard.php?error=' . $e->getMessage() 
                . '&dsn=' . $db_info['dsn'] 
                . '&username=' . $db_info['username'] 
                . '&password=' . $db_info['password']
            );

        }

    }


    public function start_transaction()
    {

        $query = 'START TRANSACTION';

        $prepared_query = $this->db->prepare($query);

        try {

            $prepared_query->execute();

            $feedback = [
                'status' => true,
                'message' => '[Success] Started Transaction', 
            ];

        } catch (Exception $e) {

            $error = $e->getMessage();
            
            $feedback = [
                'status' => false, 
                'message' => $error
            ];

        }

        return $feedback;

    }


    public function commit_transaction()
    {

        $query = 'COMMIT';

        $prepared_query = $this->db->prepare($query);

        try {

            $prepared_query->execute();

            $feedback = [
                'status' => true,
                'message' => '[Success] Transaction Committed', 
            ];

        } catch (Exception $e) {

            $error = $e->getMessage();
            
            $feedback = [
                'status' => false, 
                'message' => $error
            ];

        }

        return $feedback;

    }
    

    public function roll_back_transaction()
    {
        $query = 'ROLLBACK';

        $prepared_query = $this->db->prepare($query);

        try {

            $prepared_query->execute();

            $feedback = [
                'status' => true,
                'message' => '[Success] Transaction Rolled Back', 
            ];

        } catch (Exception $e) {

            $error = $e->getMessage();
            
            $feedback = [
                'status' => false, 
                'message' => $error
            ];

        }

        return $feedback;

    }


    // Method to Build a Query
    public function build_query($type = null, $params = null) 
    {

        $query = '';

        // Type defines the query (CRUD)
        if ($type == 'create') {

            $query .= 'INSERT INTO [table]() ';
            $query .= 'VALUES()';

        } elseif ($type == 'read') {

            $query .= 'SELECT [columns] FROM [table]';
            $query .= 'WHERE ';
            $query .= 'LIMIT ';
            $query .= 'ORDER BY ';

        } elseif ($type = 'update') {

            $query .= 'UPDATE [table] ';
            $query .= 'SET () ';
            $query .= 'WHERE ';

        } elseif ($type = 'delete') {

            $query .= 'DELETE FROM [table] ';
            $query .= 'WHERE ';

        }

        return $query;

    }

    
    // Method to add Data into Tables. 
    public function insert_data_into_table($params = null) {

        $query = 'INSERT INTO ';
        $query .= $params['table_name'] . '(';

        foreach ($params['columns'] as $column => $field) {

            $query .= $column;

            // add a comma if it's not the last entry.
            if ($column != array_key_last($params['columns'])) $query .= ', ';
            
        }

        $query .= ') VALUES (';

        foreach ($params['columns'] as $column => $field) {
                
            // Clean the input for MySQL
            $clean_input = Run::clean_mysql_input($params['values'][$field]);

            // Quote the input if it's not numeric
            if ($clean_input != '')
                $query .= (is_numeric($clean_input) ? $clean_input : '"' . $clean_input . '"');
            else 
                $query .= NULL;

            // add a comma if it's not the last entry.
            if ($column != array_key_last($params['columns'])) $query .= ', ';
            
        }

        $query .= ')';

        $prepared_query = $this->db->prepare($query);

        // var_dump($query);

        try {

            $prepared_query->execute();
            $inserted_id = $this->db->lastInsertId();

            $feedback = [
                'status' => true,
                'inserted_id' => $inserted_id,
                'message' => '[Success] succesfully added row with id: ' . $inserted_id . ' into DB', 
            ];

        } catch (Exception $e) {

            // $error = $e->getMessage();
            $error = $e->errorInfo[2];
            
            $feedback = [
                'status' => false, 
                'message' => $error
            ];

        }

        // var_dump($feedback); die;

        return $feedback;
        
    }


    // Method to Update Data in Tables. 
    public function update_data_in_table($params = null) 
    {

        $query = 'UPDATE ';

        if (isset($params['table_name'])) $query .= $params['table_name'];

        if (isset($params['columns'])) {

            $query .= ' SET ';
            foreach ($params['columns'] as $column => $field) {
                
                // Clean the input for MySQL
                $clean_input = Run::clean_mysql_input($params['values'][$field]);

                // Quote the input if it's not numeric
                if ($clean_input != '')
                    $query .= $column . '=' . (is_numeric($clean_input) ? $clean_input : '"' . $clean_input . '"');
                else 
                    $query .= $column . '=' . 'NULL';

                // add a comma if it's not the last entry.
                if ($column != array_key_last($params['columns'])) $query .= ', ';
                
            }
            
        }

        if (isset($params['control'])) {
            
            $query .= ' WHERE ';

            if (is_array($params['control'])) {

                foreach ($params['control'] as $column => $condition) {
                    
                    // Check if there are many Controls and add an "AND" if it's not the first control
                    if (count($params['control']) > 1) {
                        if ($column != array_key_first($params['control'])) $query .= ' AND ';
                    }

                    $query .= $column . '=' . (is_numeric($condition) ? $condition : '"' . $condition . '"');
                    
                }

            } else $query .= $params['control'];
        
        }

        // Alternatively using the build_query method to build the query
        // $query = $this->build_query('update', $params));

        // var_dump($query);

        $prepared_query = $this->db->prepare($query);
        $update_result = $prepared_query->execute();

        return $update_result;

    }


    // Method to Delete Data from Tables. 
    public function delete_data_from_table($params = null) 
    {
        
        $query = 'DELETE FROM ';
        
        if (isset($params['table_name'])) $query .= $params['table_name'];

        if (isset($params['control'])) {
            
            $query .= ' WHERE ';

            if (is_array($params['control'])) {

                foreach ($params['control'] as $column => $condition) {
                    
                    // Check if there are many Controls and add an "AND" if it's not the first control
                    if (count($params['control']) > 1) {
                        if ($column != array_key_first($params['control'])) $query .= ' AND ';
                    }

                    $query .= $column . '=' . (is_numeric($condition) ? $condition : '"' . $condition . '"');
                    
                }

            } else $query .= $params['control'];
        
        }

        // var_dump($query); die;

        $prepared_query = $this->db->prepare($query);

        try {

            $prepared_query->execute();

            $feedback = [
                'status' => true,
                'message' => '[Success] succesfully deleted row with id: from DB', 
            ];

        } catch (Exception $e) {

            $error = $e->getMessage();
            
            $feedback = [
                'status' => false, 
                'message' => $error
            ];

        }

        return $feedback;

    }





    // Methods from front site
    // Method to select everything from a DB Table
    function select_data($sql_params) {
        
        $query = 'SELECT ';

        $query .= isset($sql_params['columns']) ? $sql_params['columns'] : '*';

        if (isset($sql_params['table_name'])) $query .= ' FROM ' . $sql_params['table_name'];

        if (isset($sql_params['join'])) {
            
            foreach ($sql_params['join'] as $table => $column) {
        
                $query .= ' LEFT JOIN ' . $table . ' ON ' . $column;
                
            }

        }

        if (isset($sql_params['condition'])) $query .= ' WHERE ' . $sql_params['condition'];

        if (isset($sql_params['sort'])) $query .= ' ORDER BY ' . $sql_params['sort'];
            else $query .= ' ORDER BY id DESC';

        if (isset($sql_params['limit'])) $query .= ' LIMIT ' . $sql_params['limit'];

        // var_dump($query);

        $prepared_query = $this->db->prepare($query);
        $retrieve = $prepared_query->execute();
        $result_array = $prepared_query->fetchAll(PDO::FETCH_ASSOC);

        return $result_array;

    }

}