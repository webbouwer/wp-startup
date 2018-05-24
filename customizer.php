<?php
/**  WP Startup customizer */

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
    // dynamic sidebar
    register_sidebar( array(
        'name' => __( 'Dynamic sidebar', 'wp-startup' ),
        'id' => 'dynamic-sidebar',
        'description'   => 'Dynamic widgets sidebar loaded with posts',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '<div class="clr"></div></div></div>',
        'before_title'  => '<div class="widget-titlebox"><h3>',
        'after_title'   => '</h3></div><div class="widget-contentbox">'
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

?>
