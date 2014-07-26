<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	
	function wp_tell_a_freind_head() {
		include_once dirname( __FILE__ ) . "/../templates/wp-sms-tell-friend-head.php";
	}
	
	function wp_tell_a_freind($content) {
	
		if(is_single()) {
		
			global $sms;
			
			include_once dirname( __FILE__ ) . "/../templates/wp-sms-tell-friend.php";
			
			if($_POST['send_post']) {
				$mobile = $_POST['get_fmobile'];
				if($_POST['get_name'] && $_POST['get_fname'] && $_POST['get_fmobile']) {
					if( (strlen($mobile) >= 11) && (substr($mobile, 0, 2) == get_option('wp_sms_mcc')) && (preg_match("([a-zA-Z])", $mobile) == 0) ) {
						$sms->to = array($_POST['get_fmobile']);
						$sms->msg = sprintf(__('Hi %s, the %s post suggested to you by %s. url: %s', 'wp-sms'), $_POST['get_fname'], get_the_title(), $_POST['get_name'], wp_get_shortlink());
						
						if( $sms->SendSMS() )
							_e('SMS was sent with success', 'wp-sms');
							
					} else {
						_e('Please enter a valid mobile number', 'wp-sms');
					}
				} else {
					_e('Please complete all fields', 'wp-sms');
				}
			}
		}
		return $content;
		
	}
	
	if(get_option('wp_suggestion_status')) {
		add_action('wp_head', 'wp_tell_a_freind_head');
		add_action('the_content', 'wp_tell_a_freind');
	}
	
	function wps_modify_contact_methods($fields) {
		$fields['mobile'] = __('Mobile', 'wp-sms');
		
		return $fields;
	}
	
	function wps_register_form() {
		$mobile = ( isset( $_POST['mobile'] ) ) ? $_POST['mobile']: '';
		?>
		<p>
			<label for="mobile"><?php _e('Your Mobile Number','wp-sms') ?><br />
			<input type="text" name="mobile" id="mobile" class="input" value="<?php echo esc_attr(stripslashes($mobile)); ?>" size="25" /></label>
		</p>
		<?php
	}
	
	function wps_registration_errors($errors, $sanitized_user_login, $user_email) {
		if ( empty( $_POST['mobile'] ) )
		$errors->add( 'first_name_error', __('<strong>ERROR</strong>: You must include a mobile number.', 'wp-sms') );
		
		return $errors;
	}
	
	function wps_save_register($user_id) {
		if ( isset( $_POST['mobile'] ) ) {
		
			global $sms, $date;
			
			// Update user meta
			update_user_meta($user_id, 'mobile', $_POST['mobile']);
			
			// Send sms to user.
			$string = get_option('wpsms_narnu_tt');
			
			$username_info = get_userdata($user_id);
			
			$template_vars = array(
				'user_login'	=> $username_info->user_login,
				'user_email'	=> $username_info->user_email,
				'date_register'	=> $date,
			);
			
			$final_message = preg_replace('/%(.*?)%/ime', "\$template_vars['$1']", $string);
			
			$sms->to = array($_POST['mobile']);
			$sms->msg = $final_message;
			
			$sms->SendSMS();
		}
	}
	
	if(get_option('wps_add_mobile_field')) {
		add_filter('user_contactmethods', 'wps_modify_contact_methods');
		add_action('register_form','wps_register_form');
		add_filter('registration_errors', 'wps_registration_errors', 10, 3);
		
		if(get_option('wpsms_nrnu_stats'))
			add_action('user_register', 'wps_save_register');
	}