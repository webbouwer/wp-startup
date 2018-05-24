<?php

function wp_startup_theme_post_title(){
    if( is_single() || is_page() ){
        echo '<h2 class="entry-title">'.get_the_title().'</h2>';
    }else{
        echo '<h2 class="entry-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
    }
}

function wp_startup_theme_post_content(){
    if( is_single() || is_page() ){
        the_content();
    }else{
        echo '<p>';
        the_excerpt_length( 8, false );  //the_excerpt();
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


?>
<div class="outermargin">

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

                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="display:none;">

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

                    //wpstartup_widgetarea_html( 'after-widget' );

                    ?>
                    <div class="clr"></div>
            </div>
        </section>
    </div>

    <div id="sidebar">
        <?php // sidebar menu wp-startup theme
            wpstartup_menu_html( 'side' ); // make this default page menu: wpstartup_menu_html( 'side', true );
            wpstartup_widgetarea_html( 'sidebar-1', 'sidebar' );
        ?>
        </div>
    <div class="clr"></div>
</div>
