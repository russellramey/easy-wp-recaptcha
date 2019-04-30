<?php
/***
* Plugin Name: Easy ReCaptcha
* Plugin URI: https://github.com/russellramey/easy-recaptcah
* Description: Enable & append Google ReCaptcha API to default WP login. Supports Google ReCaptcha v2.
* Version: 1.0
* Author: Russell Ramey
* Author URI: https://russellramey.me/
***/

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
	wp_enqueue_style( 'easy-recaptcha-styles', get_stylesheet_directory_uri() . '/css/login-style.css' );
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