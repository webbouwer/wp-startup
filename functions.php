<?php
/**
 * WP startup Page themes
 */
function wp_startup_pagethemes_func(){

    // load plugin page templates
    require_once( 'templates.php' );
    // load plugin templates customizer
    require_once( 'customizer.php' );

    add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

    // Extend theme wp_nav_menu() locations for wp-startup themes
    register_nav_menus(
        array(
            'main'    => __( 'Main Menu', 'wp-startup' ),
            'side'    => __( 'Sidebar Menu', 'wp-startup' ),
            'bottom'    => __( 'Bottom Menu', 'wp-startup' ),
            // + twentyseventeen: 'top' = twentysixteen/twentyfifteen 'primary'
            // + 'social'
        )
    );

    // wp core theme extensions
    add_action( 'after_setup_theme', 'wp_startup_theme_global_func' );

    // Extend theme widget locations for wp-startup themes
    add_action( 'widgets_init', 'wp_startup_widgets_init_func' );

    //
    add_filter( 'dynamic_sidebar_params', 'check_sidebar_params' );
}



/**
 * Register Theme and (default) Support
 * more info: https://codex.wordpress.org/Plugin_API/Action_Reference
 */
function wp_startup_theme_global_func(){

    // add_theme_support()
	// add_image_size( 'panorama', 1800, 640, array( 'center', 'center' ) );
    add_theme_support( 'custom-background' );

}






/**
 * WP startup Website widgets
 */
function wp_startup_widgets_func(){

    require_once( 'widgets/postlist.php' );

    add_action( 'widgets_init', 'wp_startup_widgets_register_func' );


    require_once( 'widgets/dashboard.php' );


}
function wp_startup_widgets_register_func() {

    // @widgets/postlist.php
    register_widget( 'wpstartup_postlist_widget' );


    // @widgets/dashboard.php
    add_action( 'wp_dashboard_setup', 'wp_startup_dashboard_github_widget' );

}






/**
 * Shortcode in text widget
 */
function wp_startup_shortcodeintextwidget_func(){

    add_filter( 'widget_text', 'do_shortcode' );

}



/**
 * Category Hierarchy
 */
function wp_startup_keep_category_hierarchy_func(){

        add_filter( 'widget_text', 'do_shortcode' );
        add_filter( 'wp_terms_checklist_args', 'wp_startup_terms_checklist_args', 1, 2 );
        function wp_startup_terms_checklist_args( $args, $post_id ) {
            $args[ 'checked_ontop' ] = false;
            return $args;
        }

}


/**
 * PHP in text widget
 */
function wp_startup_phpintextwidget_func(){

    add_filter('widget_text','php_execute',100);
    function php_execute($html){
        if(strpos($html,"<"."?php")!==false){ ob_start(); eval("?".">".$html);
            $html=ob_get_contents();
            ob_end_clean();
        }
        return $html;
    }

}

/**
 * Custom CSS code
 */
function wp_startup_addcustomcss_func(){

    $csscode = get_option( 'wp_startup_addcustomcss_option' );
    echo '<style id="wp-startup-custom-css">'.$csscode.'</style>';

}
/**
 * Custom JS code
 */
function wp_startup_addcustomjs_func(){

    $jscode = get_option( 'wp_startup_addcustomjs_option' );
    echo '<script id="wp-startup-custom-js">'.$jscode.'</script>';

}

/** Remove Emoji junk by Christine Cooper
 * Found on http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function wp_startup_disable_wp_emojicons_func() {
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



/**
 * control (remove) gravatar
 */
function wp_startup_disable_gravatar_func(){

    add_filter('bp_core_fetch_avatar', 'bp_remove_gravatar', 1, 9 );
    add_filter('get_avatar', 'remove_gravatar', 1, 5);
    add_filter('bp_get_signup_avatar', 'bp_remove_signup_gravatar', 1, 1 );

}

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





/**
 * Global most used functions
 */

  // default (not) sanitize function
function wp_startup_theme_sanitize_default($obj){
    return $obj;
}

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


// check active widgets
function is_sidebar_active( $sidebar_id ){
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return false;
    else
        return count( $the_sidebars[$sidebar_id] );
}

// widget empty title content wrapper fix
function check_sidebar_params( $params ) {
    global $wp_registered_widgets;
    $settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
    $settings = $settings_getter->get_settings();
    $settings = $settings[ $params[1]['number'] ];
    if ( $params[0][ 'after_widget' ] == '<div class="clr"></div></div></div>' && isset( $settings[ 'title' ] ) &&  empty( $settings[ 'title' ] ) ){
        $params[0][ 'before_widget' ] .= '<div class="widget-contentbox">';
    }
    return $params;
}
?>
