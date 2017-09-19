<?php
include_once 'headers.php';
include_once 'common.php';

if($acf_config['captcha']['enabled'] == 1) {
    
    include_once 'classes/class.captcha.php';
    
    $captcha = new Captcha();
    
    // Set CAPTCHA's Settings
    $captcha->charsNumber      = $acf_config['captcha']['chars_number'];
    $captcha->stringType       = $acf_config['captcha']['string_type'];
    $captcha->fontSize         = $acf_config['captcha']['font_size'];
    
    $captcha->textColor        = $func->html2rgb($acf_config['captcha']['text_color']);
    $captcha->backgroundColor  = $func->html2rgb($acf_config['captcha']['background_color']);
    
    $captcha->ttFont           = 'fonts/'.$acf_config['captcha']['font'];
    
    // Output the CAPTCHA
    $captcha->ShowImage('acf', $acf_config['captcha']['width'], $acf_config['captcha']['height']);
}
?>