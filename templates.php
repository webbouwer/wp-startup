<?php
/*
Source: http://www.wpexplorer.com/wordpress-page-templates-plugin/
*/

class PageTemplater {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Returns an instance of this class.
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new PageTemplater();
		}

		return self::$instance;

	}

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array();


		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);

		} else {

			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);

		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter(
			'wp_insert_post_data',
			array( $this, 'register_project_templates' )
		);


		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		add_filter(
			'template_include',
			array( $this, 'view_project_template')
		);


		// [replace] Add your templates to this array.
		/*$this->templates = array(
			'blank-template.php' => 'Blank 2 Template',
		);
        */

        $templatefolder = WP_PLUGIN_DIR.'/wp-startup/templates/';

        $files=glob( $templatefolder."*.php" );
        foreach ($files as $file) {

            $path = pathinfo($file);
            $this->templates[$path['basename']] = $path['filename'];
        }

        // add customizer customized
        add_action( 'customize_register', array( $this,  'wp_startup_customizer_register_project_templates' ), 11 );

        // add theme theming
        //add_filter('template_include', array( $this ,'wp_startup_template_file_replacements' ) );

	}

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	}

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {

        // hacking the theme

        // Get global post
		global $post;

        // Return page template if we have a custom one defined
		if ( isset( $this->templates[get_post_meta(
			$post->ID, '_wp_page_template', true
		)] ) ) {

            // Get the page template
            $filepath = apply_filters( 'page_templater_plugin_dir_path',  plugin_dir_path( __FILE__ ) .'templates/' );

            $file =  $filepath . get_post_meta(
                $post->ID, '_wp_page_template', true
            );

            // Just to be safe, we check if the file exist first
            if ( file_exists( $file ) ) {
                return $file;
            } else {
                echo $file;
            }

		}

        // get theme settings from customizer option (or plugin)


        // otherwise load the basic theme
        $template = plugin_dir_path( __FILE__ ) .'templates/basic-template.php';

        return $template;

        /*
		// Return the search template if we're searching (instead of the template for the first result)
		if ( is_search() ) {
			return $template;
		}

		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta(
			$post->ID, '_wp_page_template', true
		)] ) ) {
			return $template;
		}

		// Allows filtering of file path
        $filepath = apply_filters( 'page_templater_plugin_dir_path',  plugin_dir_path( __FILE__ ) .'templates/' );


		$file =  $filepath . get_post_meta(
			$post->ID, '_wp_page_template', true
		);

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;
        */
	}


    /**
     * Inject template files to replace common files

    public function wp_startup_template_file_replacements( $template ){

        // source above and  https://wordpress.stackexchange.com/questions/72544/how-can-i-use-a-file-in-my-plugin-as-a-replacement-for-single-php-on-custom-post

        if(  !is_front_page() && 'single-post.php' != $template ){ // catch all other than pages //..is_singular('post')

            $template = plugin_dir_path( __FILE__ ) .'templates/basic-template.php';

        }
        return $template;

    }
    */

     /**
     * Adjust customizer
     * https://kb.wpbeaverbuilder.com/article/357-remove-a-customizer-panel
     */
    public function wp_startup_customizer_register_project_templates() {

        global $wp_customize;
        // default sections: title_tagline, colors, header_image, background_image, nav, and static_front_page
        //$wp_customize->remove_control('display_header_text');
        //$wp_customize->remove_section('colors');

        // add panels
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

        // tel number
        $wp_customize->add_setting( 'wp_startup_theme_panel_content_telephone', array(
          'default' => '',
          'sanitize_callback' => 'wp_startup_theme_sanitize_default',
        ) );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'wp_startup_theme_panel_content_telephone', array(
          'type' => 'text',
          'section' => 'wp_startup_theme_panel_content', // Add a default or your own section
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
          'section' => 'wp_startup_theme_panel_content', // Add a default or your own section
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
          'section' => 'wp_startup_theme_panel_content', // Add a default or your own section
          'settings'=> 'wp_startup_theme_panel_content_copyright',
          'label' => __( 'Copyright' ),
          'description' => __( 'Add here the site bottom copyright textline.' ),
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

        // post excerpt length



        // Style mods

        // title settings

        // - #titlebox display (header title / tekst) none left center right

        // fonts:
        //   h1.sitetitle
        //   h2.subtitle

        //   #content  h1.entry-title, h2.entry-title (pagecontent titles)

        //   h2.widget-title, h3.widget-titlebox (widget titles)

        //


    }


}
