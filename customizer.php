<?php
/**  WP Startup customizer */
 // add panels
function wp_startup_add_customizer_options_templates(){

        global $wp_customize;


        $wp_customize->remove_control('display_header_text');
        $wp_customize->remove_control('header_video');
        $wp_customize->remove_control('external_header_video');
        $wp_customize->remove_section('colors');


        $wp_customize->add_panel('wp_startup_theme_panel', array(
            'title'    => __('WP startup theme', 'wp-startup'),
            'priority' => 10,
        ));
        // add sections
        $wp_customize->add_section('wp_startup_theme_panel_content', array(
            'title'    => __('Content', 'wp-startup'),
            'panel'  => 'wp_startup_theme_panel',
            'priority' => 120,
        ));
        $wp_customize->add_section('wp_startup_theme_panel_elements', array(
            'title'    => __('Elements', 'wp-startup'),
            'panel'  => 'wp_startup_theme_panel',
            'priority' => 122,
        ));
        $wp_customize->add_section('wp_startup_theme_panel_style', array(
            'title'    => __('Style', 'wp-startup'),
            'panel'  => 'wp_startup_theme_panel',
            'priority' => 124,
        ));

        /* header extend */
        $wp_customize->add_setting( 'wp_startup_theme_header_image_minheight' , array(
		'default' => 200,
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_header_image_minheight', array(
                'label'          => __( 'Header minimal height', 'wp-startup' ),
                'section'        => 'header_image',
                'settings'       => 'wp_startup_theme_header_image_minheight',
                'type'           => 'number',
                'description'    => __( 'Header minimal height in pixels(px) for WP startup themes', 'wp-startup' ),
    	)));
        $wp_customize->add_setting( 'wp_startup_theme_header_image_height' , array(
		'default' => 200,
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_header_image_height', array(
                'label'          => __( 'Header height', 'wp-startup' ),
                'section'        => 'header_image',
                'settings'       => 'wp_startup_theme_header_image_height',
                'type'           => 'number',
                'description'    => __( 'Header height in percentage(%) for WP startup themes', 'wp-startup' ),
    	)));

        $wp_customize->add_setting( 'wp_startup_theme_panel_elements_postheader' , array(
		'default' => 'all',
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_elements_postheader', array(
                'label'          => __( 'Featured Header', 'wp-startup' ),
                'section'        => 'header_image',
                'settings'       => 'wp_startup_theme_panel_elements_postheader',
                'type'           => 'radio',
                'description'    => __( 'Header and featured images (if available) in WP startup themes. Header is displayed ', 'wp-startup' ),
                'choices'        => array(
                    'none'   => __( 'for all content', 'wp-startup' ),
                    'front'  => __( 'on frontpage only', 'wp-startup' ),
                    'post'   => __( 'or replaced by single post featured image (if landscape size)', 'wp-startup' ),
                    'page'   => __( 'or replaced by page featured image (if landscape size)', 'wp-startup' ),
                    'all'    => __( 'or replaced by any page or post featured image (if landscape size)', 'wp-startup' ),
            	)
    	)));


        // Content mods
        $wp_customize->add_setting( 'wp_startup_theme_panel_content_postimage' , array(
		'default' => 'above',
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_content_postimage', array(
                'label'          => __( 'Featured image', 'wp-startup' ),
                'section'        => 'wp_startup_theme_panel_content',
                'settings'       => 'wp_startup_theme_panel_content_postimage',
                'type'           => 'radio',
                'description'    => __( 'Featured image display in WP startup themes (if not replace header)', 'wp-startup' ),
                'choices'        => array(
                    'above'   => __( 'Wide images before title, portrait image besides text', 'wp-startup' ),
                    'left'   => __( 'Left besides title/text', 'wp-startup' ),
                    'right'   => __( 'Right besides title/text', 'wp-startup' ),
                    'inlineleft'   => __( 'Left inline text', 'wp-startup' ),
                    'inlineright'   => __( 'Right inline text', 'wp-startup' ),
            	)
    	)));
        // excerpt length
        $wp_customize->add_setting( 'wp_startup_theme_panel_content_excerptlength', array(
          'default' => 12,
          'sanitize_callback' => 'wp_startup_theme_sanitize_default',
        ) );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_content_excerptlength', array(
          'type' => 'number',
          'section' => 'wp_startup_theme_panel_content', // Add a default or your own section
          'settings'=> 'wp_startup_theme_panel_content_excerptlength',
          'label' => __( 'Excerpt length' ),
          'description' => __( 'Add here the max. amount of words in the post excerpts (intro words for lists).' ),
        )));


        // Elements mods
        $wp_customize->add_setting( 'wp_startup_theme_panel_elements_upperbar' , array(
		'default' => 'show',
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_elements_upperbar', array(
                'label'          => __( 'Upperbar', 'wp-startup' ),
                'section'        => 'wp_startup_theme_panel_elements',
                'settings'       => 'wp_startup_theme_panel_elements_upperbar',
                'type'           => 'select',
                'description'    => __( 'Upperbar menu/contact/identity display in WP startup themes', 'wp-startup' ),
                'choices'        => array(
                    'hide'   => __( 'Hide', 'wp-startup' ),
                    'show'   => __( 'Show', 'wp-startup' ),
            	)
    	)));



        $wp_customize->add_setting( 'wp_startup_theme_panel_elements_sidebar' , array(
		'default' => 'right',
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_elements_sidebar', array(
                'label'          => __( 'Sidebar display', 'wp-startup' ),
                'section'        => 'wp_startup_theme_panel_elements',
                'settings'       => 'wp_startup_theme_panel_elements_sidebar',
                'type'           => 'select',
                'description'    => __( 'Sidebar display in WP startup themes', 'wp-startup' ),
                'choices'        => array(
                    'hide'   => __( 'Hide', 'wp-startup' ),
                    'left'   => __( 'Left', 'wp-startup' ),
                    'right'   => __( 'Right', 'wp-startup' ),
            	)
    	)));

        $wp_customize->add_setting( 'wp_startup_theme_panel_elements_sidebarwidth' , array(
		'default' => 23,
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_elements_sidebarwidth', array(
                'label'          => __( 'Sidebar width', 'wp-startup' ),
                'section'        => 'wp_startup_theme_panel_elements',
                'settings'       => 'wp_startup_theme_panel_elements_sidebarwidth',
                'type'           => 'number',
                'description'    => __( 'Sidebar width in WP startup themes', 'wp-startup' ),
    	)));

        // extend title_tagline

        // logo max-width
        $wp_customize->add_setting( 'wp_startup_theme_panel_content_logowidth', array(
          'default' => 120,
          'sanitize_callback' => 'wp_startup_theme_sanitize_default',
        ) );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_content_logowidth', array(
          'type' => 'number',
          'section' => 'title_tagline', // Add a default or your own section
          'settings'=> 'wp_startup_theme_panel_content_logowidth',
          'label' => __( 'Logo max width' ),
          'description' => __( 'Logo max width in px.' ),
        )));

        // tel number
        $wp_customize->add_setting( 'wp_startup_theme_panel_content_telephone', array(
          'default' => '',
          'sanitize_callback' => 'wp_startup_theme_sanitize_default',
        ) );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_content_telephone', array(
          'type' => 'text',
          'section' => 'title_tagline', // Add a default or your own section
          'settings'=> 'wp_startup_theme_panel_content_telephone',
          'label' => __( 'Telephone' ),
          'description' => __( 'Add here the site main contact telephone number.' ),
        )));

        // email adress
        $wp_customize->add_setting( 'wp_startup_theme_panel_content_email', array(
          'default' => '',
          'sanitize_callback' => 'wp_startup_theme_sanitize_default',
        ) );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_content_email', array(
          'type' => 'text',
          'section' => 'title_tagline', // Add a default or your own section
          'settings'=> 'wp_startup_theme_panel_content_email',
          'label' => __( 'Email' ),
          'description' => __( 'Add here the site main contact email address.' ),
        )));
        // copyright line
        $wp_customize->add_setting( 'wp_startup_theme_panel_content_copyright', array(
          'default' => '',
          'sanitize_callback' => 'wp_startup_theme_sanitize_default',
        ) );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_content_copyright', array(
          'type' => 'text',
          'section' => 'title_tagline', // Add a default or your own section
          'settings'=> 'wp_startup_theme_panel_content_copyright',
          'label' => __( 'Copyright' ),
          'description' => __( 'Add here the site bottom copyright textline.' ),
        )));



}

function wp_startup_theme_sanitize_default( $obj ){
    	return $obj;
}
function wp_startup_theme_sanitize_array( $values ) {
    $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;
    return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}
?>
