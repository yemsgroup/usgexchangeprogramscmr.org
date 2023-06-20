<?php 
// This class creates simple static methods that can be used to perform quick simple tasks
// like rending a template, posting an image, etc.
class Log {
        
    const APP_LOG_FILE = 'logs/APP_log_%s.log';

    public function __construct() {
        
        $this->logs_folder = 'logs';
        $this->site_logs = self::check_logs_folder();

    }

    function check_logs_folder() {
	    
        if (file_exists($this->logs_folder)) $logs = $this->logs_folder;
            else $logs = mkdir($this->logs_folder);
        
        return $logs;
    
    }
    
    // logging code
    
    function get_current_logfile_name() {
        
        return sprintf(self::APP_LOG_FILE, date('Ymd'));

    }
    
    function app_log_message($loglevel, $message) {
        
        $current_time = date('H:i:s');
        $logentry = sprintf("[%s] [%s] %s\n", $current_time, $loglevel, $message);
        $logfile = @fopen(self::get_current_logfile_name(), 'a');

        if($logfile !== false) {
    
            @fwrite($logfile,$logentry);
            @fclose($logfile);

        } else {

            $site_logs = self::check_logs_folder();
            if (!$site_logs == false) {
                
                @fwrite($logfile, $logentry);
                @fclose($logfile);

            } else {
                echo 'could not find or create log file';
            }

        }

    }

}