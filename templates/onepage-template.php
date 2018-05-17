<?php
/**
 * Template name: Onepage Template
 * Description: A one-page template to make a great singlepage website.
 */

// Add theme stylesheet with action hook (before custom code is implemented)
function wpstartup_theme_stylesheet(){
    $stylesheet = str_replace('-template.php', '', basename(__FILE__) ) . '-style.css';
    echo '<link rel="stylesheet" id="onepage-style"  href="'.plugins_url( $stylesheet , __FILE__ ).'" type="text/css" media="all" />';
}

// determine header image
$header_image = get_header_image();


?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php

    if ( ! isset( $content_width ) ) $content_width = 360; // mobile first

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

    // include wp head
    wp_head();

?>

</head>

    <body <?php body_class(); ?>>
    <div id="page" class="site">
        Top of page content
        <!-- topbar -->
        <!-- header -->
        <!-- navbar -->
        <!-- sections -->
        <!-- footer -->
    </div>

    <?php wp_footer(); ?>

    </body>
</html>
