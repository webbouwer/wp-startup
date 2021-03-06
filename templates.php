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
	 * The array of templates customizer files belonging to the tracked templates.
	 */
	public $customizers;

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
		// [replaced] Add your templates to this array.
		/*$this->templates = array(
			'blank-template.php' => 'Blank 2 Template',
		);
        */
        $templatefolder = WP_PLUGIN_DIR.'/wp-startup/templates/';
        $dirs = array_filter( glob( $templatefolder."*" ), 'is_dir');

        foreach ($dirs as $themefolder) {
            $path = pathinfo( $themefolder );
            $this->templates[ $path['basename']."/index.php" ] = $path['filename'];
        }

        // add customizer customized options
        add_action( 'customize_register', array( $this,  'wp_startup_customizer_register_project_templates' ), 11 );

        //wp_startup_customizer_register_project_templates
        // enable this function disable blank pages (without post loops)
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
		// and activate template options accoordingly

        if ( isset( $this->templates[get_post_meta(
			$post->ID, '_wp_page_template', true
		)] )
           ) {
            // Get the page template
            $filepath = apply_filters( 'page_templater_plugin_dir_path',  plugin_dir_path( __FILE__ ) .'templates/' );
            $file =  $filepath . get_post_meta(
                $post->ID, '_wp_page_template', true
            );
            // Just to be safe, we check if the file exist first
            if ( file_exists( $file ) ) {
                //return $file;
                $template = $file;
            } //else {
                //echo $file;
            //}



		}else if( get_option( 'wp_startup_maintheme_option' ) != '' && get_option( 'wp_startup_maintheme_option' ) != '0' && get_option( 'wp_startup_maintheme_option' ) != '1'){

            // get theme settings
            // theme overwrite on?
            // from customizer option (or plugin)
            // load the basic theme if selected
            $template = plugin_dir_path( __FILE__ ) .'templates/'.get_option( 'wp_startup_maintheme_option' ).'/index.php';
        }

		// Return template
		return $template;

	}
    /**
     * Inject template files to replace common files

    public function wp_startup_template_file_replacements( $template ){
        // source above and  https://wordpress.stackexchange.com/questions/72544/how-can-i-use-a-file-in-my-plugin-as-a-replacement-for-single-php-on-custom-post

        if(  !is_front_page() && 'single-post.php' != $template ){ // catch all other than pages //..is_singular('post')
            $template = plugin_dir_path( __FILE__ ) .'templates/basic/index.php';
        }
        return $template;
    }
     */


     /**
     * Adjust customizer
     * https://kb.wpbeaverbuilder.com/article/357-remove-a-customizer-panel
     */
    public function wp_startup_customizer_register_project_templates() {

        // load customizer options
        require_once( 'customizer.php' );
        wp_startup_add_customizer_options_templates();


    }
}

