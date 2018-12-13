<?php
// remove the default common theme styles (comment out to keep)
add_action('wp_print_styles', 'wp_startup_remove_all_theme_styles', 100);

// the current page/post data
global $post;

// page id (or reference id)
$pid = $post->ID;
if( is_home() ){
    $pid = get_option( 'page_for_posts' );
}
// determine header image
$header_image = get_header_image();

// header textcolor
$header_text_color = get_header_textcolor();

// page content and sidebar width (jquery onresize)
$sidewidth = 100;
$mainwidth = 100;
// extend with page / post settings
$colorstyle = get_theme_mod('wp_startup_theme_panel_settings_colorstyle', 'light');
$sidebarpos = get_theme_mod('wp_startup_theme_panel_elements_sidebar', 'right');
$usebeforepost = get_theme_mod('wp_startup_theme_panel_elements_beforecontent', 'hide');
$useafterpost = get_theme_mod('wp_startup_theme_panel_elements_aftercontent', 'hide');
$usesidebar = 'default';
$usesidebar = get_post_meta( $pid , "meta-page-pagesidebardisplay", true);
$usebeforewidgets = get_post_meta( $pid , "meta-page-beforewidgetsdisplay", true);
$useafterwidgets = get_post_meta( $pid , "meta-page-afterwidgetsdisplay", true);
if( is_single() && !is_page() ){
    $usebeforewidgets = $usebeforepost;
    $useafterwidgets = $useafterpost;
}
$subcontent1display = get_post_meta($pid, "meta-page-subcontent1display", true);
$subcontent2display = get_post_meta($pid, "meta-page-subcontent2display", true);
if( $usesidebar == 'left' || $usesidebar == 'right'){
    $sidebarpos = $usesidebar;
}
if( $usesidebar == 'hide'){
    $sidebarpos = 'hide';
}
if( $sidebarpos != 'hide' ){
    $sidewidth = get_theme_mod('wp_startup_theme_panel_elements_sidebarwidth', 23 );
    $mainwidth = 100 - $sidewidth;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta http-equiv="Content-Type" content="text/html; charset='<?php get_bloginfo( 'charset' ); ?>'" />
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/jquery/jquery.js?ver=1.4.1"></script>
<script type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1"></script>
<?php
    // theme default element positioning javascript
    echo '<script type="text/javascript" src="'.plugins_url().'/wp-startup/templates/onepage/elements.js"></script>';
    // theme custom styling
    $stylesheet = plugins_url().'/wp-startup/templates/onepage/style.css';
    echo '<link rel="stylesheet" id="wp-startup-theme-style"  href="'.$stylesheet.'" type="text/css" media="all" />';
    if ( ! isset( $content_width ) ) $content_width = 360; // wp mobile first
?>
<title><?php echo get_bloginfo( 'name' ); ?></title>
<?php
echo '<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	.'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	.'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
    // more info for og api's
    echo '<meta property="og:title" content="' . get_the_title() . '"/>'
        .'<meta property="og:type" content="website"/>'
		.'<meta property="og:url" content="' . get_permalink() . '"/>'
		.'<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'"/>'
		.'<meta property="og:description" content="'.get_bloginfo( 'description' ).'"/>';

    if( !has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        if( !empty($header_image) ){
            $default_image = get_theme_mod( 'imagazine_globalshare_defaultimage', get_header_image() );
            echo '<meta property="og:image" content="' . $default_image . '"/>';
        }
    }else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    }
    //wp_head();
    ?>
</head>
<body <?php body_class(); ?>>

<?php
wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'mainmenu' ) );

if( have_posts() ) {
    while( have_posts() ) {
        the_post();
        echo apply_filters('the_content', get_the_content() );
    }
}
?>



<?php
wp_footer();

if( is_customize_preview() ){
echo '<div class="customizer-placeholder">Inside customizer options</div>';
}
?>
</body></html>
