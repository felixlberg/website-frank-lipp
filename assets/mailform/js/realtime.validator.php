 <?php
 if(!defined('JS_LOADED')) {
    exit;
 }
 
foreach($acf_config['fields'] as $field_name => $value) {
    if($value['enabled'] == 1 && $value['required'] == 1) {  
    ?>
 var check_acf_<?php echo $field_name; ?> = function(event, show_type, is_submit) {

        var forSlideStyle = (show_type == 'slide') ? 'style="display:none;"' : '';
    
        <?php
        // Basic Validation
        if( $value['validation']['basic']['value'] == 1 && ( !is_array($value['options']) || ($value['type'] == 'select') ) ) {
        ?>
            if($('#acf_<?php echo $field_name; ?>').val() == '') {
        
                remove_errors('acf_<?php echo $field_name; ?>', 'no_slide');
            
                var afterField = '<div '+ forSlideStyle +' id="acf_<?php echo $field_name; ?>_error" class="acf_error"><?php echo $value['validation']['basic']['message']; ?></div>';
            
                $('#acf_<?php echo $field_name; ?>').removeClass('acf_ok').after(afterField); 
            
                if(forSlideStyle) {
                    $('#acf_<?php echo $field_name; ?>_error').slideDown('fast');
                }
            
                acf_check_status();
            
                return false;
            }
        <?php
        }
        
        // E-Mail Validation
        if($value['validation']['email']['value'] == 1) {
        ?>
            var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i; 
                
            if (!filter.test($('#acf_<?php echo $field_name; ?>').val())) {
        
                remove_errors('acf_<?php echo $field_name; ?>', 'no_slide');
        
                var afterField = '<div '+ forSlideStyle +' id="acf_<?php echo $field_name; ?>_error_invalid" class="acf_error"><?php echo $value['validation']['email']['message']; ?></div>';
        
                $('#acf_<?php echo $field_name; ?>').removeClass('acf_ok').after(afterField); 
        
                if(forSlideStyle) {
                    $('#acf_<?php echo $field_name; ?>_error_invalid').slideDown('fast');
                }
                acf_check_status();
        
                return false;
            }        
        <?php
        }
        
        // Numeric Validation
        if($value['validation']['numeric']['value'] == 1) {       
        ?>
            // Check if the input value is a numeric one
            if ( ! jQuery.isNumeric($('#acf_<?php echo $field_name; ?>').val()) ) {
        
                remove_errors('acf_<?php echo $field_name; ?>', 'no_slide');
        
                var afterField = '<div '+ forSlideStyle +' id="acf_<?php echo $field_name; ?>_error_invalid" class="acf_error"><?php echo $value['validation']['numeric']['message']; ?></div>';
        
                $('#acf_<?php echo $field_name; ?>').removeClass('acf_ok').after(afterField); 
        
                if(forSlideStyle) {
                    $('#acf_<?php echo $field_name; ?>_error_invalid').slideDown('fast');
                }
                acf_check_status();
        
                return false;
            }
        <?php
        }
        
        // Minimum Characters Validation        
        if($value['validation']['min_chars']['value'] > 0) {        
        ?>
            if($('#acf_<?php echo $field_name; ?>').val().length < <?php echo $value['validation']['min_chars']['value']; ?>) { 
        
                remove_errors('acf_<?php echo $field_name; ?>', 'no_slide');
        
                var afterField = '<div '+ forSlideStyle +' id="acf_<?php echo $field_name; ?>_error_min_chars" class="acf_error"><?php echo $value['validation']['min_chars']['message']; ?></div>';
        
                $('#acf_<?php echo $field_name; ?>').removeClass('acf_ok').after(afterField); 
        
                if(forSlideStyle) {
                    $('#acf_<?php echo $field_name; ?>_error_min_chars').slideDown('fast');
                }
                acf_check_status();
                return false;
            }
        <?php
        }

        // Minimum Selections Validation (Checkboxes)
        if( $value['validation']['min_selections']['value'] > 0 && is_array($value['options']) ) {    
        ?>
            var checkbox_area_selector = $('#acf_<?php echo $field_name; ?>');
            var total_valid_selections = checkbox_area_selector.find('input[type=checkbox]:checked').length;
        
            if(is_submit === undefined) {
                if(total_valid_selections < <?php echo $value['validation']['min_selections']['value']; ?> && total_valid_selections > 0) {
                    checkbox_area_selector.removeClass('acf_ok');
                    return false;
                }
            }
        
            if(total_valid_selections < <?php echo $value['validation']['min_selections']['value']; ?>) {
        
                remove_errors('acf_<?php echo $field_name; ?>', 'no_slide');
        
                var afterField = '<div '+ forSlideStyle +' id="acf_<?php echo $field_name; ?>_error" class="acf_error"><?php echo $value['validation']['min_selections']['message']; ?></div>';
        
                $('#acf_<?php echo $field_name; ?>').removeClass('acf_ok').after(afterField); 
        
                if(forSlideStyle) {
                    $('#acf_<?php echo $field_name; ?>_error').slideDown('fast');
                }
                acf_check_status();
        
                return false;
            }
        <?php
        }

        // Radio Selection
        if( isset($value['options']) && is_array($value['options']) && $value['validation']['basic']['value'] == 1 && $value['type'] != 'select' ) {    
        ?>
            var radios_length = $('#acf_<?php echo $field_name; ?>').find('input[type=radio]:checked').length;
                                    
            //console.log(radios_length);

            if(radios_length == 0) {
                            
                remove_errors('acf_<?php echo $field_name; ?>', 'no_slide');
            
                var afterField = '<div '+ forSlideStyle +' id="acf_<?php echo $field_name; ?>_error" class="acf_error"><?php echo $value['validation']['basic']['message']; ?></div>';
            
                $('#acf_<?php echo $field_name; ?>').removeClass('afb_ok').after(afterField); 
            
                if(forSlideStyle) {
                    $('#acf_<?php echo $field_name; ?>_error').slideDown('fast');
                }
            
                acf_check_status();
            
                return false;
                
            }
        <?php
        }
        
        // Minimum Selections Validation (Multiple Select Field)
        if($value['multiple'] == 1) {
            $message = ($value['validation']['min_selections']['message']) ? $value['validation']['min_selections']['message'] : $value['validation']['basic']['message'];
            $min_selections = ($value['validation']['min_selections']['value'] > 0) ? $value['validation']['min_selections']['value'] : 1;
        ?>
                
        var total_selections_selector = $('#acf_<?php echo $field_name; ?> option:selected');
        var total_valid_selections = total_selections_selector.length;

        $(total_selections_selector).each(function() {
            if($(this).val() == '') { total_valid_selections--; }
        });
        
        if(is_submit === undefined) {
            if( event.type != 'focusout' && (total_valid_selections < 2) ) {
                $('#acf_<?php echo $field_name; ?>').removeClass('acf_ok');
                return false;
            }
        }
                                
        if(total_valid_selections < <?php echo $min_selections; ?>) { 
    
            remove_errors('acf_<?php echo $field_name; ?>', 'no_slide');
    
            var afterField = '<div '+ forSlideStyle +' id="acf_<?php echo $field_name; ?>_error_min_selections" class="acf_error"><?php echo $message; ?></div>';
    
            $('#acf_<?php echo $field_name; ?>').removeClass('acf_ok').after(afterField); 
    
            if(forSlideStyle) {
                $('#acf_<?php echo $field_name; ?>_error_min_selections').slideDown('fast');
            }
    
            acf_check_status();
    
            return false;
        }
        
        <?php
        }
        ?>

         else {
            remove_errors('acf_<?php echo $field_name; ?>');
    
            $('#acf_<?php echo $field_name; ?>').removeClass('acf_error').addClass('acf_ok');
        
            acf_check_status();
        }
    };
                  
    $('#acf_<?php echo $field_name; ?>').bind('change focusout', function(event) { 
        check_acf_<?php echo $field_name; ?>(event, 'slide'); 
        acf_check_status();
    });
                
    $('#acf_<?php echo $field_name; ?>').bind('blur', function(event) {
        if($('#acf_<?php echo $field_name; ?>').val()) { 
            check_acf_<?php echo $field_name; ?>(event, 'slide'); 
        } 
        acf_check_status();
        
        return false;
    });                                        
<?php
    }
}

// Code to show if CAPTCHA is enabled
if($acf_config['captcha']['enabled'] == 1) {
?>        
        var check_acf_security_code = function(show_type) {
        
        var forSlideStyle = (show_type == 'slide') ? 'style="display:none;"' : '';
        
        if ($('#acf_captcha_div').is(':visible')) {
        
            $('#acf_sc_error').remove();
            
            if($('#acf_security_code').val() == '') {
            
                remove_errors('acf_security_code', 'no_slide');
                
                
                var afterField = '<div '+ forSlideStyle +' id="acf_sc_error" class="acf_error"><?php echo $acf_config['notifications']['security_code_e']; ?></div>';
                
                $('#acf_captcha_div').after(afterField); 
                
                
                if(forSlideStyle) {              
                    $('#acf_sc_error').slideDown('fast');
                }
                
                acf_check_status();
                
            } else {
            
                var c_currentTime = new Date();
                var c_miliseconds = c_currentTime.getTime();
                
                var validCode = $('#acf_security_code').val();
        
                /* [Start] AJAX Call */
                                
                $.ajax({ url: acf_config_path.contact_app + 'verify-code.php?x='+ c_miliseconds, 
                data: "security_code="+ validCode,
                type: 'post', 
                datatype: 'html', 
                success: function(outData) { 
                
                    if(outData != 1) {
                        
                        if($("#acf_sc_error.acf_error").length == 0) {
                        
                            $('#acf_security_code').addClass('acf_error').removeClass('acf_ok');
                        
                        	if(show_type == 'none') {
                            
                        	    $('#acf_captcha_div').after('<div id="acf_sc_error" class="acf_error"><?php echo $acf_config['notifications']['security_code_i_e']; ?></div>');
                        	
                        	} else if(show_type == 'slide') {
                        	
                        	    $('#acf_captcha_div').after('<div style="display:none;" id="acf_sc_error" class="acf_error"><?php echo $acf_config['notifications']['security_code_i_e']; ?></div>');      
                        	    $('#acf_sc_error').slideDown('fast');
                        
                        	}
                        	acf_check_status();
                        }
                    } else {
                        
                        $('#acf_security_code').blur().remove();
                        
                        $('#acf_captcha_div').hide(); 
                        $('#acf_main_sec_div').hide(); 
                        
                        $('#acf_sec_div_two').fadeIn('fast', function() { 
                            $('#acf_place_for_security_code').html('<input class="acf_ok" type="hidden" name="security_code" id="acf_security_code" value="'+ validCode +'" />'); 
                        });
                    }
                }, 
                              
                error: function(errorMsg) { alert('Error occured: ' + errorMsg); }});
                /* [End] AJAX Call */
                }
                
                }
                
                return false;
                
                };
                
            var check_acf_SecurityCodeLive = function() {
                                
            var c_currentTime = new Date();
            var c_miliseconds = c_currentTime.getTime();
            
            var validCode = $('#acf_security_code').val();
            
            /* [Start] AJAX Call */
            
            $.ajax({ url: acf_config_path.contact_app + 'verify-code.php?x='+ c_miliseconds, 
            data: "security_code="+ validCode,
            type: 'post', 
            datatype: 'html', 
            success: function(outData) { 
            
                if(outData == 1) { 
                    $('#acf_sc_error').remove();
                    
                    $('#acf_security_code').blur().remove();
                    
                    $('#acf_captcha_div').hide(); 
                    $('#acf_main_sec_div').hide(); 					  
                    
                    $('#acf_sec_div_two').fadeIn('fast', function() {  
                      $('#acf_place_for_security_code').html('<input class="acf_ok" type="hidden" name="security_code" id="acf_security_code" value="'+ validCode +'" />');
                    });
                    
                    $('div').removeClass("acf_highlighted");
                    
                    acf_check_status();
                }	  
            }, 
            
                error: function(errorMsg) { alert('Error occured: ' + errorMsg); }});
            /* [End] AJAX Call */
            };
            
            var check_acf_SecurityCodeIfNotNULL = function() {
                if($('#acf_security_code').val()) { check_acf_security_code('slide'); }
            };
            
            $('#acf_security_code').bind({
                change: function() {
                    check_acf_security_code('slide');
                },
                blur: function() {
                    check_acf_SecurityCodeIfNotNULL();
                },
                keyup: function() {
                    check_acf_SecurityCodeLive();
                }
            });
            
<?php
}
?>                        