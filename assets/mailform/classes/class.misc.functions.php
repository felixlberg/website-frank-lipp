<?php
/**
 * Misc_Functions
 * 
 * @package 
 * @author Gabriel Comarita
 * @copyright 2012
 * @version $Id$
 * @access public
 */
class Misc_Functions {
    
    public $acf_config;

    /* Credits: http://roshanbh.com.np/2007/12/getting-real-ip-address-in-php.html */
    
    /**
     * Misc_Functions::getRealIpAddr()
     * 
     * @return
     */
    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   // check ip from share internet
        {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   // to check ip is pass from proxy
        {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Misc_Functions::getURLtoFormDir()
     * 
     * @return
     */
    function getURLtoFormDir() {
    
    	if(!isSet($_SERVER['SCRIPT_URI'])) {
    		$script_uri = ( ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    	} else {
    		$script_uri = $_SERVER['SCRIPT_URI'];
    	}
    
    	return substr($script_uri, 0, -strlen(substr(strrchr($script_uri, '/'), 1)));
    }

    // Source: http://www.anyexample.com/programming/php/php_convert_rgb_from_to_html_hex_color.xml
    
    /**
     * Misc_Functions::html2rgb()
     * 
     * @param mixed $color
     * @return
     */
    function html2rgb($color) {
        if ($color[0] == '#')
            $color = substr($color, 1);
    
        if (strlen($color) == 6)
            list($r, $g, $b) = array($color[0].$color[1],
                                     $color[2].$color[3],
                                     $color[4].$color[5]);
        elseif (strlen($color) == 3)
            list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
        else
            return false;
    
        $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
    
        return array('r' => $r, 'g' => $g, 'b' => $b);
    }

    // json_encode - Returns the JSON representation of a value

    /* This is an alternative json_encode() function in case you're using an older PHP Version (PHP 5 >= 5.2.0, PECL json >= 1.2.0) */

    /**
     * Misc_Functions::DoJsonEncode()
     * 
     * @param bool $a
     * @return
     */
    function DoJsonEncode($a=false)
    {
        if(function_exists('json_encode')) {
            return json_encode($a);
        } else {
            include 'class.services.json.php';
            
            // create a new instance of Services_JSON
            $json = new Services_JSON();
            return $json->encode($a, 0);
        }
    }

    /**
     * Misc_Functions::ValidateEmail()
     * 
     * @param mixed $value
     * @return
     */
    function ValidateEmail($value)
    {
        $regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';

        if($value == '') { 
	        return false;
        } else {
            $string = preg_replace($regex, '', $value);
        }

        return empty($string) ? true : false;
    }

    /**
     * Misc_Functions::ShowErrors()
     * 
     * @param mixed $errors_notice
     * @param mixed $errors_list
     * @return
     */
    function ShowErrors($errors_notice, $errors_list = array()) {
        
        $errors_output = stripslashes($this->acf_config['notifications']['errors_output']);
        
        $errors_output = str_replace('\"', '"', $errors_output);
        $errors_output = str_replace("\'", "'", $errors_output);    
                        
        $errors_output = preg_replace('|{errors_notice}|Ui', $errors_notice, $errors_output);
        $errors_output = preg_replace(array('|{errors_zone}|Ui', '|{/errors_zone}|Ui'), '', $errors_output);
        
        //echo $errors_output;
        
        if( ! empty($errors_list) ) {
            
            //echo '<pre>'; print_r($errors_list); echo '</pre>';
            
            preg_match_all("|{loop}(.*){/loop}|iU", $errors_output, $out, PREG_PATTERN_ORDER);
            
            //echo $errors_output; echo '<pre>'; print_r($out); echo '</pre>';
            
            $errors_string_html = '';
           
            foreach($errors_list as $value) {
            
                // Replace {error} with the actual error       
                $patterns     = array('/{error}/i');
                $replacements = array(stripslashes($value));
                
                $errors_string_html .= preg_replace($patterns, $replacements, $out[1][0]);
            }        
            
            $errors_output = preg_replace('|'.$out[0][0].'|Ui', $errors_string_html, $errors_output);
        }
        
        //echo $errors_output;
        
        return $errors_output;
    }

    /**
     * Misc_Functions::ShowSuccess()
     * 
     * @param mixed $success_notice
     * @return
     */
    function ShowSuccess($success_notice) {
        $success_output = $this->acf_config['notifications']['success_output'];
        
        $success_output = str_replace('\"', '"', $success_output);
        $success_output = str_replace("\'", "'", $success_output);
        
        return preg_replace('|{success_notice}|Ui', $success_notice, $success_output);
    }

    /**
     * Misc_Functions::ParseConfForJS()
     * 
     * @param mixed $acf_config
     * @return
     */
    function ParseConfForJS($acf_config) {
        foreach($acf_config['fields'] as $field_name => $value) {
            $acf_config['fields'][$field_name]['error']['none'] = str_replace("'", "\'", $value['error']['none']);
            $acf_config['fields'][$field_name]['error']['not_valid'] = str_replace("'", "\'", $value['error']['not_valid']);
        }
        
        $acf_config['captcha']['error']['none'] = str_replace("'", "\'", $acf_config['captcha']['error']['none']);
        $acf_config['captcha']['error']['not_valid'] = str_replace("'", "\'", $acf_config['captcha']['error']['not_valid']);
 
        foreach($acf_config['notifications'] as $key => $value) {
            $acf_config['notifications'][$key] = str_replace("'", "\'", $value);
        }
        
        return $acf_config;
    }

    
    /**
     * Misc_Functions::SetMessageValuesFromPost()
     * 
     * @param mixed $afb_form_fields
     * @return
     */
    function SetMessageValuesFromPost($afb_form_fields) {
        // Construct the 'replacements' vector that will be later used to replace {value} from the message with the actual values
        $afb_replacements = array();
        
        foreach($_POST as $afb_p_key => $afb_p_value) {
    
            //echo '<pre>'; print_r($afb_form_fields[$afb_p_key]); echo '</pre>';
    
            $afb_p_key = str_replace('[]','', $afb_p_key);
            
            // 1) Set the replacement value

	        # For Checkboxes, Multiple Selects
	        if( ($afb_form_fields[$afb_p_key]['type'] == 'checkboxes' && isset($afb_form_fields[$afb_p_key]['options']) && is_array($afb_form_fields[$afb_p_key]['options']) )
                || ( $afb_form_fields[$afb_p_key]['type'] == 'select' && $afb_form_fields[$afb_p_key]['multiple'] == 1 ) ) {

                $selectValues = '';

                foreach($afb_p_value as $selectValue) {
                    $selectValues .= $afb_form_fields[$afb_p_key]['options'][$selectValue].', ';
                }
                
                $replacement = substr($selectValues, 0, -2);
	                
            # Selects (Single), Radios
	        } else if(is_array($afb_form_fields[$afb_p_key]['options']) && $afb_form_fields[$afb_p_key]['multiple'] != 1) {
	            
                $replacement = $afb_form_fields[$afb_p_key]['options'][$afb_p_value];
                
	        # For Inputs, Textareas
	        } else {
                $replacement = $afb_p_value;	
    	    }
                        
            // 2) Do the actual replace
            
            $afb_replacements['{'.$afb_p_key.'}'] = $replacement;
        }
        
        return $afb_replacements;        
    }
    
    function GetTotalRequiredInputs($form_fields) {
        // Determine total required inputs
        $total_required_inputs = ($this->acf_config['captcha']['enabled'] == 1) ? 1 : 0;
                
        foreach($form_fields as $value) {
            if( ($value['enabled'] == 1) && ($value['required'] == 1) ) {
                $total_required_inputs++;
            }
        }
        
        return $total_required_inputs;
    }
    
    function addslashesFields( $input ) {
        if ( is_array( $input ) ) {
            return array_map( array($this, 'addslashesFields'), $input );
        } else {
            return addslashes( $input );
        }
    }      
}
?>