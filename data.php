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

    // @pages data
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

                'title' => 'WP startup test options 1',
                'menu_title' => 'Test Options 1',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_option_subpage1',
                'parent_slug' => 'wp_startup_optionpage',
            ),
            'wp_startup_option_subpage2' => array(

                'title' => 'WP startup test options 2',
                'menu_title' => 'Test Options 2',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_option_subpage2',
                'parent_slug' => 'wp_startup_optionpage',
            ),
        );
        $this->pages = $pages;

    }
    // @sections data
    public function WPstartup_data_sections(){

        $sections = array(

            'global_section' => array(
                'id'=>'global_section',
                'title'=>'Global Settings',
                'page'=>'wp_startup_optionpage'
            ),
            'sub1_section' => array(
                'id'=>'sub1_section',
                'title'=>'Sub 1 Settings',
                'page'=>'wp_startup_option_subpage1'
            ),
            'sub2_section' => array(
                'id'=>'sub2_section',
                'title'=>'Sub 2 Settings',
                'page'=>'wp_startup_option_subpage2'
            )


        );
        $this->sections = $sections;

    }

    // @options data
    public function WPstartup_data_options(){

        $options = array(
            'wp_startup_pagethemes_option' => array(

                'id'=>'wp_startup_pagethemes_option',
                'title'=>'Page Themes',
                'page'=>'wp_startup_optionpage',
                'section'=>'global_section'

            ),
            'wp_startup_widgets_option' => array(

                'id'=>'wp_startup_widgets_option',
                'title'=>'Widgets',
                'page'=>'wp_startup_optionpage',
                'section'=>'global_section'

            ),
            'wp_startup_categoryhierarchy_option' => array(

                'id'=>'wp_startup_categoryhierarchy_option',
                'title'=>'Category Hierarchy',
                'page'=>'wp_startup_option_subpage1',
                'section'=>'sub1_section'

            ),
            'wp_startup_linkmanager_option' => array(

                'id'=>'wp_startup_linkmanager_option',
                'title'=>'Link Manager component',
                'page'=>'wp_startup_option_subpage1',
                'section'=>'sub1_section'

            ),
            'wp_startup_dumbemoji_option' => array(

                'id'=>'wp_startup_dumbemoji_option',
                'title'=>'Remove Emoji junk',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'sub2_section'

            ),
            'wp_startup_removegravatar_option' => array(

                'id'=>'wp_startup_removegravatar_option',
                'title'=>'Remove Gravatar stuff',
                'page'=>'wp_startup_option_subpage2',
                'section'=>'sub2_section'

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
        echo '<div class="wrap"><h1>WP startup options subpage 1</h1><form method="post" action="options.php">';
        // display all sections for plugin-options page
        settings_fields("wp_startup_option_subpage1_grp");
        do_settings_sections("wp_startup_option_subpage1");
        submit_button();

        echo '</form></div>';

    }

     // sub optionpage 2
    function wp_startup_option_subpage2_html() {
        // !page 1? => oop from sections array for more pages
        echo '<div class="wrap"><h1>WP startup options subpage 2</h1><form method="post" action="options.php">';
        // display all sections for plugin-options page
        settings_fields("wp_startup_option_subpage2_grp");
        do_settings_sections("wp_startup_option_subpage2");
        submit_button();

        echo '</form></div>';

    }




    // Sections
    public function global_section_settings_description(){
        echo '<p>WP Startup hooks into your Wordpress installation and adds or removes Wordpress core functionalities. When all these options are blank you are working with a basic Wordpress setup.</p>';
    }

    public function sub1_section_settings_description(){
        echo '<p>Testpage developer section</p>';
    }


    public function sub2_section_settings_description(){
        echo '<p>Testpage 2 developer section</p>';
    }


    // Enable WP startup page themes
    public function wp_startup_pagethemes_option_settings_field(){

        $options = get_option( 'wp_startup_pagethemes_option' );
        echo '<p><input name="wp_startup_pagethemes_option" id="wp_startup_pagethemes_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WP Startup page themes</p>';

    }
    public function wp_startup_pagethemes_option_init(){

        if( get_option( 'wp_startup_pagethemes_option' ) != '' && get_option( 'wp_startup_pagethemes_option' ) == true ){

           wp_startup_pagethemes_func();

        }

    }

    // WP Startup widgets
    public function wp_startup_widgets_option_settings_field(){

        $options = get_option( 'wp_startup_widgets_option' );
        echo '<p><input name="wp_startup_widgets_option" id="wp_startup_widgets_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WP Startup widgets</p>';

    }

    public function wp_startup_widgets_option_init(){

        if( get_option( 'wp_startup_widgets_option' ) != '' && get_option( 'wp_startup_widgets_option' ) == true ){

           wp_startup_widgets_func();

        }

    }



    // Activatie build-in Link Manager
    // pre_option_link_manager_enabled
    public function wp_startup_linkmanager_option_settings_field(){

        $options = get_option( 'wp_startup_linkmanager_option' );
        echo '<p><input name="wp_startup_linkmanager_option" id="wp_startup_linkmanager_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable the wordpress build-in link manager</p>';

    }

    public function wp_startup_linkmanager_option_init(){

        if( get_option( 'wp_startup_linkmanager_option' ) != '' && get_option( 'wp_startup_linkmanager_option' ) == true ){

            add_filter( 'pre_option_link_manager_enabled', '__return_true' );

        }

    }


    // Category Hierarchy
    public function wp_startup_categoryhierarchy_option_settings_field(){

        $options = get_option( 'wp_startup_categoryhierarchy_option' );
        echo '<p><input name="wp_startup_categoryhierarchy_option" id="wp_startup_categoryhierarchy_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable category hierarchy display in post metabox</p>';

    }
    public function wp_startup_categoryhierarchy_option_init(){

        if( get_option( 'wp_startup_categoryhierarchy_option' ) != '' && get_option( 'wp_startup_categoryhierarchy_option' ) == true ){

            wp_startup_keep_category_hierarchy_func();

        }

    }


    // Remove Emojicon code
    // source http://wordpress.stackexchange.com/questions/61922/add-post-screen-keep-category-structure
    // source http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
    public function wp_startup_dumbemoji_option_settings_field(){

        $options = get_option( 'wp_startup_dumbemoji_option' );
        echo '<p><input name="wp_startup_dumbemoji_option" id="wp_startup_dumbemoji_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Remove Emojicons junk code</p>';

    }

    public function wp_startup_dumbemoji_option_init(){

        if( get_option( 'wp_startup_dumbemoji_option' ) != '' && get_option( 'wp_startup_dumbemoji_option' ) == true ){

            wp_startup_disable_wp_emojicons_func();

        }

    }

    // wp_startup_removegravatar_option
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
