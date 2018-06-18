<?php
class WPstartupData{

    /** @var pages[] */
    public $pages = [];

    /** @var sections[] */
    public $sections = [];

    /** @var options[] */
    public $options = [];



    /** @var new data */
    public function WPstartupData(){

        $this->WPstartup_data_pages();

        $this->WPstartup_data_sections();

        $this->WPstartup_data_options();

    }

    /** @pages data */
    public function WPstartup_data_pages(){

        $pages = array(

            'wp_startup_optionpage' => array(

                'title' => 'WP startup plugin options',
                'menu_title' => 'WP Startup',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_optionpage',
                'parent_slug' => 'wp_startup_optionpage', // 'options-general.php',
                'icon_url' => 'dashicons-editor-kitchensink',
                'position' => 60

            ),
            'wp_startup_option_subpage1' => array(

                'title' => 'WP startup custom options',
                'menu_title' => 'Develop',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_option_subpage1',
                'parent_slug' => 'wp_startup_optionpage',
            ),
            'wp_startup_option_subpage2' => array(

                'title' => 'WP startup tweak',
                'menu_title' => 'Tweak',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_option_subpage2',
                'parent_slug' => 'wp_startup_optionpage',
            ),
        );
        $this->pages = $pages;

    }

    /** @sections data */
    public function WPstartup_data_sections(){

        $sections = array(

            'global_section' => array(
                'id'=>'global_section',
                'title'=>'Global Settings',
                'page'=>'wp_startup_optionpage'
            ),
            'theme_section' => array(
                'id'=>'theme_section',
                'title'=>'Theme',
                'page'=>'wp_startup_optionpage'
            ),
            'widget_section' => array(
                'id'=>'widget_section',
                'title'=>'Widget',
                'page'=>'wp_startup_optionpage'
            ),
            'component_section' => array(
                'id'=>'component_section',
                'title'=>'Component',
                'page'=>'wp_startup_optionpage'
            ),
            'extend_section' => array(
                'id'=>'extend_section',
                'title'=>'Extend',
                'page'=>'wp_startup_optionpage'
            ),
            'sub1_section' => array(
                'id'=>'sub1_section',
                'title'=>'Developer options',
                'page'=>'wp_startup_option_subpage1'
            ),
            'development_section' => array(
                'id'=>'development_section',
                'title'=>'Development',
                'page'=>'wp_startup_option_subpage1'
            ),
            'sub2_section' => array(
                'id'=>'sub2_section',
                'title'=>'Tweaks for wordpress',
                'page'=>'wp_startup_option_subpage2'
            ),
            'overhead_section' => array(
                'id'=>'overhead_section',
                'title'=>'Overhead',
                'page'=>'wp_startup_option_subpage2'
            ),
            'tweak_section' => array(
                'id'=>'tweak_section',
                'title'=>'Tweak',
                'page'=>'wp_startup_option_subpage2'
            ),


        );
        $this->sections = $sections;

    }

    /** @options data */
    public function WPstartup_data_options(){

        $options = array(
            'wp_startup_pagethemes_option' => array(

                'id'=>'wp_startup_pagethemes_option',
                'title'=>'Page Themes',
                'page'=>'wp_startup_optionpage',
                'section'=>'theme_section'

            ),
            'wp_startup_maintheme_option' => array(

                'id'=>'wp_startup_maintheme_option',
                'title'=>'WP Startup Theme',
                'page'=>'wp_startup_optionpage',
                'section'=>'theme_section'

            ),
            'wp_startup_widgets_option' => array(

                'id'=>'wp_startup_widgets_option',
                'title'=>'Widgets',
                'page'=>'wp_startup_optionpage',
                'section'=>'widget_section'

            ),
            'wp_startup_shortcodeintextwidget_option' => array(

                'id'=>'wp_startup_shortcodeintextwidget_option',
                'title'=>'Shortcode in textwidget',
                'page'=>'wp_startup_optionpage',
                'section'=>'widget_section'

            ),
            'wp_startup_linkmanager_option' => array(

                'id'=>'wp_startup_linkmanager_option',
                'title'=>'Link Manager component',
                'page'=>'wp_startup_optionpage',
                'section'=>'component_section'

            ),
            'wp_startup_menu_images_option' => array(
                'id'=>'wp_startup_menu_images_option',
                'title'=>'Menu images',
                'page'=>'wp_startup_optionpage',
                'section'=>'extend_section'
            ),
            'wp_startup_phpintextwidget_option' => array(

                'id'=>'wp_startup_phpintextwidget_option',
                'title'=>'PHP in textwidget',
                'page'=>'wp_startup_option_subpage1',
                'section'=>'sub1_section'

            ),
            'wp_startup_addcustomcss_option' => array(

                'id'=>'wp_startup_addcustomcss_option',
                'title'=>'CSS code',
                'page'=>'wp_startup_option_subpage1',
                'section'=>'development_section'

            ),
            'wp_startup_addcustomjs_option' => array(

                'id'=>'wp_startup_addcustomjs_option',
                'title'=>'JS code',
                'page'=>'wp_startup_option_subpage1',
                'section'=>'development_section'

            ),
            'wp_startup_categoryhierarchy_option' => array(

                'id'=>'wp_startup_categoryhierarchy_option',
                'title'=>'Category Hierarchy',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'overhead_section'

            ),
            'wp_startup_dumbemoji_option' => array(

                'id'=>'wp_startup_dumbemoji_option',
                'title'=>'Remove Emoji junk',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'tweak_section'

            ),
            'wp_startup_removegravatar_option' => array(

                'id'=>'wp_startup_removegravatar_option',
                'title'=>'Remove Gravatar stuff',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'tweak_section'

            )


            //..
        );

        $this->check_options_value( $options );

    }




    /** @get_option value check */
    public function check_options_value( $options ){

        foreach($options as $id => $option ){
            if( !isset( $option['value'] ) ){
                $options[ $option['id'] ]['value'] = get_option( $option['id'] );
            }
        }
        $this->options = $options;
    }



    /** @var pages[] return  */
    public function get_wpstartup_pages(){

        $this->WPstartup_data_pages(); // latest data

        if( is_array( $this->pages ) && count( $this->pages ) > 0 ){
            return $this->pages;
        }else{
            return false;
        }

    }

    /** @var sections[] return */
    public function get_wpstartup_sections(){

        $this->WPstartup_data_sections(); // latest data

        if( is_array( $this->sections ) && count( $this->sections ) > 0 ){
            return $this->sections;
        }else{
            return false;
        }

    }

    /** @var options[] return */
    public function get_wpstartup_options(){

        $this->WPstartup_data_options(); // latest data

        if( is_array( $this->options ) && count( $this->options ) > 0 ){
            return $this->options;
        }else{
            return false;
        }

    }


    /** TODO - oop these functions by data arrays

    /** 1a. Page settings (page id + _html) */

    /** 1b. Settings section functions (related to section['id'] + _settings_description ) */

    /** 2a. Option setting functions (related to option['id'] + _setting_field ) */

    /** 2b. Option usage functions (related to option['id'] + _init ) */


    /**
     * Option page form html functions (option pages)
     */

    // main optionpage
    function wp_startup_optionpage_html() {
        // !page 1? => oop from sections array for more pages
        echo '<div class="wrap"><h1>WP startup options</h1><form method="post" action="options.php">';
        // display all sections for plugin-options page
        settings_fields("wp_startup_optionpage_grp");
        do_settings_sections("wp_startup_optionpage");
        submit_button();

        echo '</form></div>';

    }
    // sub optionpage 1
    function wp_startup_option_subpage1_html() {
        // !page 1? => oop from sections array for more pages
        echo '<div class="wrap"><h1>WP startup develop</h1><form method="post" action="options.php">';
        // display all sections for plugin-options page
        settings_fields("wp_startup_option_subpage1_grp");
        do_settings_sections("wp_startup_option_subpage1");
        submit_button();

        echo '</form></div>';

    }
    // sub optionpage 2
    function wp_startup_option_subpage2_html() {
        // !page 1? => oop from sections array for more pages
        echo '<div class="wrap"><h1>WP startup tweaks</h1><form method="post" action="options.php">';
        // display all sections for plugin-options page
        settings_fields("wp_startup_option_subpage2_grp");
        do_settings_sections("wp_startup_option_subpage2");
        submit_button();

        echo '</form></div>';

    }




    /**
     * Option page section form html functions (option page sections)
     */

    public function global_section_settings_description(){

        echo '<p>WP Startup hooks into your Wordpress installation and adds or removes Wordpress core functionalities.
        <br />Get started with the options below</p>';

    }

    public function theme_section_settings_description(){

        echo '<p>Theme & styling options</p>';

    }
    public function widget_section_settings_description(){

        echo '<p>Widget activation and adjustment</p>';

    }
    public function component_section_settings_description(){

        echo '<p>Component activation and adjustment</p>';

    }
    public function extend_section_settings_description(){

        echo '<p>In development: Extend options for basic WP functions</p>';

    }

    public function sub1_section_settings_description(){

        echo '<p>Developer sections</p>';

    }

    public function overhead_section_settings_description(){

        echo '<p>Overhead management improvements</p>';

    }

    public function development_section_settings_description(){

        echo '<p>Development tools</p>';

    }

    public function sub2_section_settings_description(){

        echo '<p>WP Tweak sections</p>';

    }

    public function tweak_section_settings_description(){

        echo '<p>WP code Tweaks</p>';

    }


    /**
     * Options functions (options)
     * 1. form html
     * 2. innitialize option functions
     */

    /**
     * Enable WP startup page themes
     * @WPstartup functions.php wp_startup_pagethemes_func()
     */
    public function wp_startup_pagethemes_option_settings_field(){

        $options = get_option( 'wp_startup_pagethemes_option' );
        echo '<p><input name="wp_startup_pagethemes_option" id="wp_startup_pagethemes_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WP Startup page themes and functions.</p>';

    }
    public function wp_startup_pagethemes_option_init(){

        if( get_option( 'wp_startup_pagethemes_option' ) != '' && get_option( 'wp_startup_pagethemes_option' ) == true ){

           wp_startup_pagethemes_func();

        }

    }


    //wp_startup_maintheme_option
/**
     * Enable WP startup Main theme (themes ovewrite)
     * @WPstartup templates.php view_project_template()
     */
    public function wp_startup_maintheme_option_settings_field(){
        $options = get_option( 'wp_startup_maintheme_option' );
        echo '<p><input name="wp_startup_maintheme_option" id="wp_startup_maintheme_option" type="checkbox" value="1" class="code" '.checked( 1, $options, false ).' /> Enable the Main WP Startup Theme overwriting the selected or default theme.</p>';
    }
    public function wp_startup_maintheme_option_init(){
        /*if( get_option( 'wp_startup_maintheme_option' ) != '' && get_option( 'wp_startup_maintheme_option' ) == true ){
        }*/
    }


    /**
     * WP Startup widgets
     * @WPstartup functions.php wp_startup_widgets_func()
     */
    public function wp_startup_widgets_option_settings_field(){

        $options = get_option( 'wp_startup_widgets_option' );
        echo '<p><input name="wp_startup_widgets_option" id="wp_startup_widgets_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WP Startup widgets</p>';

    }

    public function wp_startup_widgets_option_init(){

        if( get_option( 'wp_startup_widgets_option' ) != '' && get_option( 'wp_startup_widgets_option' ) == true ){

           wp_startup_widgets_func();

        }

    }


    /**
     * Shortcode in text widget
     */

    function wp_startup_shortcodeintextwidget_option_settings_field(){

	   $options = get_option( 'wp_startup_shortcodeintextwidget_option' );
	   echo '<p><input name="wp_startup_shortcodeintextwidget_option" id="wp_startup_shortcodeintextwidget_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable shortcodes in the text widget</p>';
    }

    function wp_startup_shortcodeintextwidget_option_init(){

        if( get_option( 'wp_startup_shortcodeintextwidget_option' ) != '' && get_option( 'wp_startup_shortcodeintextwidget_option' ) == true ){

            wp_startup_shortcodeintextwidget_func();

        }

    }



    /**
     * Activatie build-in Link Manager
     * @wp function pre_option_link_manager_enabled
     */
    public function wp_startup_linkmanager_option_settings_field(){

        $options = get_option( 'wp_startup_linkmanager_option' );
        echo '<p><input name="wp_startup_linkmanager_option" id="wp_startup_linkmanager_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable the wordpress build-in link manager</p>';

    }

    public function wp_startup_linkmanager_option_init(){

        if( get_option( 'wp_startup_linkmanager_option' ) != '' && get_option( 'wp_startup_linkmanager_option' ) == true ){

            add_filter( 'pre_option_link_manager_enabled', '__return_true' );

        }

    }

    /**
     * Enable WP startup Menu Images
     * @WPstartup functions.php wp_startup_menu_images_func()
     */
    public function wp_startup_menu_images_option_settings_field(){
        $options = get_option( 'wp_startup_menu_images_option' );
        echo '<p><input name="wp_startup_menu_images_option" id="wp_startup_menu_images_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WP Startup Menu Images & descriptions.</p>';
    }
    public function wp_startup_menu_images_option_init(){
        if( get_option( 'wp_startup_menu_images_option' ) != '' && get_option( 'wp_startup_menu_images_option' ) == true ){
           wp_startup_menu_images_func();
        }
    }


    /**
     * Category Hierarchy
     * @WPstartup functions.php wp_startup_keep_category_hierarchy_func()
     */
    public function wp_startup_categoryhierarchy_option_settings_field(){

        $options = get_option( 'wp_startup_categoryhierarchy_option' );
        echo '<p><input name="wp_startup_categoryhierarchy_option" id="wp_startup_categoryhierarchy_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable category hierarchy display in post metabox</p>';

    }
    public function wp_startup_categoryhierarchy_option_init(){

        if( get_option( 'wp_startup_categoryhierarchy_option' ) != '' && get_option( 'wp_startup_categoryhierarchy_option' ) == true ){

            wp_startup_keep_category_hierarchy_func();

        }

    }


    /**
     * Custom CSS code
     */
    function wp_startup_addcustomcss_option_settings_field(){

        $custom_css = '';
        if( get_option( 'wp_startup_addcustomcss_option' ) != '' && get_option( 'wp_startup_addcustomcss_option' ) != 1 ){
            $custom_css = get_option( 'wp_startup_addcustomcss_option' );
        }
        echo '<p><textarea name="wp_startup_addcustomcss_option" id="wp_startup_addcustomcss_option" rows="7" cols="50" type="textarea">'.$custom_css.'</textarea></p>';

    }

    function wp_startup_addcustomcss_option_init(){

        if( get_option( 'wp_startup_addcustomcss_option' ) != '' && get_option( 'wp_startup_addcustomcss_option' ) != 1 ){

            add_action( 'wp_head', 'wp_startup_addcustomcss_func', 9999 );
            //wp_startup_addcustomcss_func();

        }
    }




    /**
     * Custom JS code
     */
    function wp_startup_addcustomjs_option_settings_field(){

        $custom_js = '';
        if( get_option( 'wp_startup_addcustomjs_option' ) != '' && get_option( 'wp_startup_addcustomjs_option' ) != 1 ){
		$custom_js = get_option( 'wp_startup_addcustomjs_option' );
        }
        echo '<p><textarea name="wp_startup_addcustomjs_option" id="wp_startup_addcustomjs_option" rows="7" cols="50" type="textarea">'.$custom_js.'</textarea></p>';

    }

    function wp_startup_addcustomjs_option_init(){

        if( get_option( 'wp_startup_addcustomjs_option' ) != '' && get_option( 'wp_startup_addcustomjs_option' ) != 1 ){

            add_action( 'wp_head', 'wp_startup_addcustomjs_func', 9998 );
            //wp_startup_addcustomjs_func();

        }

    }



    /**
     * PHP in text widget
     */
    function wp_startup_phpintextwidget_option_settings_field(){

        $options = get_option( 'ws_phpintextwidget_option' );
        echo '<p><input name="ws_phpintextwidget_option" id="ws_phpintextwidget_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable php code in the text widget</p>';

    }

    function wp_startup_phpintextwidget_option_init(){
        if( get_option( 'ws_phpintextwidget_option' ) != '' && get_option( 'ws_phpintextwidget_option' ) == true ){

            wp_startup_phpintextwidget_func();

        }
    }



    /**
     * Remove Emojicon code
     * @WPstartup functions.php wp_startup_disable_wp_emojicons_func()
     * source http://wordpress.stackexchange.com/questions/61922/add-post-screen-keep-category-structure
     * source http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
     */
    public function wp_startup_dumbemoji_option_settings_field(){

        $options = get_option( 'wp_startup_dumbemoji_option' );
        echo '<p><input name="wp_startup_dumbemoji_option" id="wp_startup_dumbemoji_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Remove Emojicons junk code</p>';

    }

    public function wp_startup_dumbemoji_option_init(){

        if( get_option( 'wp_startup_dumbemoji_option' ) != '' && get_option( 'wp_startup_dumbemoji_option' ) == true ){

            wp_startup_disable_wp_emojicons_func();

        }

    }



    /**
     * Remove Gravatar
     * @WPstartup functions.php wp_startup_disable_gravatar_func()
     */
    public function wp_startup_removegravatar_option_settings_field(){

        $options = get_option( 'wp_startup_removegravatar_option' );
        echo '<p><input name="wp_startup_removegravatar_option" id="wp_startup_removegravatar_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Disable WP Gravatar function</p>';

    }

    public function wp_startup_removegravatar_option_init(){

        if( get_option( 'wp_startup_removegravatar_option' ) != '' && get_option( 'wp_startup_removegravatar_option' ) == true ){

            wp_startup_disable_gravatar_func();

        }

    }

}

?>
