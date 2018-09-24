<?php
/**  WP Startup customizer */
 // add panels
function wp_startup_add_customizer_options_templates(){

        global $wp_customize;


        $wp_customize->remove_control('display_header_text');
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

        // Content mods
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
        $wp_customize->add_setting( 'wp_startup_theme_panel_elements_topbar' , array(
		'default' => 'show',
		'sanitize_callback' => 'wp_startup_theme_sanitize_default',
    	));
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_elements_topbar', array(
                'label'          => __( 'Topbar', 'wp-startup' ),
                'section'        => 'wp_startup_theme_panel_elements',
                'settings'       => 'wp_startup_theme_panel_elements_topbar',
                'type'           => 'select',
                'description'    => __( 'Topbar display in WP startup page themes', 'wp-startup' ),
                'choices'        => array(
                    'hide'   => __( 'Hide', 'wp-startup' ),
                    'show'   => __( 'Show', 'wp-startup' ),
            	)
    	)));


        // extend title_tagline

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
