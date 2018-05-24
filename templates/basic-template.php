<?php
/**
 * Template name: Onepage Template
 * Description: A one-page template to make a great singlepage website.
 */
// remove the default common theme styles (comment out to keep)
add_action('wp_print_styles', 'wp_startup_theme_deregister_func', 100);
// Add theme stylesheet link to wp_head
add_action( 'wp_head', 'wpstartup_theme_stylesheet', 9997 );

function wpstartup_theme_stylesheet(){

    $stylesheet = str_replace('-template.php', '', basename(__FILE__) ) . '-style.css';
    if( plugins_url( $stylesheet , __FILE__ ) ){
        echo '<link rel="stylesheet" id="wp-startup-basic-style"  href="'.plugins_url( $stylesheet , __FILE__ ).'" type="text/css" media="all" />';
    }

}

// the current page/post data
global $post;

// determine theme mods
$header_image = get_header_image();
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
// page functions
function wp_startup_theme_post_title(){
    if( is_single() || is_page() ){
        echo '<h2 class="entry-title">'.get_the_title().'</h2>';
    }else{
        echo '<h2 class="entry-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
    }
}
// full content or excerpt
function wp_startup_theme_post_content(){
    if( is_single() || is_page() ){
        the_content();
    }else{
        $excerpt_length = get_theme_mod('wp_startup_theme_panel_content_excerptlength', 12);
        echo '<p>';
        the_excerpt_length( $excerpt_length, true );  //the_excerpt();
        echo '</p>';
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
                echo '<div id="'.$id.'" class="'.$class.'">';
            }else{
                echo '<div id="'.$id.'" class="'.$class.' columnbox colset'.is_sidebar_active( $id ).'">';
            }
            dynamic_sidebar( $id );
            echo '<div class="clr"></div></div>';
        }
    }
}
// twentyseven frontpage sections
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

        } else if( is_customize_preview() ){

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
<style type="text/css">
#titlebox,
#titlebox .sitetitle,
#titlebox .subtitle
{
    color:#<?php echo esc_attr( $header_text_color ); ?>;
}
</style>
</head>
<body <?php body_class(); ?>>
    <div id="pagecontainer" class="site">

        <div id="topcontainer">

            <!-- header & topbar -->
            <?php // show hide topbar
            if( get_theme_mod( 'wp_startup_theme_panel_elements_topbar','') != 'hide' ){
            ?>
            <div id="topbar">
                <div class="outermargin">
                    <?php
                        wpstartup_widgetarea_html( 'topbar-widget-1' );
                    ?>
                    <div id="logobox">
                        <?php wpstartup_toplogo_html(); ?>
                    </div>
                    <div id="contactbox">
                    <?php
                        $tel =  get_theme_mod('wp_startup_theme_panel_content_telephone', '');
                        $email =  get_theme_mod('wp_startup_theme_panel_content_email', '');
                        if( $tel != '' ){
                            echo '<div class="telephone_textline"><a href="tel:'.$tel.'">'.$tel.'</a></div>';
                        }
                        if( $email != '' ){
                            echo '<div class="email_textline"><a href="mailto:'.$email.'">'.$email.'</a></div>';
                        }
                    ?>
                    </div>
                    <div id="topmenu">
                        <?php // topbar menu is mainmenu & top & primary || default menu
                            $topmenu = array( 'main', 'top', 'primary' );
                            wpstartup_menu_html( $topmenu );
                        ?>
                    </div>
                        <?php
                            wpstartup_widgetarea_html( 'topbar-widget-2' );
                        ?>
                    <div class="clr"></div>
                </div>
            </div>
            <?php } // end topbar ?>
            <?php
            // div header
                if ( get_header_image() ){
                    echo  '<div id="header" class="header_image" style="background-image:url('.get_theme_mod('header_image').');background-position:center;">';
                }else{
                    echo '<div id="header">';
                }
            ?>
                <div class="outermargin">
                    <header>
                        <?php
                            if( is_sidebar_active( 'header-widget-1' ) ){

                                wpstartup_widgetarea_html( 'header-widget-1' );

                            }else{
                        ?>
                        <div id="titlebox">
                            <!-- the header title -->
                            <h1 class="sitetitle">
                            <?php
                                echo esc_attr( get_bloginfo( 'name', 'display' ) );
                            ?>
                            </h1>
                            <!-- the subtitle -->
                            <h2 class="subtitle">
                            <?php
                                echo get_bloginfo( 'description' );
                            ?>
                            </h2>
                        </div>
                        <?php } ?>
                        <div class="clr"></div>
                    </header>
                </div>

            </div><!-- end div header (background) -->
            <?php
                if( is_sidebar_active( 'header-widget-2' ) ){
            ?>
            <div id="subheader" class="outermargin">
                <section>
                    <div id="subheaderbox">
                        <!-- the subheaderbox -->
                        <?php
                            wpstartup_widgetarea_html( 'header-widget-2' );
                        ?>
                    </div>
                    <div class="clr"></div>
                </section>
            </div>
            <?php } ?>

        </div><!-- end topcontainer -->

        <div id="maincontainer">


            <div id="topcontent" class="outermargin">

                <?php
                wpstartup_widgetarea_html( 'topcontent-widget-1' );
                ?>

            </div>


            <?php if( is_front_page() && get_theme_mod('page_layout') == 'one-column'){
                // Get panels on top
                wp_startup_get_frontpage_sections();
                echo '<div class="clr"></div>';
            }

            ?>

            <div id="maincontent" class="outermargin">


                <?php
                wpstartup_widgetarea_html( 'topcontent-widget-2' );
                ?>


                <!-- main content -->
                <div id="content">
                    <section>
                        <div id="maincontentbox">
                            <?php
                                wpstartup_widgetarea_html( 'before-widget' );
                                if( have_posts() ) {
                                    while( have_posts() ) {
                                        the_post();
                                        ?>
                                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                            <header class="entry-header">
                                                <?php wp_startup_theme_post_title(); ?>
                                            </header>
                                            <div class="entry-content">
                                                <?php wp_startup_theme_post_content(); ?>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                }
                                wpstartup_widgetarea_html( 'after-widget' );
                            ?>
                            <div class="clr"></div>
                            <?php
                                if( is_front_page() && get_theme_mod('page_layout') == 'two-column'){
                                    // Get panels here
                                    wp_startup_get_frontpage_sections();
                                    echo '<div class="clr"></div>';
                                }
                            ?>
                        </div>
                    </section>
                </div>
                <div id="sidebar">
                    <?php // sidebar menu wp-startup theme
                        wpstartup_menu_html( 'side' ); // make this default page menu: wpstartup_menu_html( 'side', true );
                        wpstartup_widgetarea_html( 'dynamic-sidebar', 'sidebar' );
                    ?>
                </div>
                <div class="clr"></div>
            </div>
            <div id="subcontainer">
                <!-- sub content -->
                <div id="subcontent" class="outermargin">
                    <section>
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
                            <?php
                                wpstartup_widgetarea_html( 'bottom-widget-1' );

                                wpstartup_widgetarea_html( 'bottom-widget-2' );
                            ?>
                            <div class="clr"></div>
                            <?php
                                wpstartup_menu_html( 'bottom' );
                            ?>
                            <div class="clr"></div>
                        </div>
                        <div id="footerend">
                            <?php if( has_)
                                wpstartup_widgetarea_html( 'footer-widget-1' );
                                wpstartup_widgetarea_html( 'footer-widget-2' );
                            ?>
                            <div class="clr"></div>
                            <?php // sidebar menu wp-startup theme
                                wpstartup_menu_html( 'social' );
                            ?>
                            <?php
                                $copyright_textline = get_theme_mod('wp_startup_theme_panel_content_copyright', 'Copyright 2018');
                                echo '<h6>'.$copyright_textline.'</h6>';
                            ?>
                            <div class="clr"></div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>

</body>
</html>
