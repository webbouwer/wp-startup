<?php

/**
 * WP startup Page themes
 */
function wp_startup_pagethemes_func(){

    require_once( 'templates.php' );
    add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

    // Extend theme wp_nav_menu() locations for wp-startup themes
    register_nav_menus(
        array(
            'upper'    => __( 'Upper Menu', 'wp-startup' ),
            'top'    => __( 'Top- Menu', 'wp-startup' ),
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

    // Add widget param check for empty html correction
    add_filter( 'dynamic_sidebar_params', 'wp_startup_check_sidebar_params' );

}

/**
 * Register Theme and (default) Support
 * more info: https://codex.wordpress.org/Plugin_API/Action_Reference
 */
function wp_startup_theme_global_func() {

    // add_theme_support()
	// add_image_size( 'panorama', 1800, 640, array( 'center', 'center' ) );
    add_theme_support( 'custom-background' );

}

/**
 * WP startup Menu Images
 */
function wp_startup_menu_images_func(){
    require_once('assets/menu.php'); // menu image plugin functions
}


/**
 * WP startup Adminbar Menu
 */
function wp_startup_adminbar_menu_func(){
    // add adminbar menu
    add_action('admin_bar_menu', 'create_wpstartup_menu', 2000);
}
function create_wpstartup_menu() {
	global $wp_admin_bar;
	$menu_id = 'wp-startup-barmenu';
	$wp_admin_bar->add_menu(array('id' => $menu_id, 'title' => __('WP Startup'), 'href' => home_url().'/wp-admin/admin.php?page=wp_startup_optionpage'));
	//$wp_admin_bar->add_menu(array('parent' => $menu_id, 'title' => __('Startup'), 'id' => 'wp-startup-home', 'href' => home_url().'/wp-admin/admin.php?page=wp_startup_optionpage', 'meta' => array('target' => '_self')));
}

/**
 * De-register default theme styles (used in specifc page templates)
 */
function wp_startup_theme_deregister_func() {

  wp_deregister_style('twentyseventeen-style');
  wp_deregister_style('twentyseventeen-fonts');
  wp_deregister_style('twentysixteen-style');
  wp_deregister_style('twentysixteen-fonts');
  wp_deregister_style('twentyfifteen-style');
  wp_deregister_style('twentyfifteen-fonts');

}




/**
 * WP startup Customized Widgets & Areas
 */
function wp_startup_widgets_init_func() {

    // first inspect current sidebars
    // wp_get_sidebars_widgets()

    /** Register widgets area's */
    register_sidebar( array(
        'name' => __( 'topbar widget 1', 'wp-startup' ),
        'id' => 'topbar-widget-1',
        'description'   => 'Topbar widgets 1 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'topbar widget 2', 'wp-startup' ),
        'id' => 'topbar-widget-2',
        'description'   => 'Topbar widgets 2 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'Header widget 1', 'wp-startup' ),
        'id' => 'header-widget-1',
        'description'   => 'Header widgets 1 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'Header widget 2', 'wp-startup' ),
        'id' => 'header-widget-2',
        'description'   => 'Header widgets 3 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'Topcontent widget 1', 'wp-startup' ),
        'id' => 'topcontent-widget-1',
        'description'   => 'Topcontent widgets 1 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'Topcontent widget 2', 'wp-startup' ),
        'id' => 'topcontent-widget-2',
        'description'   => 'Topcontent widgets 2 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'Before widget', 'wp-startup' ),
        'id' => 'before-widget',
        'description'   => 'Before content widgets wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'After widget', 'wp-startup' ),
        'id' => 'after-widget',
        'description'   => 'After content widgets wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">',
    ) );
    // mainsidebar

    register_sidebar( array(
        'name' => __( 'Sidebar', 'wp-startup' ),
        'id' => 'sidebar-widget',
        'description'   => 'Sidebar content widgets wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">',
    ) );

    register_sidebar( array(
        'name' => __( 'Subcontent widget 1', 'wp-startup' ),
        'id' => 'subcontent-widget-1',
        'description'   => 'Subcontent widgets 1 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'Subcontent widget 2', 'wp-startup' ),
        'id' => 'subcontent-widget-2',
        'description'   => 'Subcontent widgets 2 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );

     register_sidebar( array(
        'name' => __( 'Bottom widget 1', 'wp-startup' ),
        'id' => 'bottom-widget-1',
        'description'   => 'Bottom widgets 1 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
    register_sidebar( array(
        'name' => __( 'Bottom widget 2', 'wp-startup' ),
        'id' => 'bottom-widget-2',
        'description'   => 'Bottom widgets 2 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );

    register_sidebar( array(
        'name' => __( 'Footer widget 1', 'wp-startup' ),
        'id' => 'footer-widget-1',
        'description'   => 'Footer widgets 1 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );

    register_sidebar( array(
        'name' => __( 'Footer widget 2', 'wp-startup' ),
        'id' => 'footer-widget-2',
        'description'   => 'Footer widgets 2 wp-startup',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
    ) );
}



/**
 * WP startup Extra widgets
 */
function wp_startup_widgets_func(){

    require_once( 'widgets/postlist.php' );
    require_once( 'widgets/dashboard.php' );

    add_action( 'widgets_init', 'wp_startup_widgets_register_func' );

}
function wp_startup_widgets_register_func() {

    register_widget( 'wpstartup_postlist_widget' );

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

    add_filter('widget_text','wp_startup_php_execute',100);
    function wp_startup_php_execute($html){
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
  add_filter( 'tiny_mce_plugins', 'wp_startup_disable_emojicons_tinymce' ); // filter to remove TinyMCE emojis
}
function wp_startup_disable_emojicons_tinymce( $plugins ) {
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

    add_filter('bp_core_fetch_avatar', 'wp_startup_bp_remove_gravatar', 1, 9 );
    add_filter('get_avatar', 'wp_startup_remove_gravatar', 1, 5);
    add_filter('bp_get_signup_avatar', 'wp_startup_bp_remove_signup_gravatar', 1, 1 );

}

function wp_startup_bp_remove_gravatar ($image, $params, $item_id, $avatar_dir, $css_id, $html_width, $html_height, $avatar_folder_url, $avatar_folder_dir) {
	$default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; // get_stylesheet_directory_uri() .'/images/avatar.png';
	if( $image && strpos( $image, "gravatar.com" ) ){
		return '<img src="' . $default . '" alt="avatar" class="avatar" ' . $html_width . $html_height . ' />';
	} else {
		return $image;
	}
}
function wp_startup_remove_gravatar ($avatar, $id_or_email, $size, $default, $alt) {
	$default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; // get_stylesheet_directory_uri() .'/images/avatar.png';
	return "<img alt='{$alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
}
function wp_startup_bp_remove_signup_gravatar ($image) {
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


// time ago
function wp_startup_time_ago( $t ) {
    // https://codex.wordpress.org/Function_Reference/human_time_diff
    //get_the_time( 'U' )
    printf( _x( '%s '.__('ago','wp-startup'), '%s = human-readable time difference', 'imagazine' ), human_time_diff( $t, current_time( 'timestamp' ) ) );
}

// words in excerpts
function wp_startup_the_excerpt_length( $words = null, $links = true ) {
		global $_wp_startup_the_excerpt_length_filter;
		if( isset($words) ) {
			$_wp_startup_the_excerpt_length_filter = $words;
		}
		add_filter( 'excerpt_length', '_wp_startup_the_excerpt_length_filter' );
		if( $links == false){
			echo preg_replace('/(?i)<a([^>]+)>(.+?)<\/a>/','', get_the_excerpt() );
		}else{
			the_excerpt();
		}
		remove_filter( 'excerpt_length', '_wp_startup_the_excerpt_length_filter' );
		// reset the global
		$_wp_startup_the_excerpt_length_filter = null;
	}

function _wp_startup_the_excerpt_length_filter( $default ) {
    global $_wp_startup_the_excerpt_length_filter;
    if( isset($_wp_startup_the_excerpt_length_filter) ) {
        return $_wp_startup_the_excerpt_length_filter;
    }
    return $default;
}


// image orient
function wp_startup_check_image_orientation($pid){
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
function wp_startup_get_categories_select(){
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
function wp_startup_is_sidebar_active( $sidebar_id ){
    $the_sidebars = wp_get_sidebars_widgets();
    if( !isset( $the_sidebars[$sidebar_id] ) )
        return false;
    else
        return count( $the_sidebars[$sidebar_id] );
}

// widget empty title content wrapper fix
function wp_startup_check_sidebar_params( $params ) {
    global $wp_registered_widgets;
    $settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
    $settings = $settings_getter->get_settings();
    $settings = $settings[ $params[1]['number'] ];
    if ( $params[0][ 'after_widget' ] == '<div class="clr"></div></div></div>' && isset( $settings[ 'title' ] ) &&  empty( $settings[ 'title' ] ) ){
        $params[0][ 'before_widget' ] .= '<div class="widget-contentbox">';
    }
    return $params;
}

/**
* Truncates text.
*
* Cuts a string to the length of $length and replaces the last characters
* with the ending if the text is longer than length.
*
* @param string  $text String to truncate.
* @param integer $length Length of returned string, including ellipsis.
* @param string  $ending Ending to be appended to the trimmed string.
* @param boolean $exact If false, $text will not be cut mid-word
* @param boolean $considerHtml If true, HTML tags would be handled correctly
* @return string Trimmed string.
*/
function wp_startup_truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                // if tag is a closing tag (f.e. </b>)
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                // if tag is an opening tag (f.e. <b>)
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if($considerHtml) {
			$truncate .= '.. ';
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}


?>
