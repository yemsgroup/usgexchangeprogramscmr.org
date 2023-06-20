<?php 
// This class creates simple static methods that can be used to perform quick simple tasks
// like rending a template, posting an image, etc.
class FormRequest extends Db {

    public function __construct() {}


    public function assign_post_value($input, $error_message=null, &$error_container=null) {

        if ($error_message != null) {

            if (self::validate_empty_post_variable($input, $error_message, $error_container)) {
                return $_POST[$input];
            }

        } else {
            return self::clean_input($input);
        }

    }
    

    // Checks if get_magic_quotes is enabled or uses addslashes to escape special characters 
    public function clean_input($input) {

        $magic_quotes_active = get_magic_quotes_gpc();
        $new_enough_php = function_exists("mysqli_real_escape_string()");

        if ($new_enough_php) {
            
            if ($magic_quotes_active) {
                $clean_input = stripslashes($_POST[$input]);
            }
        
        } else {

            if (!$magic_quotes_active) {
                $clean_input = addslashes($_POST[$input]);
            }

        }

        return trim($clean_input);

    }

    
    // checks if a certain name is being posted and returns true or false.
    public function is_post_variable_set($name) {
        return isset($_POST[$name]);
    }


    // checks if a certain namee posted is empty and returns true 
    // or passes the error message to an error container
    public function validate_empty_post_variable($name, $error_message, &$error_container) {

        if (!self::is_post_variable_set($name) || (self::is_post_variable_set($name) && empty($_POST[$name]))) {

            $error_container[] = $error_message;
            return false;

        }

        return true;

    }


    // sends a passed data by email with the default PHP mail function
    public function send_with_mail($to, $subject, $message, $headers, &$status=null) {

        if (isset($status)) {
            
            if (@mail($to, $subject, $message, $headers)) $status['send_status'] = true;
                else $status['send_status'] = false;
            
        } else {
            @mail($to, $subject, $message, $headers);
        }

    }


    // Uses a predefined service (like mailgun or sendgrid) to send data by email.
    public function send_with_service($service, $from, $to, $subject, $message, $headers) {}


    // Handles various types of multimedia form submissions (images, files, videos, etc)
    public function handle_multimedia($value) {}

}