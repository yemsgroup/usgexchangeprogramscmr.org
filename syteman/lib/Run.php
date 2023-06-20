<?php

class Run {
    
    function __construct() 
    {}


    static function clean_mysql_input($content) 
    {

        $clean_content = trim(filter_var($content, FILTER_SANITIZE_ADD_SLASHES));

        return $clean_content;

    }

    
    // Replace non alphanumeric characters with dash
	// and special (accented) characters with their corresponding alphanumeric
	static function convert_special_characters($string) {

		// pattern are @charaters and @symbols....
		// the replacement are @replaceSymbols and @replaceCharaters....
		$symbols = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 's', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή', '');

		$alt_letters = array('a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'd', 'd', 'd', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 'h', 'h', 'h', 'h', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'ij', 'ij', 'j', 'j', 'k', 'k', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'l', 'n', 'n', 'n', 'n', 'n', 'n', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'oe', 'oe', 'r', 'r', 'r', 'r', 'r', 'r', 's', 's', 's', 's', 's', 's', 's', 's', 't', 't', 't', 't', 't', 't', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'w', 'w', 'y', 'y', 'y', 'z', 'z', 'z', 'z', 'z', 'z', 's', 'f', 'o', 'o', 'u', 'u', 'a', 'a', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'a', 'a', 'ae', 'ae', 'o', 'o', 'a', 'a', 'e', 'e', 'o', 'o', 'v', 'w', 'i', 'r', 'r', 'r', 'y', 'u', 'u', 'u', 'h', 'n', '-');

		return trim(str_replace($symbols, $alt_letters, $string));

	}


    static function replace_with_symbol($string, $symbol=null) 
    {

        $charaters = "~[\\\\/:*?&\"'<>|.,{}() \- +]~ ";
        $replaceCharaters = is_null($symbol) ? '-' : $symbol;

        return trim(strtolower(preg_replace($charaters, $replaceCharaters, "$string")));

    }


    static function create_link_from_string($string, $separator=null) 
    {

        return substr(trim(self::replace_with_symbol(self::convert_special_characters($string), $separator)), 0, 50);
        
    }







    // Methods from Front Site
    // Fetch and Show a template
    static function render_template_with_content(

        $templateName, 
        $params=array()

    ) {

        ob_start();

        extract($params);
        include $templateName;
        $render_data = ob_get_clean();

        return $render_data;

    }

    // A Quick function to check if an image exists 
    // and add an img tag to it or display the default no image file.
    static function post_image_or_default(

        $image_file,
        $attributes = null, 
        $source = null

    ) {

        $image_source = ( $source != null ) ? $source : PATH_TO_IMAGES;

        // Resolve attributes.
        $attr = '';
        if (isset($attributes)) {
            
            if (is_array($attributes)) {

                foreach ($attributes as $key => $value)
                    $attr .= $key . '="' . $value . '"';

            } else $attr .= $attributes;

        }

        // Resolve file and Source
        if (($image_file != null) AND ($image_file != ' ')) {
            
            $image = $image_source . $image_file;
            
            // The idea here is for the method to check if the file exists first
            // $image = (file_exists($image_source . $image_file) 
            //     ? $image_source . $image_file 
            //     : PATH_TO_IMAGES . 'default-no-image-wide.jpg');

        } else $image = 'default-no-image-wide.jpg';

        $image_str = '<img src="' . $image . '" ' . $attr . ' />';

        return $image_str;

    }

    // A Quick function to post an image.
    static function post_image(

        $image_file,
        $attributes = null,
        $source = null

    ) {

        $image_source = ( $source != null ) ? $source : PATH_TO_IMAGES;

        // Resolve attributes.
        $attr = '';
        if (isset($attributes)) {
            
            if (is_array($attributes)) {

                foreach ($attributes as $key => $value)
                    $attr .= $key . '="' . $value . '"';

            } else $attr .= $attributes;

        }

        // Resolve file and Source
        if (($image_file != null) AND ($image_file != ' ')) {

            $image = $image_source . $image_file;

            $image_str = '<img src="' . $image . '" ' . $attr . ' />';

        } else $image_str = '';

        return $image_str;

    }

    static function redirect_to($destination) {

        echo '<script type="text/javascript">';

			echo 'location.replace("' . $destination . '");';

		echo '</script>';

		die();

    }

    // Create and Use Flash Messages (Handy for moving between request files)
    static function set_flash_message($message) {

		$_SESSION['_flashmessage'][] = $message;

	}


    // Check if a flashmessage has been set 
	static function has_flash_message() {

		if (isset($_SESSION['_flashmessage'])) return true;

		return false;

	}


    // Fetch and use the flash messages that have been defined.
	static function get_flash_message() {
       
  	  	$ret = "";
  		$message = null;

		if (static::has_flash_message()) {

            $message = $_SESSION['_flashmessage'];
                
            foreach ($message as $values => $data) {

                if (is_array($data)) {

                    $key = array_keys($data);
                    $flash_messages[$key[0]] = $data[$key[0]];
                
                } else {
                    $flash_messages[] = $data;
                }

            }

            unset($_SESSION['_flashmessage']);

		}
		
		return $flash_messages;

	}

    
    // Do a Pagination 
    static function paginate($number_of_pages, $page, $current_page=null, $template=null, $variable_data=null) {
        
        $template_file = ($template != null) ? $template : PATH_TO_SYM_THEME . '/web/views/paging.html';
        return Run::render_template_with_content(
            $template_file,
            array(
                'page' => $page,
                'current_page' => $current_page,
                'number_of_pages' => $number_of_pages,
                'variable_data' => $variable_data
            )
        );
        
    }


    // Select a template file 
    static function get_template_file($template, $default=null) {
        
        $file = PATH_TO_THEME . 'web/views/' . (
            !empty($template) 
                ? $template
                : (
                    !is_null($default) 
                    ? $default
                    : 'default-feature-preview.html'
                )
        );

        return $file; 

    }


    // Check if a coded string is an existing feature
    static function check_for_feature($string) {
        
        if (
            (
                substr($string, 0, 3) == '{{{') && 
                (substr($string, (strlen($string)-3), strlen($string)) == '}}}'
            )
        ) {

            $feature = substr($string, 3, (strlen($string) - 6));
            $details = explode(',', ($feature));
            
            foreach ($details as $key) {
            
                $new = explode('=>', $key);
                if (isset($new[1])) $this_feature[trim($new[0])] = trim($new[1]);
                    else $this_feature[trim($new[0])] = true;

            }

        } else $this_feature = false;

        return $this_feature;

    }

}