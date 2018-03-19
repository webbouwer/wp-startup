<?php
/*
Plugin Name: WP Startup
Plugin URI:  https://github.com/webbouwer/wp-startup
Description: Do a lot more with a basic WP install
Version:     1.0
Author:      Webbouwer
Author URI:  http://webdesigndenhaag.net
License:     © Oddsized All rights reserved
License URI: http://webdesigndenhaag.net
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Link Manager
 * https://core.trac.wordpress.org/ticket/21307
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

?>
