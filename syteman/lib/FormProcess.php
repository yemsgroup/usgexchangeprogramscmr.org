<?php

class FormProcess {
    
    function __construct() 
    {

        // Figure out method to handle form 
        if (isset($_POST['submit'])) {

            switch ($_POST['submit']) {

                case 'Send Message':
                    $this->process_contact_form();
                    break;

                case 'Subscribe':
                    $this->process_newsletter_subscribe();
                    break;

                default: 
                    break; 
                    
            }
        }
        
    }


    public function check_and_assign_post_value($input, $error_message=null, &$error_container=null) {

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


    function process_contact_form() {

        $vldt = new Validate;

        if(isset($_POST['submit'])) {
            
            $errors = $progress = $submitted = $form_feedback = array();

            if (!defined('DEVELOPMENT')) {

                // if (isset($_SESSION['captcha_code'])) {
                    
                //     if (isset($_POST['captcha'])) {
                            
                //         if($_POST['captcha'] != $_SESSION['captcha_code']) {
                //             $errors[] = 'Wrong Captcha!!!';
                //         }
                        
                //     } else {

                //         $errors[] = 'No captcha verification was sent';
                        
                //     }

                // } else {
                    
                //     $errors[] = 'Captcha verification is not active';
                    
                // }

            }

            $submitted['names'] = $_COOKIE['names'] = $this->check_and_assign_post_value('names', 'Names cannot be empty', $errors);
            $submitted['email'] = $_COOKIE['email'] = $this->check_and_assign_post_value('email', 'Email cannot be empty', $errors);
            $submitted['subject'] = $_COOKIE['subject'] = $this->check_and_assign_post_value('subject', 'Subject cannot be empty', $errors);
            $submitted['message'] = $_COOKIE['message'] = $this->check_and_assign_post_value('message', 'Message cannot be empty', $errors);
            
            if(empty($errors)) {

                // Send the Data by Email to form owner
                $email_header = "From: " . $submitted['email'] . "\n"
                    . "Reply-To: " . $submitted['email'] 
                    . "\n" . "MIME-Version: 1.0\r\n" 
                    . "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $email_subject = $submitted['subject'] . " from " 
                    . (defined('ORG_ACRONYM') ? ORG_ACRONYM : "") 
                    . " Contact Form";

                $email_message = '<p>' . nl2br($submitted['message']) . '</p>' . $submitted['names'] . ', ' . $submitted['email'];
                
                $email_send_to = defined('ORG_EMAIL') ? ORG_EMAIL : 'webmaster@yems.group';

                $this->send_with_mail($email_send_to, $email_subject, $email_message, $email_header, $progress);
                
                if ($progress['send_status'] == true) {
                    
                    $form_feedback[] = 'Thank you for writing to us, Someone from our Team will reply to your message soon.</p> <p>Please keep visiting our website';
                    
                    // Insert the Data into DB
                    // Initialize the db object 
                    $db = new Db;
                    
                    // Indicate the columns=>values to be inserted
                    $insert_columns = [
                        'names' => 'names', 
                        'email' => 'email', 
                        'subject' => 'subject', 
                        'message' => 'message'
                    ];
                    $insert_values = [
                        'names' => $submitted['names'], 
                        'email' => $submitted['email'], 
                        'subject' => $submitted['subject'], 
                        'message' => $submitted['message']
                    ];

                    $params = [
                        'table_name' => 'contact_form_messages',
                        'columns' => $insert_columns,
                        'values' => $insert_values
                    ];
                    
                    $insert_data_into_db = $db -> insert_data_into_table($params); 
                    
                    // Check if Insert succeeds and log.
                    if ($insert_data_into_db['status'] == false) {
                        
                        // Log the error to a logfile.
                        $log = new Log;
                        $log -> app_log_message('error', 'Problem saving contact form submission to DB ->  ' . $insert_data_into_db['error']);

                    }

                    // ...and then destroy the cookies
                    // Find a Cleaner way of doing this
                    foreach ($submitted as $key=>$value) {

                        if (isset($_COOKIE[$key])) {

                            unset($_COOKIE[$key]);
                            setcookie($key, '', time() - 3600, '/'); // empty value and old timestamp

                        }

                    }

                } else {

                    $form_feedback[] = 'Ooops!! For some reason your submission was not received, Please Try again.' 
                        . (defined('ORG_EMAIL') ? ' <strong>If this persists, please contact us directly at ' . ORG_EMAIL . '</strong>' : '' );

                }

                if ($form_feedback) Run::set_flash_message(['feedback' => $form_feedback]);
                if ($progress) Run::set_flash_message(['progress' => $progress]);

            } else {

                Run::set_flash_message(['errors' => $errors]);
                Run::set_flash_message(['submitted' => $submitted]);

            }
            
            Run::redirect_to($_SERVER['HTTP_REFERER']);

        }

    }


    function process_newsletter_subscribe() {

        $vldt = new Validate;

        if(isset($_POST['submit'])) {
            $errors = $progress = $submitted = $form_feedback = array();

            $submitted['first_name'] = $_COOKIE['first_name'] = $this->check_and_assign_post_value('first_name', 'First Name cannot be empty', $errors);
            $submitted['email'] = $_COOKIE['email'] = $this->check_and_assign_post_value('email', 'Email cannot be empty', $errors);
            
            if(empty($errors)) {
                    
                // Insert the Data into DB
                // Initialize the db object 
                $db = new Db;
                
                // Indicate the columns=>values to be inserted
                $insert_columns = ['first_name' => 'first_name', 'email' => 'email'];
                $insert_values = ['first_name' => $submitted['first_name'], 'email' => $submitted['email']];

                $params = [
                    'table_name' => 'email_subscriptions',
                    'columns' => $insert_columns,
                    'values' => $insert_values
                ];
                
                $insert_data_into_db = $db -> insert_data_into_table($params); 
                
                // Check if Insert succeeds and log.
                if ($insert_data_into_db['status'] == false) {
            
                    // var_dump($insert_data_into_db); die;

                    $form_feedback[] = 'Ooops!! For some reason your email could not be added, Please Try again.<br><strong>[' . $insert_data_into_db['message'] . ']</strong><br>' . (defined('ORG_EMAIL') ? ' If this persists, please contact us directly at ' . ORG_EMAIL . '' : '' );
                    
                    // Log the error to a logfile.
                    $log = new Log;
                    $log -> app_log_message('error', 'Problem saving Email to DB ->  ' . $insert_data_into_db['error']);

                } else {

                    $form_feedback[] = 'Yayy!! your email was successfully added to our DB';

                }

                // ...and then destroy the cookies
                // Find a Cleaner way of doing this
                foreach ($submitted as $key=>$value) {

                    if (isset($_COOKIE[$key])) {

                        unset($_COOKIE[$key]);
                        setcookie($key, '', time() - 3600, '/'); // empty value and old timestamp

                    }

                }

                if ($form_feedback) Run::set_flash_message(['feedback' => $form_feedback]);
                if ($progress) Run::set_flash_message(['progress' => $progress]);

            } else {

                Run::set_flash_message(['errors' => $errors]);
                Run::set_flash_message(['submitted' => $submitted]);

            }
            
            Run::redirect_to($_SERVER['HTTP_REFERER']);

        }

    }


    function do_login() {

        if(isset($_POST['login'])) {
            
            $errors = $progress = $submitted = $form_feedback = array();

            // if (!defined('DEVELOPMENT')) {

            //     if (isset($_SESSION['captcha_code'])) {
                    
            //         if (isset($_POST['captcha'])) {
                            
            //             if($_POST['captcha'] != $_SESSION['captcha_code']) {
            //                 $errors[] = 'Wrong Captcha!!!';
            //             }
                        
            //         } else {

            //             $errors[] = 'No captcha verification was sent';
                        
            //         }

            //     } else {
                    
            //         $errors[] = 'Captcha verification is not active';
                    
            //     }

            // }

            $submitted['username'] = $_COOKIE['username'] = $this->check_and_assign_post_value('username', 'Names cannot be empty', $errors);
            $submitted['password'] = $_COOKIE['password'] = $this->check_and_assign_post_value('password', 'Email cannot be empty', $errors);

            if(empty($errors)) {

                $db = new Db;
                $user = new User;

                $params = [
                    'table_name' => $user->feature_table,
                    'columns' => $user->select_columns,
                    'condition' => $user->feature_table . '.username="' . $submitted['username'] . '" AND ' . $user->feature_table . '.hashed_password="' . sha1($submitted['password']) . '"'
                ];

                $user_exists = $user->fetch_data_for_this_feature(null, $params);

                // Check if Insert succeeds and log.
                if (isset($user_exists['error'])) {
                    
                    Run::set_flash_message(['errors' => 'Username and Password was not Found']);
                    return null;

                } else return $user_exists[0];
                
            } else return null;

        }

    }


    static function create_link_from_form_input($prefix=null)
    {
        
        if (isset($_POST['link']) && $_POST['link'] != '') {

            $link = Run::create_link_from_string($_POST['link']);

        } else {

            if (isset($_POST['title']) && $_POST['title'] != '') $link = Run::create_link_from_string($_POST['title']);
                elseif (isset($_POST['name']) && $_POST['name'] != '') $link = Run::create_link_from_string($_POST['name']);
                    else $link = false; // uniqid($prefix . (!is_null($prefix) ? '-' : ''));
                    
        }

        return $link;

    }

}