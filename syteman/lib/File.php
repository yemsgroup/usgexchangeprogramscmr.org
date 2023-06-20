<?php

class File {

     function __construct() 
     {}


     static function upload_file($file_info, $file_name, $destination=null)
     {

          return move_uploaded_file($file_info['tmp_name'], '../' . (($destination != null) ? $destination : REL_PATH_TO_LIBRARY) . '/' . $file_name);

     }


     static function name_file($ext, $prefix=null) 
     {

          return substr(($prefix != null ? $prefix . '-' : ''), 0, 25) . time() . '.' . $ext;

     }


     static function check_if_file_is_submitted() 
     {

          $submission = 0;
          foreach ($_FILES as $file) $submission += $file['size'];

          if ($submission > 0) return true;
               else return false;
          
     }


     static function validate_file_type($file, $group)
     {

          switch ($group) {

               case 'image': 
                    $ext = self::validate_image_extension($file); 
                    break;
               
               case 'video': 
                    $ext = self::validate_video_extension($file); 
                    break;

               case 'document':
                    $ext = self::validate_doc_extension($file); 
                    break;
               
               default: 
                    $ext = false;
                    break;

          }

          return $ext;

     }


     static function validate_image_extension($file)
     {

          if ($file != '') {

               switch($file['type']) {
                    
                    case 'image/png':
                    case 'image/PNG':
                         $ext = 'png';
                         break;

                    case 'image/jpeg':
                    case 'image/jpg':
                    case 'image/JPEG':
                    case 'image/JPG':
                         $ext = 'jpg';
                         break;
                    
                    case 'image/svg+xml':
                         $ext = 'svg';
                         break;
                    
                    case 'image/gif':
                    case 'image/GIF':
                         $ext = 'gif';
                         break;
                    
                    default:
                         $ext = false;
                         break;

               }

          } else {
          
               $ext = false;
          
          }

          return $ext;

     }

}