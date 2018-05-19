<?php
/**
 * Template name: WP startup Blank
 * Description: A minimal (blank) template to make anything you like.
 */

// Add theme stylesheet link to wp_head
add_action( 'wp_head', 'wpstartup_theme_stylesheet', 9997 );

function wpstartup_theme_stylesheet(){

    $stylesheet = str_replace('-template.php', '', basename(__FILE__) ) . '-style.css';
    if( plugins_url( $stylesheet , __FILE__ ) ){
        echo '<link rel="stylesheet" id="onepage-style"  href="'.plugins_url( $stylesheet , __FILE__ ).'" type="text/css" media="all" />';
    }

}

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

    // include wp head
    wp_head();

?>

</head>
<body <?php body_class(); ?>>
<?php echo 'This is a blank template'; ?>
</body>
</html>
