<?php 
// This class creates simple static methods that can be used to perform quick simple tasks
// like rending a template, posting an image, etc.
class Validate {

    public function __construct() {
        
        defined('FYRE_REQUIRED_DEFAULT_MESSAGE') or define('FYRE_REQUIRED_DEFAULT_MESSAGE',"{field} cannot be empty");

        defined('APP_VALIDATION_FIELDNAME_KEY') or define('APP_VALIDATION_FIELDNAME_KEY', 'name');
        defined('APP_VALIDATION_ERRORS_KEY') or define('APP_VALIDATION_ERRORS_KEY', 'errors');
        defined('APP_VALIDATION_FUNCTION_SUFFIX') or define('APP_VALIDATION_FUNCTION_SUFFIX', '_validator_validate');
        // defined('APP_VALIDATORS_DIR') or define('APP_VALIDATORS_DIR', ROOT_DIR . '/validators');
        defined('APP_VALIDATION_ERROR_MSG_KEY') or define('APP_VALIDATION_ERROR_MSG_KEY', 'message');

    }


    function has_validation_errors(&$validation_errors) {

        return $validation_errors!=null && !empty($validation_errors);

    }

    
    function resolve_validation_error_message($default_message, $params) {
    
        if(isset($params[APP_VALIDATION_ERROR_MSG_KEY]) && !empty($params[APP_VALIDATION_ERROR_MSG_KEY]))
            return $params[APP_VALIDATION_ERROR_MSG_KEY];
        else
            return $default_message;

    }

    
    function create_validation_error_message($message, $params) {
        
        if($message == null)
            return null;
    
        return MessageFormatter::formatMessage(APP_LOCALE, $message, $params);

    }

    
    function set_validation_error($field, $message, &$validation_errors) {
    
        if($field == null || $message == null)
            return;

        if(isset($validation_errors[$field]) && is_array($validation_errors[$field]))
            $validation_errors[$field][] = $message;
    
        if(!isset($validation_errors[$field]))
            $validation_errors[$field] = [$message];

    }
    
    
    function get_first_validation_error($field, &$validation_errors) {
    
        if($field == null || !isset($validation_errors[$field]))
            return null;
    
        return $validation_errors[$field][0];

    }
    

    function get_validation_errors($field, &$validation_errors) {
    
        if($field == null || !isset($validation_errors[$field]))
            return [];
    
        return $validation_errors[$field];

    }


    function get_all_validation_errors(&$validation_errors) {
    
        $ret = [];
        foreach($validation_errors as $field=>$field_errors) {

            foreach($field_errors as $field_error)
                $ret[] = $field_error;

        }
        return $ret;

    }

    
    

    function required_validator_validate($field, $data, $params, &$validation_errors) {

        if($data == null || empty($data)) {

            $message_template = resolve_validation_error_message(FYRE_REQUIRED_DEFAULT_MESSAGE, $params);
            $error_msg_params = [
                'field'=>$field
            ];
            $message = create_validation_error_message($message_template, $error_msg_params);
            set_validation_error($field, $message, $validation_errors);
            
        }

    }


    function perform_validation($data, $rules, &$validation_errors, &$errors) {
	
        $errors = [];
    
        foreach($rules as $rule) {
    
            $fields = null;
            $validator_alias = null;
            $validator_params = null;
    
            if(isset($rule[0]) && is_string($rule[0]))
                $fields = [$rule[0]];
            else if(isset($rule[0]) && is_array($rule[0]))
                $fields = $rule[0];
    
            if(isset($rule[1]) && is_string($rule[1]))
                $validator_alias = $rule[1];
    
    
            if(isset($rule[2]) && is_array($rule[2]))
                $validator_params = $rule[2];
            else
                $validator_params = [];
    
            if($fields==null && $validator_alias==null) {
                $errors[] = 'invalid rule specified';
                continue;
            }
    
            foreach($fields as $field) {
                $value = null;
                if(isset($data[$field]))
                    $value = $data[$field];
    
                if(perform_field_validation($field, $value, $validator_alias, $validator_params, $validation_errors)===FALSE) {
                    $errors[] = "failure invoking validator ${validator_alias}";
                }
            }
    
        }
    
        return empty($errors) && empty($validation_errors);
    
    }
    
    function perform_field_validation($field, $value, $validator, $params, &$validation_errors) {
    
        $function_name = $validator.''.APP_VALIDATION_FUNCTION_SUFFIX;
        $function_params = [
            $field, 
            $value, 
            $params, 
            &$validation_errors, 
        ];
        
        return call_user_func_array($function_name, $function_params);
        
    }
    
}