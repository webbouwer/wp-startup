<?php
/*
Plugin Name: WP Startup 'Earlybird'
Plugin URI:  https://github.com/webbouwer/wp-startup
Description: Do more with a basic WP install
Version:     0.1
Author:      Webbouwer
Author URI:  http://webdesigndenhaag.net
Text Domain: wp-startup
License:     © Oddsized All rights reserved
License URI: http://webdesigndenhaag.net
*/

/**

Features:

- link manager (wp default hidden)
- theme basic background-image
- theme panorama image size 1800, 640,
- widget text allow php
- order categories in metabox

*/

/**
 * Verify code usage in WP
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load textdomain languages  
 */

add_action('plugins_loaded', 'ws_load_textdomain');
function wan_load_textdomain() {
	load_plugin_textdomain( 'wp-startup', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}






/**
 * WP Startup Admin menu
 * http://tekina.info/add-menus-submenus-wordpress-admin-panel/
 * https://developer.wordpress.org/resource/dashicons/#flag
 */
add_action( 'admin_menu', 'my_plugin_menu' );
function my_plugin_menu() {
    add_menu_page( 'My option page', 'WP Startup', 'manage_options', 'my-fist-slug', 'wp_startup_options_settings', 'dashicons-editor-kitchensink');
    add_submenu_page('my-fist-slug', 'General Settings', 'Settings', 'manage_options', 'my-fist-slug', 'wp_startup_options_settings');
    add_submenu_page('my-fist-slug', 'Admin options', 'Options', 'manage_options', 'my-second-slug', 'wp_startup_options_options');
}
/**
 * Admin menu page 1
 */
function wp_startup_options_settings() {
    echo 'WP Startup Plugin Settings';
}
/**
 * Admin menu page 2
 */
function wp_startup_options_options() {
    echo 'WP Startup Plugin Options';
}








/**
 * Link Manager
 * https://core.trac.wordpress.org/ticket/21307
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );




/** Customized Header */

/**
 * Register Theme (default) Support
 */
function wpstartup_theme_global() {
	add_image_size( 'panorama', 1800, 640, array( 'center', 'center' ) );
	add_theme_support( 'custom-background' );
}
add_action( 'after_setup_theme', 'wpstartup_theme_global' ); 

/** Libraries 
 *include webicon
 */
function imagazine_load_webicons(){
	wp_enqueue_script('jquery-webicon', '//cdn.rawgit.com/icons8/bower-webicon/v0.10.7/jquery-webicon.min.js');
}
add_action( 'wp_print_scripts', 'imagazine_load_webicons' );


/** 
 * Add custom css
 */
add_action( 'wp_head', 'ws_load_custom_css', 9999 );
function ws_load_custom_css() {
	
	$csscode = 'h1.site-title a{ color:blue !important; }';
	echo '<style>'.$csscode.'</style>';
	
	
}

/** 
 * Add custom javascript
 */
add_action( 'wp_head', 'ws_load_custom_js', 9998 );
function ws_load_custom_js() {
	
	$jscode = 'alert("WP Startup activated!");';
	echo '<script>'.$jscode.'</script>';
	
	
}



/** Customized WP elements */

/**
 * shortcodes in text widgets.
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Execute PHP in the default text-widget
 */
add_filter('widget_text','php_execute',100);
function php_execute($html){
	if(strpos($html,"<"."?php")!==false){ ob_start(); eval("?".">".$html);
		$html=ob_get_contents();
		ob_end_clean();
	}
	return $html;
}
/**
 * Keep category select list in hiÎarchy
 * source http://wordpress.stackexchange.com/questions/61922/add-post-screen-keep-category-structure
 */
add_filter( 'wp_terms_checklist_args', 'imagazine_wp_terms_checklist_args', 1, 2 );
function imagazine_wp_terms_checklist_args( $args, $post_id ) {
	 $args[ 'checked_ontop' ] = false;
	 return $args;
}














/** include googlefonts
  
function google_fonts() {
	$query_args = array(
		'family' => get_theme_mod("imagazine_global_styles_mainfont", "Lato|Martel"),
		'subset' => get_theme_mod("imagazine_global_styles_subsetfont", "latin,latin-ext"),
	);
	wp_enqueue_style( 'google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
	// wp_register_style
}
add_action('wp_enqueue_scripts', 'google_fonts');
*/







/*
 * Load code
 *

 
add_action('admin_enqueue_scripts', 'ln_reg_css_and_js');

function ln_reg_css_and_js($hook)
{

    $current_screen = get_current_screen();

    if ( strpos($current_screen->base, 'my-fist-slug') === false) {
        return;
    } else {

        wp_enqueue_style('boot_css', plugins_url('inc/bootstrap.css',__FILE__ ));
        wp_enqueue_script('boot_js', plugins_url('inc/bootstrap.js',__FILE__ ));
        wp_enqueue_script('ln_script', plugins_url('inc/main_script.js', __FILE__), ['jquery'], false, true);
        }
    }

 */
 
 
 

/* language 
https://premium.wpmudev.org/blog/translating-wordpress-plugins/
https://premium.wpmudev.org/blog/how-to-translate-a-wordpress-plugin/

https://wpcentral.io/internationalization/
lang/*.mo

msgid ""
msgstr ""
"Project-Id-Version: WP Startup 1.0.0\n"
"Report-Msgid-Bugs-To: \n"
"POT-Creation-Date: 2018-04-20 13:09+0100\n"
"PO-Revision-Date: 2018-03-20 13:09+0100\n"
"Last-Translator: Webbouwer <support@webdesigndenhaag.net>\n"
"Language-Team: Webbouwer <support@webdesigndenhaag.net>\n"
"Language: English \n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Poedit-KeywordsList: __;_e\n"
"X-Poedit-Basepath: .\n"
"X-Poedit-SearchPath-0: ..\n"

#: ../wp-startup.php:20
msgid "You are awesome"
msgstr ""

#: ../wp-startup.php:21
msgid "This website is boss"
msgstr ""

#: ../wp-startup.php:22
msgid "You look great today"
msgstr ""

*/
?>
