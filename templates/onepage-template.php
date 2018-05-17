<?php
/**
 * Template name: Onepage Template
 * Description: A one-page template to make a great singlepage website.
 */

$header_image = get_header_image();

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php
    echo '<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	.'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	.'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';

    wp_head();

    if ( ! isset( $content_width ) ) $content_width = 360; // mobile first

    wp_enqueue_script('jquery');

    echo '<link rel="stylesheet" id="onepage-style"  href="'.plugins_url( 'onepage-style.css', __FILE__ ).'" type="text/css" media="all" />';

?>

</head>

<body <?php body_class(); ?>>
    <div id="page" class="site">
        <!-- topbar -->
        <!-- header -->
        <!-- navbar -->
        <!-- sections -->
        testing template
        <!-- footer -->
    </div>
</body>
</html>
