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

require_once __DIR__ . '/src/autoloader.php';

// Register the autoloader
WP_Startup_Autoloader::register( 'WP_Startup', trailingslashit( plugin_dir_path( __FILE__ ) ) . '/src/' );
// Runs this plugin after all plugins are loaded.
add_action( 'plugins_loaded', function() {
	$GLOBALS['wp_start'] = new WP_Startup_Plugin();
	$GLOBALS['wp_start']->run( __FILE__ );
});

?>
