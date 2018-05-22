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
                'menu_title' => 'Startup',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_optionpage',
                'parent_slug' => 'wp_startup_optionpage', // 'options-general.php',
                'icon_url' => 'dashicons-editor-kitchensink',
                'position' => 80

            ),
            'wp_startup_option_subpage1' => array(

                'title' => 'WP startup control',
                'menu_title' => 'Admin & User',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_option_subpage1',
                'parent_slug' => 'wp_startup_optionpage',
            ),
            'wp_startup_option_subpage2' => array(

                'title' => 'WP startup development',
                'menu_title' => 'Developer',
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
                'title'=>'Global',
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
            ),/*
            'sub1_section' => array(
                'id'=>'sub1_section',
                'title'=>'Sub 1 Settings',
                'page'=>'wp_startup_option_subpage1'
            ),*/
            'overhead_section' => array(
                'id'=>'overhead_section',
                'title'=>'Overhead',
                'page'=>'wp_startup_option_subpage1'
            ),/*
            'sub2_section' => array(
                'id'=>'sub2_section',
                'title'=>'Sub 2 Settings',
                'page'=>'wp_startup_option_subpage2'
            ),*/
            'development_section' => array(
                'id'=>'development_section',
                'title'=>'Code',
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
            'wp_startup_categoryhierarchy_option' => array(

                'id'=>'wp_startup_categoryhierarchy_option',
                'title'=>'Category Hierarchy',
                'page'=>'wp_startup_option_subpage1',
                'section'=>'overhead_section'

            ),
            'wp_startup_addcustomcss_option' => array(

                'id'=>'wp_startup_addcustomcss_option',
                'title'=>'CSS code',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'development_section'

            ),
            'wp_startup_addcustomjs_option' => array(

                'id'=>'wp_startup_addcustomjs_option',
                'title'=>'JS code',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'development_section'

            ),
            'wp_startup_phpintextwidget_option' => array(

                'id'=>'wp_startup_phpintextwidget_option',
                'title'=>'PHP in textwidget',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'development_section'

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

        // insert latest value from wp
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


        echo '<div class="wrap"><h1>WP startup</h1>';

        echo '<form method="post" action="options.php" onSubmit="this.action=\'options.php\'+location.hash">';

        $this->wp_startup_optionpage_html_section_tabs( 'wp_startup_optionpage', 'wp_startup_optionpage_grp' );

        submit_button();

        echo '</form></div>';

        $this->wp_startup_optionpage_html_footer();

    }

    // sub optionpage 1
    public function wp_startup_option_subpage1_html() {
        // !page 1? => oop from sections array for more pages
        echo '<div class="wrap"><h1>Admin & User</h1>';

        echo '<form method="post" action="options.php" onSubmit="this.action=\'options.php\'+location.hash">';

        $this->wp_startup_optionpage_html_section_tabs( 'wp_startup_option_subpage1', 'wp_startup_option_subpage1_grp' );

        submit_button();

        echo '</form></div>';


        $this->wp_startup_optionpage_html_footer();

    }

    // sub optionpage 2
    public function wp_startup_option_subpage2_html() {
        // !page 1? => oop from sections array for more pages
        echo '<div class="wrap"><h1>Developer</h1>';

        echo '<form method="post" action="options.php" onSubmit="this.action=\'options.php\'+location.hash">';

        $this->wp_startup_optionpage_html_section_tabs( 'wp_startup_option_subpage2', 'wp_startup_option_subpage2_grp' );

        submit_button();

        echo '</form></div>';


        $this->wp_startup_optionpage_html_footer();

    }

    /**
     * Tabs (1.0)
     * Option page section tabs (or basic)
     * $page
     * $fields (=) $page.'_grp';
     *
     */
    function wp_startup_optionpage_html_section_tabs( $page, $fieldgroup ){

        // dependence : WPstartup class plugin_settings() enqueue wp_startup_admin_style() options tabs code
        // source https://murviel-info-beziers.com/onglets-tabs-plugin-wordpress/

        global $wp_settings_sections, $wp_settings_fields;

        if (!isset($wp_settings_sections[$page])) {
            return;
        }

        // count sections (set minimum for tab view)
        if( count( $wp_settings_sections[$page] ) > 1 ){

            echo '<span class="nav-view"></span>';

            echo '<h2 class="nav-tab-wrapper">';

            // section titles
            foreach((array)$wp_settings_sections[$page] as $section) :

                if(!isset($section['title']))
                    continue;

                echo '<a class="nav-tab" href="#'.$section['id'].'">'.$section['title'].'</a>';

            endforeach;

            echo '</h2>';

             // section content
            settings_fields( $fieldgroup );

            foreach((array)$wp_settings_sections[$page] as $section) :

                if(!isset($section['title']))
                    continue;

                echo  '<div id="'.$section['id'].'" class="tabs">';
                echo  '<h3>'.$section['title'] .'</h3>';

                $html = $section['id'].'_settings_description';
                $this->$html();

                do_settings_fields( $page, $section['id']);

                echo  '</div>';



            endforeach;

        }else{

            // display (all) section for plugin-options page
            settings_fields( $fieldgroup );
            do_settings_sections( $page );

        }

    }

    /**
     * Option page footer html
     */
     function wp_startup_optionpage_html_footer(){

        echo '<p><a href="https://webdesigndenhaag.net" target="_blank"><img src="https://img.shields.io/badge/Made by-Webdesign Den Haag-blue.svg" alt="Webbouwer Webdesign Den Haag" /></a> <a href="https://github.com/webbouwer/wp-startup" target="_blank"><img src="https://img.shields.io/badge/WP--startup-@github-lightgrey.svg" alt="Github repo" /></a> <a href="https://github.com/webbouwer" target="_blank"><img src="https://img.shields.io/badge/Webbouwer-@github-lightgrey.svg" alt="Webbouwer github" /></a></p>';

         // http://shields.io/#your-badge
     }



    /**
     * Option page section form html functions (option page sections)
     */

    public function global_section_settings_description(){

        echo '<p>WP Startup hooks into your Wordpress installation and adds or removes Wordpress core functionalities.</p>';

    }

    public function theme_section_settings_description(){

        echo '<p>Theme & styling options</p>';

    }
    public function widget_section_settings_description(){

        echo '<p>Widget activation & enhancements</p>';

    }
    public function component_section_settings_description(){

        echo '<p>Component activation & enhancements</p>';

    }
    public function extend_section_settings_description(){

        echo '<p>Extend options for basic WP functions</p>';

        echo '<p>In development  (Menu images/icons)</p>';

    }

    public function sub1_section_settings_description(){

        echo '<p>Testpage developer section</p>';

    }

    public function overhead_section_settings_description(){

        echo '<p>Overhead management improvements</p>';

    }

    public function development_section_settings_description(){

        echo '<p>Development tools</p>';

    }

    public function sub2_section_settings_description(){

        echo '<p>Testpage 2 developer section</p>';

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



    /**
     * WP Startup widgets
     * @WPstartup functions.php wp_startup_widgets_func()
     */
    public function wp_startup_widgets_option_settings_field(){

        $options = get_option( 'wp_startup_widgets_option' );
        echo '<p><input name="wp_startup_widgets_option" id="wp_startup_widgets_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WP Startup widgets</p>';

        echo '<ul><li>- Postlist widget including category selection, relation by category and/or tags and post image display.</li>';
        echo '<li>- Dashboard widget with the latest updates at the WP-startup Github repository.</li></ul>';
        echo '<p>Save this and see <a href="widgets.php" target="_blank">widgets page</a> and <a href="index.php" target="_blank">dashboard page</a>.</p><br />';
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
