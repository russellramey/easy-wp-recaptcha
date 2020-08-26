<?php
/***
* Plugin Name: Easy ReCaptcha
* Plugin URI: https://github.com/russellramey/easy-recaptcah
* Description: Enable & append Google ReCaptcha API to default WP login. Supports Google ReCaptcha v2 checkbox and invisible versions.
* Version: 1.0
* Author: Russell Ramey
* Author URI: https://russellramey.me/
***/


/***
* Check if EASY_RECAPTICAH Keys are defined in WP_config
***/
if (defined('EASY_RECAPTCHA_SITE_KEY') && defined('EASY_RECAPTCHA_SECRET')) {

	/***
	* Add scripts & styles to WP login page
	***/
	add_action('login_enqueue_scripts', 'login_recaptcha_script');
	function login_recaptcha_script() {

		// Register recaptcha script
		wp_register_script('recaptcha-script', 'https://www.google.com/recaptcha/api.js');
		// Enqueue registered recaptcha script
		wp_enqueue_script('recaptcha-script');

		// Register login styles
		wp_enqueue_style( 'easy-recaptcha-styles', plugin_dir_url(__FILE__) . '/easy-recaptcha-style.css' );
	}

	/***
	* Add reuiqred elements to WP login form
	***/
	add_action( 'login_form', 'display_recaptcha_on_login' );
	function display_recaptcha_on_login() {

		// Append g-recaptcha element with required SiteKey
		echo "<div class='g-recaptcha' data-sitekey='" . EASY_RECAPTCHA_SITE_KEY . "'></div>";

		// Add simple JS script to make username and password fields required
		echo "<script>document.getElementById('user_pass').setAttribute('required', 'required'); document.getElementById('user_login').setAttribute('required', 'required');</script>";
	}

	/***
	* Process ReCaptcha response on WP login submit action
	***/
	add_filter('wp_authenticate_user', 'verify_recaptcha_on_login', 10, 2);
	function verify_recaptcha_on_login($user, $password) {

		// If recaptcha exists
		if (isset($_POST['g-recaptcha-response'])) {

			// Verify recaptcha with google
			$response = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . EASY_RECAPTCHA_SECRET .  '&response=' . $_POST['g-recaptcha-response'] );

			// If response data is returned
			if ($response){

				// Decode response body
				$response = json_decode($response['body'], true);

				// If response is successful
				if (true == $response['success']) {

					// Return WP User object
					return $user;

				} else {

					// Return error if ReCaptcha fail
					return new WP_Error( 'Captcha Invalid', __('<strong>ERROR</strong>: Please provide the reCAPTCHA response.') );

				}

			}

		} else {

			// Return error if ReCaptcha is not submited with login attempt
			return new WP_Error( 'Captcha Invalid 2', __('<strong>ERROR</strong>: Please provide the reCAPTCHA response.') );

		}

	}
}