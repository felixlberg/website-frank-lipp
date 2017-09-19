<?php
/**
 * Validation
 * 
 * @package 
 * @author Gabriel Comarita
 * @copyright 2011
 * @version $Id$
 * @access public
 */
class Validation {
    
    /**
     * Validation::DoValidate()
     * 
     * @param mixed $value
     * @param mixed $validation
     * @return
     */
    function DoValidate($value, $validation) {
                
        if(array_key_exists('basic', $validation)) { 
            if( ! $this->ValidateBasic($value)) {
                return 'basic';
            }
	    }
        
        if(array_key_exists('email', $validation)) { 
            if( ! $this->ValidateEmail($value)) {
                return 'email';
            }
	    }    

        if(array_key_exists('numeric', $validation)) { 
            if( ! $this->ValidateNumber($value)) {
                return 'numeric';
            }
	    }

        if(array_key_exists('min_selections', $validation)) {             
            if( ! $this->ValidateMinSelections($value, $validation['min_selections']['value'])) {
                return 'min_selections';
            }
	    }
        
        if(array_key_exists('min_chars', $validation)) { 
            if( ! $this->ValidateMinChars($value, $validation['min_chars']['value'])) {
                return 'min_chars';
            }
	    }
        
        return true;
    }

    /**
     * Validation::ValidateBasic()
     * 
     * @param mixed $value
     * @return
     */
    function ValidateBasic($value) {
        if($value == '' || empty($value)) {
            return false;
        }
        return true;
    }
    
    /**
     * Validation::ValidateEmail()
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
     * Validation::ValidateMinSelections()
     * 
     * @param mixed $value
     * @param string $min_selections
     * @return
     */
    function ValidateMinSelections($value, $min_selections = '') {        
        if($min_selections > count($value)) {
            return false;
        }
        return true;
    }
    
    /**
     * Validation::ValidateMinChars()
     * 
     * @param mixed $value
     * @param string $min_chars
     * @return
     */
    function ValidateMinChars($value, $min_chars = '') {
        if(strlen($value) < $min_chars) { 
            return false;
        }
        return true;
    }
    
    /**
     * Validation::ValidateNumber()
     * 
     * @param mixed $value
     * @return
     */
    function ValidateNumber($value) {
        if( ! is_numeric($value) ) {
            return false;
        }
        return true;
    }
}
?>