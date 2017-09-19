<?php
/*
Credits: Gabriel Comarita (BitRepository.com)
URL: http://www.bitrepository.com/
*/

$isAjaxUsed = ( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) ? true : false;

if ($isAjaxUsed) {
    include_once 'headers.php';
    include_once 'common.php';
}

include_once 'classes/php.mailer/class.phpmailer.php';

// Was the method "POST" used? Continue
if(!empty($_POST)) {
    $error = array();
    $errors_list = array();
    $replacements = array();

    include_once 'classes/class.validation.php';
    
    $validate = new Validation;

    foreach($acf_config['fields'] as $field_name => $acf_value) {
        $field_name = str_replace('[]','', $field_name);
                
        //echo $acf_value['enabled'];
        
        if($acf_value['enabled'] == 1) {
            
            $response_type = $validate->DoValidate($_POST[$field_name], $acf_value['validation']);
                                    
            if( isSet($acf_value['validation'][$response_type]['message']) ) {
                
                $error[$field_name] = 1;
                
                $errors_list[] = str_replace('['.$response_type.']', 
                                             $acf_value['validation'][$response_type]['value'], 
                                             $acf_value['validation'][$response_type]['message']);
            }
        }
    }
    
    //echo '<pre>'; print_r($errors_list); echo '</pre>';
    
    //exit;

    # Check Security Code
    if($acf_config['captcha']['enabled'] == 1) {
        // Security Code submitted by the user
        $afb_security_code = strtolower($_POST['security_code']);
        
        // Was any security code entered?
        if($afb_security_code == '') {

            $error['security_code'] = 1;
            
            $errors_list[] = $acf_config['notifications']['security_code_e'];
        
        // Compare the security codes
        } else {

            $afb_token = ($_SESSION['acf_captcha_security_code'] == '') ? $_COOKIE['acf_captcha_security_code'] : $_SESSION['acf_captcha_security_code'];
                                                                                  
            if(md5($afb_security_code) != $afb_token) {
                $error['security_code'] = 2;
                
                $errors_list[] = $acf_config['notifications']['security_code_i_e'];
            }
        }
    }

    if(empty($error)) {
        
        $mail = new PHPMailer(); // defaults to using php "mail()"
        
        $mail->CharSet = 'utf-8';

        if($acf_config['smtp']['enabled'] == 1) {

            $mail->IsSMTP();                                      // telling the class to use SMTP

            if($acf_config['smtp']['auth']) {
                $mail->SMTPAuth   = true;                           // enable SMTP authentication
            }

            $mail->SMTPSecure = $acf_config['smtp']['secure'];        // sets the prefix to the server

            $mail->Host       = $acf_config['smtp']['host'];        // sets the SMTP server
            $mail->Port       = $acf_config['smtp']['port'];        // set the SMTP port for the GMAIL server
            $mail->Username   = $acf_config['smtp']['username'];    // SMTP account username
            $mail->Password   = $acf_config['smtp']['password'];    // SMTP account password

        }
        
        $mail->From       = ($_POST['email']) ? $_POST['email'] : '';
        $mail->FromName   = ($_POST['name']) ? $_POST['name'] : ''; 
        
        $mail->AddAddress($acf_config['webmaster_email'], $acf_config['webmaster_name']);
        
        // Set the message
        $final_message = BODY_MESSAGE;
        $final_message_text = strip_tags(preg_replace('#<br\s*/?>#i', "\n", $final_message));
        
        $ip_address = $func->getRealIpAddr();
        
        $ar_subject = AR_SUBJECT;
        $ar_message = AR_MESSAGE;
        $ar_message_text = strip_tags(preg_replace('#<br\s*/?>#i', "\n", $ar_message));                              

        $replacements = $func->SetMessageValuesFromPost($acf_config['fields']);
                              
        $replacements['{hostname}'] = gethostbyaddr($ip_address);
        $replacements['{ip_address}'] = $ip_address;

        // Make the necessary replacements        
        $in = compact('sender_subject', 'ar_subject', 'final_message', 'ar_message');
        extract( str_replace(array_keys($replacements), array_values($replacements), $in) );

        // Is the body message containing {ALL_FIELDS}? Then replace it with the submitted form input values

        if(strpos($final_message, '{ALL_FIELDS}') !== false) {

            $ALL_FIELDS = "<table>";

            foreach(array_keys($_POST) as $acf_key) {
                
	            $acf_key = str_replace('[]','', $acf_key);
                
                $title = $acf_config['fields'][$acf_key]['title'];

	            if($title) {
                    $ALL_FIELDS .= '<tr><td valign="top"><strong>'.$title.":</strong>&nbsp;&nbsp;</td><td>".nl2br($replacements['{'.$acf_key.'}'])."</td></tr>";
                }
            }

            $ALL_FIELDS .= "</table>";

            $final_message = str_replace('{ALL_FIELDS}', $ALL_FIELDS, $final_message);
        }
        
        if($acf_config['custom_subject']['enabled'] == 1) {
            $subject = $acf_config['custom_subject']['text'];
        }
        
        $mail->Subject = $subject;
        $mail->MsgHTML($final_message);
        $mail->AltBody = $final_message_text;
        
        /* --- Send the mail --- */
        
        if($mail->Send()) {
            
            $error['status'] = 0; // Mail sent
            $error['status_output'] = $func->ShowSuccess($acf_config['notifications']['message_sent_s']);
            
            $mail->ClearAddresses();
            
            if($acf_config['auto_responder'] == 1 && $email && $name) {
                $mail->From     = $acf_config['webmaster_email'];
                $mail->FromName = $acf_config['webmaster_name'];
                
                $mail->Subject  = $ar_subject;
                
                $mail->Body     = $ar_message;
                $mail->AltBody  = $ar_message_text;
                
                $mail->AddAddress($email, $name);
        
                // Send auto responder only if the message was sent
                $mail->Send();
            }
        } else {
            $error['status'] = 2; // Mail cannot be sent (internal error)
            $error['status_output'] = $func->ShowErrors($acf_config['notifications']['mail_cannot_be_sent_e']);
        }
    } else {
        $error['status'] = 1; // Errors found
        $error['status_output'] = $func->ShowErrors($acf_config['notifications']['correct_errors_e'], $errors_list);
    }

        
    /*
    ----------------------------------------------------------------------------------------
    Output JSON data for AJAX calls and set the $form_status variable for non-AJAX calls
    ----------------------------------------------------------------------------------------
    */    

    // Is (AJAX) JavaScript Enabled? (note that around 3% of the users have JS disabled)

    if($isAjaxUsed) {
          
        echo $func->DoJsonEncode($error); // output the result that will be processed by afp.init.php (via AJAX call)

    } else { // Action if JavaScript is disabled
      
        // If errors were found and the user has JS disabled, the security code is re-generated
        if( ! empty($errors_list) ) {      
            if($acf_config['captcha']['enabled'] == 1) {
                $errors_list[] = $acf_config['notifications']['security_code_e_re'];
            }
        }
        
        if(empty($errors_list)) { // No errors?
        
            if($afb_error['status'] == 0) { // Mail sent
        
                $acf_success_submit = 1;
        
                $form_status = $func->ShowSuccess($acf_config['notifications']['message_sent_s']);
        
            } elseif($afb_error['status'] == 2) { // Mail not sent due to internal error (usually happens when the script is tested on localhost)
              
                $form_status = $func->ShowErrors($acf_config['notifications']['mail_cannot_be_sent_e']); // Mail cannot be sent (internal error)
            }
               
        } else { // Show errors
            $form_status = $func->ShowErrors($acf_config['notifications']['correct_errors_e'], $errors_list); // Errors found
        }
    }
}
?>