<?php

include_once 'autoload.php';
include_once '../../sessions.php';
include_once '../../options.php';

$fr = new FormRequest;
$vl = new Validate;

if(isset($_POST['submit'])) {
    
    $errors = $progress = $submitted = $form_feedback = array();

    if (!defined('DEVELOPMENT')) {

        if (isset($_SESSION['captcha_code'])) {
            
            if (isset($_POST['captcha'])) {
                    
                if($_POST['captcha'] != $_SESSION['captcha_code']) {
                    $errors[] = 'Wrong Captcha!!!';
                }
                
            } else {

                $errors[] = 'No captcha verification was sent';
                
            }

        } else {
            
            $errors[] = 'Captcha verification is not active';
            
        }

    }

    $submitted['names'] = $_COOKIE['names'] = $fr -> assign_post_value('names', 'Names cannot be empty', $errors);
    $submitted['email'] = $_COOKIE['email'] = $fr -> assign_post_value('email', 'Email cannot be empty', $errors);
    $submitted['subject'] = $_COOKIE['subject'] = $fr -> assign_post_value('subject', 'Subject cannot be empty', $errors);
    $submitted['message'] = $_COOKIE['message'] = $fr -> assign_post_value('message', 'Message cannot be empty', $errors);
    
    if(empty($errors)) {

        // Send the Data by Email to form owner
        $email_header = "From: " . $submitted['email'] . "\n"
            . "Reply-To: " . $submitted['email'] 
            . "\n" . "MIME-Version: 1.0\r\n" 
            . "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $email_subject = $submitted['subject'] . " from " 
            . (defined('SITE_ACRONYM') ? SITE_ACRONYM : "") 
            . " Contact Form";

        $email_message = '<p>' . nl2br($submitted['message']) . '</p>' . $submitted['names'] . ', ' . $submitted['email'];
        
        $email_send_to = defined('SITE_EMAIL') ? SITE_EMAIL : 'webmaster@yems.group';

        $fr -> send_with_mail($email_send_to, $email_subject, $email_message, $email_header, $progress);
        
        if ($progress['send_status'] == true) {
            
            $form_feedback[] = 'Thank you for writing to us, Someone from our Team will reply to your message soon.</p> <p>Please keep visiting our website';
            
            // Insert the Data into DB
            // Initialize the db object 
            $db = new Db;
            
            // Indicate the columns=>values to be inserted
            $insert_columns = ['names', 'email', 'subject', 'message'];
            $insert_values = [$submitted['names'], $submitted['email'], $submitted['subject'], $submitted['message']];
            
            $insert_data_into_db = $db -> insert_data_into_table('contact_form_messages', $insert_columns, $insert_values); 
            
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
                . (defined('SITE_EMAIL') ? ' <strong>If this persists, please contact us directly at ' . SITE_EMAIL . '</strong>' : '' );

        }

        if ($form_feedback) Run::set_flash_message(['feedback' => $form_feedback]);
        if ($progress) Run::set_flash_message(['progress' => $progress]);

    } else {

        Run::set_flash_message(['errors' => $errors]);
        Run::set_flash_message(['submitted' => $submitted]);

    }
    
    Run::redirect_to($_SERVER['HTTP_REFERER']);

}