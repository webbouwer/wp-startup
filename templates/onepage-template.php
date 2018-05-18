<?php
/**
 * Template name: Onepage Template
 * Description: A one-page template to make a great singlepage website.
 */



// remove the default common theme styles
add_action('wp_print_styles', 'wpstartup_deregister_styles', 100);

// Add theme stylesheet with action hook (before custom code is implemented)
function wpstartup_theme_stylesheet(){
    $stylesheet = str_replace('-template.php', '', basename(__FILE__) ) . '-style.css';
    echo '<link rel="stylesheet" id="onepage-style"  href="'.plugins_url( $stylesheet , __FILE__ ).'" type="text/css" media="all" />';
}


// the current page/post data
global $post;

// determine header image
$header_image = get_header_image();



// theme html output toplogo (custom_logo) or site title home link
function wpstartup_toplogo_html(){

    if( get_theme_mod('custom_logo', '') != '' ){
        $custom_logo_id = get_theme_mod('custom_logo');
        $custom_logo_attr = array(
            'class'    => 'custom-logo',
            'itemprop' => 'logo',
        );

        echo sprintf( '<a href="%1$s" class="custom-logo-link image" rel="home" itemprop="url">%2$s</a>',
        esc_url( home_url( '/' ) ),
        wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )
        );

    }else{

        echo sprintf( '<a href="%1$s" class="custom-logo-link text" rel="home" itemprop="url">%2$s</a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name', 'display' ) ) //get_bloginfo( 'description' )
        );

    }
}

// theme html output menu's by name (str or array)
function wpstartup_menu_html( $menu, $default = false ){

    if( $menu != '' || is_array( $menu ) ){
        if( is_array( $menu ) ){
        // multi menu
            foreach( $menu as $nm ){

                if( has_nav_menu( $nm ) ){
                    echo '<div id="'.$nm.'menubox"><div id="'.$nm.'menu" class=""><nav><div class="innerpadding">';
                    wp_nav_menu( array( 'theme_location' => $nm ) );
                    echo '<div class="clr"></div></div></nav></div></div>';
                }
            }

        }else if( has_nav_menu( $menu ) ){
        // single menu
            echo '<div id="'.$menu.'menubox"><div id="'.$menu.'menu" class=""><nav><div class="innerpadding">';
            wp_nav_menu( array( 'theme_location' => $menu , 'menu_class' => 'nav-menu' ) );
            echo '<div class="clr"></div></div></nav></div></div>';
        }else if( $default != false ){
		    wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) );
	    }

    }

}

// theme html output widget area's by type or default
function wpstartup_widgetarea_html( $id, $type = false ){

    if( isset($id) && $id != '' ){

        if( function_exists('dynamic_sidebar') && function_exists('is_sidebar_active') && is_sidebar_active( $id ) ){

            $class = 'widgetbox';

            if( isset($type) && $type != '' ){

                $class = 'widgetbox widget-'.$type;
            }

            echo '<div id="'.$id.'" class="'.$class.' colset'.is_sidebar_active( $id ).'">';
            dynamic_sidebar( $id );
            echo '<div class="clr"></div></div>';

        }
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

    /* or

    function opengraph_doctype( $output ) {
	   return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
	}
	add_filter('language_attributes', 'opengraph_doctype');

    */
    // include wp head
    wp_head();

?>

</head>

    <body <?php body_class(); ?>>

    <div id="pagecontainer" class="site">

        <div id="topcontainer">

            <div id="topbar">

                <div class="outermargin">

                    <div id="logobox">
                        <?php wpstartup_toplogo_html(); ?>
                    </div>


                    <div id="topmenu">

                    <?php // topbar menu is mainmenu & top & primary || default menu
                    $topmenu = array( 'main', 'top', 'primary' );
                    wpstartup_menu_html( $topmenu );
                    ?>



                        <?php
                        wpstartup_widgetarea_html( 'topbar-widget-1' );
                        ?>

                         <?php
                        wpstartup_widgetarea_html( 'topbar-widget-2' );
                        ?>

                    </div>

                    <div class="clr"></div>
                </div>
            </div>
            <!-- header & topbar -->
            <div id="header" class="outermargin">
                <header>



                        <?php
                        wpstartup_widgetarea_html( 'header-widget-1' );
                        ?>

                    <div id="titlebox">
                        <!-- the header title -->
                        <h1 class="sitetitle">
                            <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>
                        </h1>
                        <!-- the subtitle -->
                        <h2 class="subtitle">
                           <?php echo get_bloginfo( 'description' ); ?>
                        </h2>
                    </div>

                    <div class="clr"></div>


                </header>
            </div>
            <div id="subheader" class="outermargin">
                <section>


                        <?php
                        wpstartup_widgetarea_html( 'header-widget-2' );
                        ?>

                    <div id="subheaderbox">
                        <!-- the subheaderbox -->
                        <!--
                        <p>
                           Contact
                           <br />mobiel : 06 46216575
                           <br />kantoor: 026 4457159
                           <br />email: info@scheepsreparatiebedrijfarnhem.nl
                        </p>
                        -->
                    </div>
                    <div class="clr"></div>
                </section>
            </div>
        </div>

        <div id="maincontainer">
            <!-- main content -->
            <div id="content" class="outermargin">

                <section>
                    <!--
                    <div class="columnbox col1_3"><div class="innerpadding"><h3>Reparatie</h3><p>Korte info tekst</p></div></div>
                    <div class="columnbox col1_3"><div class="innerpadding"><h3>Onderhoud</h3><p>Korte info tekst</p></div></div>
                    <div class="columnbox col1_3"><div class="innerpadding"><h3>Nieuwbouw</h3><p>Korte info tekst</p></div></div>
                    -->

                        <?php
                        wpstartup_widgetarea_html( 'topcontent-widget-1' );
                        ?>


                        <?php
                        wpstartup_widgetarea_html( 'topcontent-widget-2' );
                        ?>


                        <?php
                        wpstartup_widgetarea_html( 'before-widget' );
                        ?>

                    <!--
                    <div class="columnbox col2_3"><div class="innerpadding"><h3>Snel Dokken</h3><p>Korte info tekst</p></div></div>
                    <div class="columnbox col1_3"><div class="innerpadding"><h3>Bok</h3></div><p>Korte info tekst</p></div>
                    -->


                        <?php // sidebar menu wp-startup theme
                        wpstartup_menu_html( 'side', true );
                        ?>

                        <?php
                        wpstartup_widgetarea_html( 'after-widget' );
                        ?>


                    <div class="clr"></div>
                </section>

            </div>

        </div>

        <div id="subcontainer">
            <!-- main content -->
            <div id="subcontent" class="outermargin">

                <section>
                    <!--
                    <div class="columnbox col3_5"><div class="innerpadding"><h3>Route</h3><p>Kaartje</p></div></div>
                    <div class="columnbox col2_5"><div class="innerpadding"><h3>Geschiedenis</h3><p>Info tekst</p></div></div>
                    <div class="clr"></div> -->


                        <?php
                        wpstartup_widgetarea_html( 'subcontent-widget-1' );
                        wpstartup_widgetarea_html( 'subcontent-widget-2' );
                        ?>



                </section>

            </div>

        </div>

        <div id="bottomcontainer">
            <!-- footer content -->
            <div id="bottomcontent" class="outermargin">

                <footer>
                    <div id="footerbox">
                        <!-- the footer
                        <div class="columnbox col1_3"><div class="innerpadding"><h4>Diensten</h4><p>tekst/links</p></div></div>
                        <div class="columnbox col1_3"><div class="innerpadding"><h4>Links</h4><p>tekst/links</p></div></div>
                        <div class="columnbox col1_3"><div class="innerpadding"><h4>Contact</h4><p>tekst/links</p></div></div> -->

                        <?php
                        wpstartup_widgetarea_html( 'bottom-widget-1' );
                        wpstartup_widgetarea_html( 'bottom-widget-2' );
                        ?>


                        <div class="clr"></div>


                        <?php // sidebar menu wp-startup theme
                        wpstartup_menu_html( 'bottom' );
                        ?>


                        <div id="footerend">

                            <?php

                                wpstartup_widgetarea_html( 'footer-widget-1' );

                                wpstartup_widgetarea_html( 'footer-widget-2' );

                            ?>

                            <?php // sidebar menu wp-startup theme
                            wpstartup_menu_html( 'social' );
                            ?>

                            <h6>&copy; 2018 Scheepsreparatiebedrijf Arnhem</h6>


                        </div>
                        <div class="clr"></div>
                    </div>
                </footer>

            </div>

        </div>

    </div>

    <?php wp_footer(); ?>

    </body>
</html>
