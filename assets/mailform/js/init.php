<?php
$path_to_contact_app = dirname(dirname(__FILE__));

include $path_to_contact_app.'/common.php';

$acf_config = $func->ParseConfForJS($acf_config);

header("Content-type: application/x-javascript");
?>
/* 
Author: Gabriel Comarita
Author's Website: http://www.bitrepository.com/

Copyright (c) BitRepository.com
*/

jQuery(document).ready(function($) {
    
    resize_frame();    

    $('#acf_submit_button').before('<div id="acf_place_for_security_code"></div>');
        
    $('#acf').submit(function() {
        
        <?php
        if($acf_config['realtime_validator'] == 1) {
            
            define('JS_LOADED', 1);
            
            $total_required_fields = $func->GetTotalRequiredInputs($acf_config['fields']);
            
            foreach($acf_config['fields'] as $field_name => $value) {
                if($value['enabled'] == 1 && $value['required'] == 1) {
                ?>
                check_acf_<?php echo $field_name; ?>('', 'none', '1');
                <?php
                }
            }
        
        ?>   

        <?php
        if($acf_config['captcha']['enabled'] == 1) {
        ?>
            check_acf_security_code('slide');
        <?php
        }
        ?>
        
        if($(".acf_ok").length < <?php echo $total_required_fields; ?>) {
            return false;
        }
        
        <?php
        }
        ?>
            
        $('html, body').animate({ scrollTop:$("#acf_wrap").offset().top - 10}, 500, function() {
            acf_check_status();
        });
                                        
        $('#acf_submit_button').hide();
        $('#acf_ajax_loading').show();   
        
        var formData = $(this).serialize(); 
                
        $.ajax( {
            type: 'POST',
            url: acf_config_path.parse_file,
            data: formData,
                                     
            success: function(response) {
                
                <?php
                if($acf_config['debug'] == 1) {
                ?>
                    $('#acf_note').after('<div class="acf_debug"><strong>Debug mode</strong><br /><p>'+ response +'</p></div>')
                <?php
                }
                ?>
 
                var possible_error = 'Could not instantiate mail function.';

	            if(response.search(possible_error) != '-1') {
	                var result = '<div class="notification_error"><?php echo $acf_config['notifications']['mail_cannot_be_sent_e']; ?><br /><br />'+ possible_error +'</div>';
                    $("#acf_fields").hide();
                } else {
        
                    responseObj = $.parseJSON(response);

	                var status = responseObj.status;
                    var result = responseObj.status_output;
            
                    if(status == 0) { 
                      <?php
                      if($acf_config['thank_you_redirect']['enabled'] == 0) {  
                      ?>
                          $('#acf_success_sent').val(1);
                          $('#acf_fields').hide();
                          
                          <?php
                          # PLEASE KEEP THE FOLLOWING LINE INTACT FOR LEGAL USE. THE NOTICE APPEARS AFTER SUCCESFUL FORM SUBMIT.
                          ?>
                          $('#acf_wrap').append('<div class="acf_powered_by"><?php echo $acf_powered_by; ?></div>');
                      <?php
                      } else { // Redirect to 'Thank You' page (it must be set in common.php)
                      ?>
                          window.location.replace("<?php echo $acf_config['thank_you_redirect']['url']; ?>");
                          return false;
                      <?php
                      }
                      ?>
                    } 
                    else if(status == 1) { // Were errors found?
                        
                        <?php
                        foreach($acf_config['fields'] as $field_name => $value) {
                            if($value['enabled'] == 1 && $value['required'] == 1) {
                            ?>
                                if(responseObj.<?php echo $field_name; ?>) {
                                    $('#acf_<?php echo $field_name; ?>').addClass('acf_error').removeClass('acf_ok');
                                } else {
                                    $('#acf_<?php echo $field_name; ?>').addClass('acf_ok').removeClass('acf_error')
                                }
                            <?php
                            }
                        }
                        ?>
				                                                                                    
                        if(responseObj.security_code) { 
                        
                            $('#acf_security_code').addClass('acf_error').removeClass('acf_ok');
                        
                        } else {
                
                            var validCode = $('#acf_security_code').val();

                          $('#acf_sc_error').remove();
            
                          $('#acf_security_code').blur().remove();
    					   
    					  $('#acf_captcha_div').hide(); 
    					  $('#acf_main_sec_div').hide(); 					  
    
                          $('#acf_sec_div_two').fadeIn('fast', function() {  
                          
                          $('#acf_place_for_security_code').html('<input class="acf_ok" type="hidden" name="security_code" id="acf_security_code" value="'+ validCode +'" />');
                                      						     
						  });
            					  
			              $('div').removeClass("acf_highlighted");
                        }
                    
                    } else if(status == 2) {
                        $("#acf_fields").hide();                         
                    }
                }
                
	            $('#acf_ajax_loading').hide();

	            $('#acf_submit_button').show();

			    $('html, body').animate({scrollTop: $("#acf_wrap").offset().top - 10}, 500, function() {
			        $('#acf_note').html(result).slideDown('fast', function() {
		                resize_frame(); 
			        });
			    });   
            }
        });
        
        return false; 

    });

    <?php
    if($acf_config['realtime_validator'] == 1) {        
        include 'realtime.validator.php';
    }
    
    if($acf_config['captcha']['enabled'] == 1) {
    ?>
        $('#acf_captcha_refresh').bind('click', function() {
            
            var c_currentTime = new Date();
            var c_miliseconds = c_currentTime.getTime();
            
            document.getElementById('acf_captcha').src = acf_config_path.contact_app + 'captcha.php?x='+ c_miliseconds;
            $('#acf_security_code').val('');
            
            return false;
        });
            
        $('#acf_captcha_refresh').show();
    <?php
    }
    ?>
    
    $('.wrap input, .wrap textarea').focusin(function() { $(this).closest('div.wrap').addClass("acf_highlighted"); }).focusout(function() { $(this).closest('div.wrap').removeClass("acf_highlighted"); });                           

});

    function do_resize_iframe() {
        var parentIframe = parent.document.getElementById("acf_frame");
                 
        parentIframe.height = $("#acf_wrap").height() + 50;
        parentIframe.width = $("#acf_wrap").width() + 50;
    }
    
    function resize_frame(timing) {
        if(typeof(parent.document.getElementById("acf_frame")) !== 'undefined' && parent.document.getElementById("acf_frame") != null) {
            if (typeof timing == 'undefined') { timing = '500'; } 
            setTimeout(do_resize_iframe, timing);
        }
    }

    function acf_check_status() {
    
        if($('#acf_success_sent').val() == 1) { 
            $('#acf_note').slideUp('slow');
            
            $('#acf_note').html('');
            
            $('#acf_success_sent').val(0); 
            return true; 
        } 
        
        if($("div.acf_error").length > 0) { 
            $('#acf_note').html('<div class="notification_error"><?php echo $acf_config['notifications']['correct_errors_e']; ?></div>').slideDown('slow');
        }
        
        if($("div.acf_error").length == 0) { 
        	$('#acf_note').slideUp('slow'); 
        }
        resize_frame();
        
        return true;
    };

    function remove_errors(keyField, mode) {
        
        var selector = $('div[id^="'+ keyField +'_error"]');
        
        if(mode == 'no_slide') {
            selector.remove();
        } else {
            selector.slideUp('fast', function() { $(this).remove(); });   
        }
    }

img1 = new Image(18, 15);
img1.src = acf_config_path.images + 'icon-ajax-loader.gif';

img2 = new Image(22, 22);
img2.src = acf_config_path.images + 'icon-dialog-error.png';

img3 = new Image(22, 22);
img3.src = acf_config_path.images + 'icon-button-ok.png';