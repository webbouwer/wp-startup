<?php
// remove the default common theme styles (comment out to keep)
add_action('wp_print_styles', 'wp_startup_theme_deregister_func', 100);

// Add theme stylesheet link to wp_head
add_action( 'wp_head', 'wpstartup_theme_stylesheet', 9999 );

function wpstartup_theme_stylesheet(){
    $stylesheet = plugins_url().'/wp-startup/templates/basic/style.css';
    echo '<link rel="stylesheet" id="wp-startup-theme-style"  href="'.$stylesheet.'" type="text/css" media="all" />';
}


// the current page/post data
global $post;

// determine header image
$header_image = get_header_image();

// header textcolor
$header_text_color = get_header_textcolor();

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
function wpstartup_menu_html( $menu ){
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
        }
    }
}

// theme html output widget area's by type or default
function wpstartup_widgetarea_html( $id, $type = false ){
    if( isset($id) && $id != '' ){
        if( function_exists('dynamic_sidebar') && function_exists('wp_startup_is_sidebar_active') && wp_startup_is_sidebar_active( $id ) ){
            $class = 'widgetbox';
            if( isset($type) && $type != '' ){
                $class = 'widgetbox widget-'.$type;
                echo '<div id="'.$id.'" class="'.$class.'">';
            }else{
                echo '<div id="'.$id.'" class="'.$class.' columnbox colset'.wp_startup_is_sidebar_active( $id ).'">';
            }
            dynamic_sidebar( $id );
            echo '<div class="clr"></div></div>';
        }else if( is_customize_preview() ){

            echo '<div id="'.$id.'" class="customizer-placeholder"> -- Widget area '.$id.' -- </div>';

        }
    }
}
// to use twentyseven frontpage sections
function wp_startup_get_frontpage_sections(){
    $my_theme = wp_get_theme();
    if ( $my_theme->get( 'Name' ) ==  'Twenty Seventeen' ){
         if ( 0 !== twentyseventeen_panel_count()  ){ // ||  If we have pages to show.
            $num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
            global $twentyseventeencounter;
            for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
                $twentyseventeencounter = $i;
                twentyseventeen_front_page_section( null, $i );
            }
        }else if( is_customize_preview() ){
            echo '<div align="center"> -- Customizer > Theme options:  add info sections -- </div>';
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
    // include wp head
    wp_head();

?>
</head>
<body <?php body_class(); ?>>
     <div id="pagecontainer" class="site">


                <?php

                // upperbar
                if( get_theme_mod('wp_startup_theme_panel_elements_upperbar', 'hide') == 'show'){
                    echo '<div id="upperbar"><div class="outermargin">';

                    if( get_theme_mod('wp_startup_theme_panel_content_email', '') != '' || get_theme_mod('wp_startup_theme_panel_content_telephone', '') != ''){
                        echo '<div id="contactbox">';
                            if( get_theme_mod('wp_startup_theme_panel_content_email', '') != ''){
                            echo '<a class="emaillink" href="mailto:'.get_theme_mod('wp_startup_theme_panel_content_email').'">'.get_theme_mod('wp_startup_theme_panel_content_email').'</a>';
                            }
                            if( get_theme_mod('wp_startup_theme_panel_content_telephone', '') != ''){
                            echo '<a class="tellink" href="tel:'.get_theme_mod('wp_startup_theme_panel_content_telephone').'">'.get_theme_mod('wp_startup_theme_panel_content_telephone').'</a>';
                            }
                        echo '<div class="clr"></div></div>';
                    }
                    echo '<div class="clr"></div></div></div>';
                }

                echo '<div id="topbar"><div class="outermargin">';

                if( wp_startup_is_sidebar_active( 'topbar-widget-1' ) ){
                    wpstartup_widgetarea_html( 'topbar-widget-1' );
                }

                // topbar logo
                echo '<div id="toplogobox">';
                wpstartup_toplogo_html();
                echo '</div>';

                // topbar menu
                if( has_nav_menu('top') || has_nav_menu('primary') ){
                    // topbar menu is top & primary || default menu
                    $topmenu = array( 'top', 'primary' );
                    wpstartup_menu_html( $topmenu );
                }

                // topbar side widgets
                if( wp_startup_is_sidebar_active( 'topbar-widget-2' ) ){
                    wpstartup_widgetarea_html( 'topbar-widget-2' );
                }
                echo '<div class="clr"></div></div></div>';

                // div header
                if ( get_header_image() ){
                    echo  '<div id="header" class="header_image" style="background-image:url('.get_theme_mod('header_image').');background-position:center;min-height:90px;">';
                }else{
                    echo '<div id="header">';
                }
                echo '<div class="outermargin">';
                if( wp_startup_is_sidebar_active( 'header-widget-1' ) ){
                wpstartup_widgetarea_html( 'header-widget-1' );
                }
                if( wp_startup_is_sidebar_active( 'header-widget-2' ) ){
                wpstartup_widgetarea_html( 'header-widget-2' );
                }
                echo '<div class="clr"></div></div></div>';

                echo '<div id="topcontent"><div class="outermargin">';

                        wpstartup_widgetarea_html( 'topcontent-widget-1' );

                        if( has_nav_menu('main') ){ ?>
                        <div id="mainmenu">
                            <?php // main menu
                            wpstartup_menu_html( 'main' );
                            ?>
                        </div>
                        <?php }

                        wpstartup_widgetarea_html( 'topcontent-widget-2' );

                 echo '<div class="clr"></div></div></div>';

                if( is_front_page() && get_theme_mod('page_layout') == 'one-column'){
                    // Get panels on top
                    wp_startup_get_frontpage_sections();
                    echo '<div class="clr"></div>';
                }

                echo '<div id="maincontainer"><div class="outermargin"><div id="maincontent">';


                   if( wp_startup_is_sidebar_active( 'before-widget' ) ){ ?>
                    <div id="before-content">
                        <?php wpstartup_widgetarea_html( 'before-widget' ); ?>
                    </div>
                    <?php } ?>

                    <section>
                    <?php

                                if( have_posts() ) {
                                    while( have_posts() ) {
                                        the_post();
                                        ?>
                                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                            <?php
                                            //the_post_thumbnail('big-thumb');
                                            echo get_the_post_thumbnail( get_the_ID(), 'big-thumb', array( 'class' => 'post-image' ));

                                            ?>

                                            <header class="entry-header">
                                                <?php if( is_single() || is_page() ){
                                                    echo '<h2 class="entry-title">'.get_the_title().'</h2>';
                                                }else{
                                                    echo '<h2 class="entry-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
                                                }
                                                echo '<span class="date">'.wp_startup_time_ago(get_the_time( 'U' )).'</span>';

                                                ?>
                                            </header>

                                            <div class="entry-content">
                                            <?php
                                            if( is_single() || is_page() ){
                                                echo get_the_content();
                                            }else{
                                                echo '<p>';
                                                $textlength = get_theme_mod('wp_startup_theme_panel_content_excerptlength', 15);
                                                //wp_startup_the_excerpt_length( $textlength, true );  // the_excerpt();
                                                $content = apply_filters('the_content', get_the_content() );
                                                echo wp_startup_truncate( $content, $textlength, '', false, true );
                                                echo '</p>';
                                            }
                                            ?>
                                            </div>


                                        </article>
                                        <?php
                                    }
                                }
                        ?>
                        </section>

                        <?php if( wp_startup_is_sidebar_active( 'after-widget' ) ){ ?>
                        <div id="after-content">
                            <?php wpstartup_widgetarea_html( 'after-widget' ); ?>
                        </div>
                        <?php }
                            //
                            if( is_front_page() && get_theme_mod('page_layout') == 'two-column'){
                                // Get panels here
                                wp_startup_get_frontpage_sections();
                                echo '<div class="clr"></div>';
                            }

                echo '<div class="clr"></div></div>';

                echo '<div id="sidecontent">';

                    echo '<div id="sidemenu">';
                    if( has_nav_menu('side') ){
                        // main menu
                        wpstartup_menu_html( 'side' );
                    }else{
                        wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) );
                    }

                    if( wp_startup_is_sidebar_active( 'sidebar-widget' ) ){ ?>
                    <div id="sidebarcontent">
                        <?php wpstartup_widgetarea_html( 'sidebar-widget' ); ?>
                    </div>
                    <?php }

                    echo '<div class="clr"></div></div>';

                echo '<div class="clr"></div></div>';


                echo '<div class="clr"></div></div></div>';


                echo '<div id="subcontainer"><div class="outermargin"><div id="subcontent">';
                wpstartup_widgetarea_html( 'subcontent-widget-1' );
                wpstartup_widgetarea_html( 'subcontent-widget-2' );
                echo '<div class="clr"></div></div></div></div>';
                ?>

                <?php

                echo '<div id="footercontainer"><div class="outermargin"><div id="footercontent">';
                wpstartup_widgetarea_html( 'bottom-widget-1' );
                wpstartup_widgetarea_html( 'bottom-widget-2' );

                if( has_nav_menu('bottom') ){
                    // main menu
                    wpstartup_menu_html( 'bottom' );
                }

                echo get_theme_mod('wp_startup_theme_panel_content_copyright', 'copyright 2018');

                wpstartup_widgetarea_html( 'footer-widget-1' );
                wpstartup_widgetarea_html( 'footer-widget-2' );
                echo '<div class="clr"></div></div></div></div>';
                ?>

    </div>
    <?php wp_footer(); ?>
</body>
</html>
