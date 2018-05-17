<?php
/*
Plugin Name: WP Startup
Plugin URI:  https://github.com/webbouwer/wp-startup
Description: Do more with a basic WP install
Version:     0.2
Author:      Webbouwer
Author URI:  http://webdesigndenhaag.net
Text Domain: wp-startup
License:     © Oddsized All rights reserved
License URI: http://webdesigndenhaag.net
*/


/**
 * Verify code usage in WP
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Includes
 */
require_once( 'settings.php' );

// on startup
wpstartup_components_global();

/**
 * Components
 * https://core.trac.wordpress.org/ticket/21307
 */
function wpstartup_components_global() {

        // Load textdomain languages
        add_action('plugins_loaded', 'ws_load_textdomain');
        function wan_load_textdomain() {
            load_plugin_textdomain( 'wp-startup', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
        }

        // Use widget bundle
        if( get_option( 'ws_widgets_option' ) != '' && get_option( 'ws_widgets_option' ) == true ){
            require_once( 'widgets/postlist.php' );
            add_action( 'widgets_init', 'wpstartup_widgets_register' );
        }

        // Use page templates
        if( get_option( 'ws_pagetemplates_option' ) != '' && get_option( 'ws_pagetemplates_option' ) == true ){
            require_once( 'templates.php' );
            add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );
        }

        // Link Manager
        if( get_option( 'ws_linkmanager_option' ) != '' && get_option( 'ws_linkmanager_option' ) == true ){
            add_filter( 'pre_option_link_manager_enabled', '__return_true' );
        }

        // Keep category select list in hiÎarchy
        // source http://wordpress.stackexchange.com/questions/61922/add-post-screen-keep-category-structure
        if( get_option( 'ws_categoryhierarchy_option' ) != '' && get_option( 'ws_categoryhierarchy_option' ) == true ){
            add_filter( 'widget_text', 'do_shortcode' );
            add_filter( 'wp_terms_checklist_args', 'imagazine_wp_terms_checklist_args', 1, 2 );
            function imagazine_wp_terms_checklist_args( $args, $post_id ) {
                 $args[ 'checked_ontop' ] = false;
                 return $args;
            }
        }

        // Text widget shortcodes
        if( get_option( 'ws_shortcodesintextwidget_option' ) != '' && get_option( 'ws_shortcodesintextwidget_option' ) == true ){
            add_filter( 'widget_text', 'do_shortcode' );
        }

        // Text widget php
        if( get_option( 'ws_phpintextwidget_option' ) != '' && get_option( 'ws_phpintextwidget_option' ) == true ){

            // Execute PHP in the default text-widget
            add_filter('widget_text','php_execute',100);
            function php_execute($html){
                if(strpos($html,"<"."?php")!==false){ ob_start(); eval("?".">".$html);
                    $html=ob_get_contents();
                    ob_end_clean();
                }
                return $html;
            }
        }

        // disable gravatar
        if( get_option( 'ws_removegravatar_option' ) != '' && get_option( 'ws_removegravatar_option' ) == true ){
        add_filter('bp_core_fetch_avatar', 'bp_remove_gravatar', 1, 9 );
        add_filter('get_avatar', 'remove_gravatar', 1, 5);
        add_filter('bp_get_signup_avatar', 'bp_remove_signup_gravatar', 1, 1 );
        }

        // disable gravatar
        if( get_option( 'ws_removeemojicons_option' ) != '' && get_option( 'ws_removeemojicons_option' ) == true ){
            add_action( 'init', 'disable_wp_emojicons' );
        }

        /* basic */
        add_action( 'widgets_init', 'wpstartup_widgets_init' );
        add_action( 'after_setup_theme', 'wpstartup_theme_global' );
        add_action( 'wp_head', 'wpstartup_load_custom_css', 9999 );
        add_action( 'wp_head', 'wpstartup_load_custom_js', 9998 );
        add_action( 'wp_head', 'wpstartup_theme_stylesheet', 9997 );

}



/** Customized Widgets & Areas  */
function wpstartup_widgets_init() {

    /** Register widgets area's */
    register_sidebar( array(
        'name' => __( 'Area custom1', 'wp-startup' ),
        'id' => 'area-custom1',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );

}

// register widgets if used
function wpstartup_widgets_register() {

    register_widget( 'wpstartup_postlist_widget' );

}


/**
 * Register Theme and (default) Support
 * more info: https://codex.wordpress.org/Plugin_API/Action_Reference
 */
function wpstartup_theme_global() {
    // add_theme_support()
	//add_image_size( 'panorama', 1800, 640, array( 'center', 'center' ) );
	if( get_option( 'ws_themebgimage_option' ) != '' && get_option( 'ws_themebgimage_option' ) == true ){
		add_theme_support( 'custom-background' );
	}

}


/** 
 * Add custom css
 */
function wpstartup_load_custom_css() {
	if( get_option( 'ws_custom_css' ) != '' && get_option( 'ws_custom_css' ) != 1){
		$csscode = get_option( 'ws_custom_css' );
		echo '<style>'.$csscode.'</style>';
	} 
}

/** 
 * Add custom javascript
 */
function wpstartup_load_custom_js() {
	if( get_option( 'ws_custom_js' ) != '' && get_option( 'ws_custom_js' ) != 1){
		$jscode = get_option( 'ws_custom_js' );
		echo '<script>'.$jscode.'</script>';
	} 	
}




/** Performance tweaks */

/**
 * control (remove) gravatar
 */
function bp_remove_gravatar ($image, $params, $item_id, $avatar_dir, $css_id, $html_width, $html_height, $avatar_folder_url, $avatar_folder_dir) {
	$default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; // get_stylesheet_directory_uri() .'/images/avatar.png';
	if( $image && strpos( $image, "gravatar.com" ) ){
		return '<img src="' . $default . '" alt="avatar" class="avatar" ' . $html_width . $html_height . ' />';
	} else {
		return $image;
	}
}
function remove_gravatar ($avatar, $id_or_email, $size, $default, $alt) {
	$default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; // get_stylesheet_directory_uri() .'/images/avatar.png';
	return "<img alt='{$alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
}
function bp_remove_signup_gravatar ($image) {
	$default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; //get_stylesheet_directory_uri() .'/images/avatar.png';
	if( $image && strpos( $image, "gravatar.com" ) ){
		return '<img src="' . $default . '" alt="avatar" class="avatar" width="60" height="60" />';
	} else {
		return $image;
	}
}






/** Remove Emoji junk by Christine Cooper
 * Found on http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function disable_wp_emojicons() {
  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' ); // filter to remove TinyMCE emojis
}
function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}






// Global used


 // time ago
function wp_time_ago( $t ) {
    // https://codex.wordpress.org/Function_Reference/human_time_diff
    //get_the_time( 'U' )
    printf( _x( '%s '.__('geleden','wp-startup'), '%s = human-readable time difference', 'imagazine' ), human_time_diff( $t, current_time( 'timestamp' ) ) );
}

// words in excerpts
function the_excerpt_length( $words = null, $links = true ) {
		global $_the_excerpt_length_filter;
		if( isset($words) ) {
			$_the_excerpt_length_filter = $words;
		}
		add_filter( 'excerpt_length', '_the_excerpt_length_filter' );
		if( $links == false){
			echo preg_replace('/(?i)<a([^>]+)>(.+?)<\/a>/','', get_the_excerpt() );
		}else{
			the_excerpt();
		}
		remove_filter( 'excerpt_length', '_the_excerpt_length_filter' );
		// reset the global
		$_the_excerpt_length_filter = null;
	}

function _the_excerpt_length_filter( $default ) {
    global $_the_excerpt_length_filter;
    if( isset($_the_excerpt_length_filter) ) {
        return $_the_excerpt_length_filter;
    }
    return $default;
}


// image orient
function check_image_orientation($pid){
	$orient = 'square';
    $image = wp_get_attachment_image_src( get_post_thumbnail_id($pid), '');
    $image_w = $image[1];
    $image_h = $image[2];
			if ($image_w > $image_h) {
				$orient = 'landscape';
			}elseif ($image_w == $image_h) {
				$orient = 'square';
			}else {
				$orient = 'portrait';
			}
			return $orient;
}

// get categories
function get_categories_select(){
    $get_cats = get_categories();
    $results;
    $count = count($get_cats);
			for ($i=0; $i < $count; $i++) {
				if (isset($get_cats[$i]))
					$results[$get_cats[$i]->slug] = $get_cats[$i]->name;
				else
					$count++;
			}
    return $results;
}


?>
