<?php
error_reporting (E_ALL ^ E_NOTICE);

include 'classes/class.misc.functions.php';
$func = new Misc_Functions;

$acf_config = array();

// To (here you should enter the e-mail address where you should receive the messages)
$acf_config['webmaster_email'] = 'dernaechsteregen@hotmail.de';

// your name/nickname
$acf_config['webmaster_name'] = 'Frank Lipp';

// Enable AutoResponder (true or false)
// Note that the 'Auto Responder' will work if you use the fields 'name' & 'email' (which should belong to the person filling the form) (here, the auto responder mail has to be sent)
$acf_config['auto_responder'] = true;

$acf_config['realtime_validator'] = true;

$acf_config['fields'] = array(

    'name' => array(
        'title' => 'Name *',
        'enabled' => 1,
        'required' => 1,
        'type' => 'input',
        'validation' => array('basic' => array('value' => true, 'message' => 'Please fill your name.')),
    ),
    
    'email' => array(
        'title' => 'E-Mail *',
        'enabled' => 1,
        'required' => 1,
        'type' => 'input',
        'validation' => array('basic' => array('value' => true, 'message' => 'Please fill your e-mail address.'),
                              'email' => array('value' => true, 'message' => 'The e-mail address is not valid.'))
    ),

    'phone' => array(
        'title' => 'Phone',
        'enabled' => 1,
        'required' => 0,
        'type' => 'input',
        'validation' => array('basic' => array('value' => true, 'message' => 'Please fill your phone number.'),
                              'numeric' => array('value' => true, 'message' => 'The phone number should have a numeric value.'))
    ),
                     
    'subject' => array(
        'title' => 'Subject',
        'enabled' => 0,
        'required' => 1,
        'type' => 'input',
        'validation' => array('basic' => array('value' => true, 'message' => 'Please fill the subject')),
    ),

    'message' => array(
        'title' => 'Message *',
        'enabled' => 1,
        'required' => 1,
        'type' => 'textarea',
        'validation' => array('basic' => array('value' => true, 'message' => 'Please fill the message'),
                              'min_chars' => array('value' => 15, 'message' => 'The message should have at least 15 characters.')),
    ),
);

// If enabled the following custom value will be used as the mail subject (instead of the 'subject' field as it is now)
$acf_config['custom_subject'] = array('enabled' => 1, 'text' => 'Message from mallorca-luxury.com');

$acf_config['captcha'] = array(
    'enabled' => 1,
    
    'chars_number' => 5,
    'string_type'  => 3, // 1 = letters, 2 = numbers, 3 = letters & numbers
    
    'font_size'    => 14,
    
    'text_color'       => 'bf7878',
    'background_color' => 'ffffff',

    'font' => 'verdana.ttf',
     
    'width'  => 126,
    'height' => 31,
);

$acf_config['smtp'] = array(
    'enabled' => 0, // If you enable STMP, the following values will be used (make sure you fill them (where it is necessary) if it is set to '1')
    'auth'    => 1, // Enable SMTP Authentication?
    
    'secure'  => 'ssl', // Sets the prefix to the server (e.g. SSL)
    
    'host'    => 'smtp.gmail.com', // e.g. smtp.gmail.com
    
    'port'    => 465, // e.g. 465 (for Gmail)
    
    'username' => '', // e.g. yourname@gmail.com
    'password' => '' 
);

$acf_config['notifications'] = array(
    
    'success_output'        => '<div class="notification_ok">{success_notice}</div>',
    
    'message_sent_s'        => 'The message has been successfully sent. Thank you for writing to us!',
    
    'mail_cannot_be_sent_e' => 'The mail cannot be sent due to an internal error. Please retry later!',
    
    'correct_errors_e'      => 'Please fill the missing or wrong fields and re-submit the form!',
        
    'errors_output'         => '<div class="notification_error">        
                                {errors_notice}
                                          {errors_zone}    <br> <br>
                                {loop} {error} <br> {/loop}      
                                 {/errors_zone}</div>',
    
    'security_code_e'       => 'Please enter the security code',
    'security_code_i_e'     => 'The security code is incorrect.',
    'security_code_e_re'    => 'The security code has been re-generated.'
);

$acf_config['debug'] = false;

// Redirect to thank you page
$acf_config['thank_you_redirect'] = array(
    'enabled' => 0, // 1 - enabled; 0; disabled
    'url' => '' // the URL to the thank you page here
);

/* If used, {name} is replaced with the value of 'sender_name' from the contact form ;-) */

/*
----- AutoResponder Mail Subject -----
*/
define('AR_SUBJECT', 'Thank you for contacting us');

/*
----- Customize AutoResponder Mail Message -----
*/

// html version

define('AR_MESSAGE', "Greetings <strong>{name}</strong>,<br /><br />

This is an automated mail sent to notify you that we have received your message. We will give you a reply as soon as possible.<br /><br />

Best Regards");

// non-html version

define('AR_MESSAGE_TEXT', "Greetings {name},

This is an automated mail sent to notify you that we have received your message. We will give you a reply as soon as possible.

Best Regards");

/*
----- The actual message you will receive to your WEBMASTER_EMAIL address -----
*/

// html version

define('BODY_MESSAGE', "{name} just sent you a message through the contact form:<br /><br />

IP: {ip_address} ({hostname})<br /><br />

{ALL_FIELDS}");

/* 
Gets local path to the form script (example: /home/mysite.com/public_html/contactForm/) 

To set it manually, just change the value of this variable
*/

$localPath = substr($_SERVER['SCRIPT_FILENAME'], 0, -strlen(substr(strrchr($_SERVER['SCRIPT_FILENAME'], '/'), 1)));

$urlPath = $func->getURLtoFormDir();
$path_to_contact_app = $urlPath.'assets/mailform/';

$acf_config['path'] = array(
    'form' => $urlPath,
    'contact_app' => $path_to_contact_app,
    'parse_file' => $path_to_contact_app.'parse.php',
    'images' => $path_to_contact_app.'images/'
);

$acf_config_json = $func->DoJsonEncode($acf_config);

$func->acf_config = $acf_config;

$showForm = true;

if($acf_config['webmaster_email'] == '') {
	echo "<p>Before using the form, please add the e-mail address that will be used to receive the messages. To do this, go to <em>contact-app/common.php</em> and edit line 10 (see given example below):</p>
	
	<pre style='color:#000000;background:#ffffff;'>
	<span style='color:#696969; background:#ffffe8; '>// To (here you should enter the e-mail address where you should receive the messages)</span><span style='color:#000000; background:#ffffe8; '></span>
	<span style='color:#797997; background:#ffffe8; '>".'$acf_config'."</span><span style='color:#808030; background:#ffffe8; '>[</span><span style='color:#0000e6; background:#ffffe8; '>'webmaster_email'</span><span style='color:#808030; background:#ffffe8; '>]</span><span style='color:#000000; background:#ffffe8; '> </span><span style='color:#808030; background:#ffffe8; '>=</span><span style='color:#000000; background:#ffffe8; '> </span><span style='color:#0000e6; background:#ffffe8; '>'yourname@yourdomain.com'</span><span style='color:#800080; background:#ffffe8; '>;</span><span style='color:#000000; background:#ffffe8; '></span>
	</pre>

	<p>PS: Once you're done, this message will not show anymore.</p>";

	$showForm = false;
}

$acf_config['fields'] = $func->addslashesFields($acf_config['fields']);

$unique_id = md5(uniqid());

// This script is free for both personal and commercial projects. You are only required to keep the following notice. It will appear after someone successfully submitted the form.
$acf_powered_by = 'Powered by <a href="http://www.bitrepository.com/a-simple-ajax-contact-form-with-php-validation.html">AJAX Contact Form</a>';
?>