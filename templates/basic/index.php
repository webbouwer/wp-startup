<?php
// remove the default common theme styles (comment out to keep)
add_action('wp_print_styles', 'wp_startup_theme_deregister_func', 100);

// theme html output menu's by name (str or array)
// theme html output menu's by name (str or array)
function wpstartup_menu_html( $menu ){
    if( $menu != '' || is_array( $menu ) ){
        if( is_array( $menu ) ){
            // multi menu
            foreach( $menu as $nm ){

                if( has_nav_menu( $nm ) ){
                    echo '<div id="'.$nm.'menubox"><div id="'.$nm.'menu" class=""><nav><div class="innerpadding">';
                    wp_nav_menu( array( 'theme_location' => $nm , 'menu_class' => 'nav-menu' ) );
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
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
    // the current page/post data
    global $post;
    // full meta
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
        // including post featured image or default header image
        $header_image = get_header_image();
        if( has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
            $header_image = esc_attr( $thumbnail_src[0] );
		}
    /*-- wp head output start --*/

        wp_head();

    /*-- wp head output end --*/

    //echo '<script type="text/javascript" src="'.get_site_url().'/wp-includes/js/jquery/jquery.js?ver=1.4.1"></script>';
    //echo '<script type="text/javascript" src="'.get_site_url().'/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1"></script>';
    if ( ! isset( $content_width ) ) $content_width = 360; // mobile first
    echo '<link rel="stylesheet" id="wp-startup-theme-style"  href="'.plugins_url().'/wp-startup/templates/basic/style.css" type="text/css" media="all" />';
?>
<script>
jQuery( function($){
    var menu = $('#topmenubox .nav-menu');
    var items = $('#topmenubox .nav-menu a');
    menu.after('<div id="slidemenutoggle">menu</div>');

    menu.animate({ opacity : 0 }, 'fast', function() {
                items.hide();
                $('#slidemenutoggle').html('menu');
                menu.css({ 'bottom' : '-100%'  });
    });

    $('#slidemenutoggle').toggle(
        function() {

            menu.css({ 'bottom' : '0px'  });

            var c = 0;
            items.each( function( idx,obj ){
                c++;
                setTimeout(function(){
                    $(obj).fadeIn(600);
                }, c * 100);
            });

            menu.animate({ opacity: 1 }, 300, function() {
                $('#slidemenutoggle').html('close');
            });
        },
        function() {

            menu.css({ 'bottom' : '0px'  });
            var c = 0;
            items.each( function( idx,obj ){
                c++;
                setTimeout(function(){
                    $(obj).fadeOut(300);
                }, 300 / c);
            });
            setTimeout(function(){
                menu.animate({ opacity: 0 }, 300, function() {
                    $('#slidemenutoggle').html('menu');
                    menu.css({ 'bottom' : '-100%'  });
                });
            }, 600 );
        }
    );

    $(document).ready( function(){


    });
});
</script>
</head>
<body <?php body_class(); ?>>

    <div id="pagecontainer">

        <div id="topcontainer">
        <?php
        echo '<div id="toplogobox">';
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
        echo '</div>';
        if( has_nav_menu('top') || has_nav_menu('primary') ){
                    // topbar menu is top & primary || default menu
                    $topmenu = array( 'top', 'primary' );
                    wpstartup_menu_html( $topmenu );
        }else{
        echo '<div id="topmenubox">';
            wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) );
        echo '<div class="clr"></div></div>';
        }
        ?>
        </div>

        <?php if ( isset($header_image) && $header_image != ''){
        echo  '<div id="headercontainer" class="header_image" style="background-image:url('.$header_image.');background-position:center;background-size:cover;min-height:90px;">';

        echo '<div class="clr"></div></div>';
        }

        echo '<div id="maincontainer" class="'.get_theme_mod('page_layout', 'one-column').'"><div class="outermargin"><div id="maincontentbox">';


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
                                            //echo get_the_post_thumbnail( get_the_ID(), 'big-thumb', array( 'class' => 'post-image' ));

                                            ?>

                                            <header class="entry-header">
                                                <?php if( is_single() || is_page() ){
                                                    echo '<h2 class="entry-title">'.get_the_title().'</h2>';
                                                }else{
                                                    echo '<h2 class="entry-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
                                                }?>
                                            </header>

                                            <div class="entry-content">
                                            <?php
                                            if( is_single() || is_page() ){
                                                echo get_the_content();
                                            }else{
                                                echo '<p>';
                                                wp_startup_the_excerpt_length( 15, true );  // the_excerpt();
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


                echo '<div class="clr"></div></div>';

                echo '<div id="sidecontentbox">';

                    if( has_nav_menu('side') ){
                    echo '<div id="sidemenu">';
                        // side menu
                        wpstartup_menu_html( 'side' );
                    echo '<div class="clr"></div></div>';
                    }

                    dynamic_sidebar('sidebar');

                echo '<div class="clr"></div></div>';


                echo '<div class="clr"></div></div></div>';
        ?>

        <div id="bottomcontainer">
        </div>

    </div>

    <?php wp_footer(); ?>
</body>
