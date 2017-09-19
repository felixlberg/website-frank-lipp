<?php
error_reporting (E_ALL ^ E_NOTICE);

include 'headers.php';

if(isSet($_POST['security_code'])) {

    $to_check = md5( strtolower(trim($_POST['security_code'])) );
    $token = ($_SESSION['acf_captcha_security_code'] == '') ? $_COOKIE['acf_captcha_security_code'] : $_SESSION['acf_captcha_security_code'];
    
    echo ( ($to_check == $token) ? 1 : '' ); 
}
?>