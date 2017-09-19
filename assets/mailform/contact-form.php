<?php
if(isset($showForm)) {

	if(isset($_GET['hide_title'])) {
		$hide_title = ($_GET['hide_title'] == 1) ? true : false;
	} else {
		$hide_title = false;
	}

	/* 
	---------------------------------------------------------------------------------------------------------------------------------------------------------------
	NOTES:
	- This file should be included in the BODY section of the page where you want to integrate the AJAX Contact Form (see standalone.php to see how it was included)
	---------------------------------------------------------------------------------------------------------------------------------------------------------------
	*/

	if($showForm == 1) {
		
		if( ! empty($_POST) ) {
			include 'parse.php';
		}
		
		$form_status = (isset($form_status)) ? $form_status : '';
		$form_status_display = (isset($form_status)) ? 'style="display:block;"' : '';
	?>

		 <div id="acf_wrap">
		
		<?php
		if( ! $hide_title ) { // Show title if it's not hidden
		?>
			<p style="font-size: 0.7em"><i>* Required fields</i></p>
		<?php
		}
		?>
				<!-- [Ajax_Contact_Form] -->
		
		<a name="acf_anchor"></a>
		<div id="acf_note" class="acf_note" <?php echo $form_status_display; ?>><?php echo $form_status; ?></div>
		
		<?php
		if(!isset($acf_success_submit)) {
		?>
		
		<div id="acf_fields">
		
			<form id="acf" name="acf" method="post" action="#acf_anchor" enctype="">
			
				<?php
				$form_fields = $acf_config['fields'];
				
				foreach($form_fields as $field_name => $value) {
					 
					$enabled = $value['enabled'];
					$title = $value['title'];
					$type = $value['type'];
					$options = ( ! empty($value['options']) ) ? $value['options'] : array();
					$columns = ( isset($value['columns']) ) ? (int)$value['columns'] : 1;

					if($columns == 0) {
						$columns = 1;
					}
					
					if($enabled == 1) {
						?>
						<div class="wrap">
							<label class="field"><?php //echo $title; ?></label>
							<div>
								<?php
								// INPUT
								if($type == 'input') {
								?>
									<input class="text" type="text" placeholder="<?php echo $title; ?>" name="<?php echo $field_name; ?>" id="acf_<?php echo $field_name; ?>" value="<?php echo $_POST[$field_name]; ?>" />
								<?php
								// TEXTAREA
								} elseif($type == 'textarea') {
								?>
									<textarea rows="5" cols="35" placeholder="<?php echo $title; ?>" name="<?php echo $field_name; ?>" id="acf_<?php echo $field_name; ?>"><?php echo $_POST[$field_name]; ?></textarea>
								<?php
								// SELECT
								} elseif($type == 'select') {
									
									// Basic or Multiple?
									$addMultipleSign = ($value['multiple'] == 1) ? '[]' : '';
									?>
									<select <?php if($addMultipleSign != '') { echo 'multiple="multiple"'; } ?> name="<?php echo $field_name . $addMultipleSign; ?>" id="acf_<?php echo $field_name; ?>">
									<option value="">...</option>
										<?php
										foreach($value['options'] as $option_key => $option_text) {
											
											if($_POST[$field_name] == $option_key) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}

											if( $addMultipleSign == '' ) {
												$selected = ($_POST[$field_name] == $option_key) ? 'selected' : '';
											} else {
												$posted_value = is_array($_POST[$field_name]) ? $_POST[$field_name] : array();
												$selected = (in_array($option_key, $posted_value)) ? 'selected' : '';
											}
											
											echo '<option '.$selected.' value="'.$option_key.'">'.$option_text.'</option>';
										}
										?>
									</select>
									<?php
								// CHECKBOXES (with at least one option)
								} elseif($type == 'checkboxes' && !empty($options)) {          
									
									$key = $field_name;
					
									$checkboxes_area = '<div class="spacer" id="acf_'.$key.'"><div class="acf_checkboxes_area_col"><ul>';
									
									$afb_c_i = 1;
					
									$afb_column_one_num = ceil(count($options) / $columns);
									
									$c_array = array();
									
									for ($c_i = 1; $c_i <= $columns; $c_i++) { $c_array[] = ($afb_column_one_num * $c_i) + 1; }
									
									$posted_values = ($_POST[$field_name] != '') ? array_values($_POST[$field_name]) : array();
									
									foreach($options as $checkbox_key_value => $checkbox_value) {
									  
										if( in_array($afb_c_i, $c_array ) ) {
									
											$afb_is_split = true;
									
											$checkboxes_area .= '</ul></div>'."\n\n".'<div class="acf_checkboxes_area_col"><ul>'."\n";
										}
									
										$is_checked = in_array($checkbox_key_value, $posted_values) ? " checked='checked' " : '';
				
				
										$checkboxes_area .= '<li><input '. $is_checked .' class="chck" type="checkbox" name="'.$field_name.'[]" value="'.$checkbox_key_value.'" id="acf_chk_'.$field_count.$afb_c_i.$checkbox_key_value.'" /><label class="afb_labelfor" for="chk_'.$form_id.$field_count.$afb_c_i.$checkbox_key_value.'">'.$checkbox_value.'</label></li>'."\n";         
									
										$afb_c_i++;
									}
									
									if($afb_is_split == 1) { $checkboxes_area .= '</ul></div><div class="clear"></div></div>'."\n"; } else { $checkboxes_area .= '</ul></div><div class="clear"></div></div>'; }
														
									echo $checkboxes_area;
									
								// RADIOS    
								} elseif($type == 'radios' && !empty($options)) {
									
									$key = $field_name;
					
									$radios_area = '<div class="spacer" id="acf_'.$key.'"><div class="acf_radios_area_col"><ul>';
									
									$afb_r_i = 1;
					
									$afb_column_one_num = ceil(count($options) / $columns);
									
									$r_array = array();
									
									for ($r_i = 1; $r_i <= $columns; $r_i++) { $r_array[] = ($afb_column_one_num * $r_i) + 1; }
									
									foreach($options as $radio_key_value => $radio_value) {
									  
										if( in_array($afb_r_i, $r_array ) ) {
									
											$afb_is_split = true;
									
											$radios_area .= '</ul></div>'."\n\n".'<div class="acf_radios_area_col"><ul>'."\n";
										}
									
										$is_checked = (isSet($_POST[$field_name]) && ($_POST[$field_name] == $radio_key_value)) ? " checked='checked' " : '';
										
										$radios_area .= '<li><input '. $is_checked .' class="rad" type="radio" name="'.$field_name.'" value="'.$radio_key_value.'" id="acf_rad_'.$field_count.$afb_r_i.$radio_key_value.'" /><label class="afb_labelfor" for="rad_'.$form_id.$field_count.$afb_r_i.$radio_key_value.'">'.$radio_value.'</label></li>'."\n";         
									
										$afb_r_i++;
									}
									
									if($afb_is_split == 1) { $radios_area .= '</ul></div><div class="clear"></div></div>'."\n"; } else { $radios_area .= '</ul></div><div class="clear"></div></div>'; }
														
									echo $radios_area;
								}
								?>
							</div>
						</div>
					<?php                    
					}
				}

				if($acf_config['captcha']['enabled'] == 1) {
				?>                 
					<div class="wrap spacer" id="acf_main_sec_div">
					
						<label class="field">Code for spam protection</label>
						<div>
							<div id="acf_input_box_div"><input size="17" class="required text" type="text" id="acf_security_code" name="security_code" /></div> 
							<div id="acf_captcha_div"><img width="<?php echo $acf_config['captcha']['width']; ?>" height="<?php echo $acf_config['captcha']['height']; ?>" border="0" id="acf_captcha" class="acf_captcha_vertical" src="<?php echo $acf_config['path']['contact_app']; ?>captcha.php?x=<?php echo $unique_id; ?>" alt="" />&nbsp;<a id="acf_captcha_refresh" href="#"><img id="acf_icon_refresh" border="0" alt="" width="16" height="16" src="<?php echo $acf_config['path']['images']; ?>icon-refresh.png" align="bottom" /></a></div>  
							<div class="clear"></div>
						</div>
				
					</div>
			
					<div id="acf_sec_div_two">
					  <div id="acf_verified">Verification complete.</div>
					  
					</div><div class="clear"></div>
				<?php
				}
				?>    
					
				<center><input id="acf_submit_button" class="fancy-button-base green" type="submit" name="submit" value="Send Message" /></center><div id="acf_ajax_loading">Submitting...</div><br />
			
				<input type="hidden" name="acf_success_sent" id="acf_success_sent" value="0" />
				
			</form>
		</div>
		
		<?php } ?>

		<!-- Generated by http://www.BitRepository.com/ -->
		
		<!-- [/Ajax_Contact_Form] -->    
			</div>
	<?php
	}

}
?>