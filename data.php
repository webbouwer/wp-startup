<?php
class WPstartupData{


    /** @var sections[] */
    public $sections = [];

    /** @var options[] */
    public $options = [];



    /** @var new data */
    public function WPstartupData(){

        $this->WPstartup_data_sections();

        $this->WPstartup_data_options();

    }



    // @section data
    public function WPstartup_data_sections(){
        /*
        $pages = array(

            'wp_startup_optionpage' = array(

                'title' => 'WP startup plugin options',
                'menu_title' => 'WP Startup Options',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_optionpage',
                //$function = array( $this, 'wp_startup_optionpage_html'); //'plugin_option_page';
                'icon_url' => 'dashicons-editor-kitchensink',
                'position' => 60

            ),
            'wp_startup_testpage' = array(

                'title' => 'WP startup test options',
                'menu_title' => 'WP Startup tests',
                'capability' => 'edit_posts',
                'menu_slug' => 'wp_startup_testpage',
                //'function' = array( $this, 'wp_startup_optionpage_html'); //'plugin_option_page';
                'icon_url' => 'dashicons-editor-kitchensink',
                'position' => 60

            ),
        );
        $this->pages = $pages;
        */
        $sections = array(

            'global_section' => array(
                'id'=>'global_section',
                'title'=>'Global Settings',
                'page'=>'wp_startup_optionpage'
            ),
            'developer_section' => array(
                'id'=>'developer_section',
                'title'=>'Developer Settings',
                'page'=>'wp_startup_optionpage'
            )


        );
        $this->sections = $sections;

    }

    // @options data
    public function WPstartup_data_options(){

        $options = array(

            'wp_startup_linkmanager_option' => array(

                'id'=>'wp_startup_linkmanager_option',
                'title'=>'Link Manager component',
                'page'=>'wp_startup_optionpage',
                'section'=>'global_section'

            ),
            'wp_startup_dumbemoji_option' => array(

                'id'=>'wp_startup_dumbemoji_option',
                'title'=>'Remove Emoji junk',
                'page'=>'wp_startup_optionpage',
                'section'=>'developer_section'

            )
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


    /** @var sections[] return
    public function get_wpstartup_pages(){

        $this->WPstartup_data_sections(); // latest data

        if( is_array( $this->pages ) && count( $this->pages ) > 0 ){
            return $this->pages;
        }else{
            return false;
        }

    }
    */

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

    // optionpage sections
    public function global_section_settings_description(){
        echo '<p>WP Startup hooks into your Wordpress installation and adds or removes Wordpress core functionalities. When all these options are blank you are working with a basic Wordpress setup.</p>';
    }

    public function developer_section_settings_description(){
        echo '<p>Testpage developer section</p>';
    }



    // Activatie build-in Link Manager
    public function wp_startup_linkmanager_option_settings_field(){
        $options = get_option( 'wp_startup_linkmanager_option' );
        echo '<p><input name="wp_startup_linkmanager_option" id="wp_startup_linkmanager_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable the wordpress build-in link manager</p>';
    }

    public function wp_startup_linkmanager_option_init(){
        if( get_option( 'wp_startup_linkmanager_option' ) != '' && get_option( 'wp_startup_linkmanager_option' ) == true ){
            add_filter( 'pre_option_link_manager_enabled', '__return_true' );
        }
    }



    // Remove Emojicon code
    // source http://wordpress.stackexchange.com/questions/61922/add-post-screen-keep-category-structure
    public function wp_startup_dumbemoji_option_settings_field(){
        $options = get_option( 'wp_startup_dumbemoji_option' );
        echo '<p><input name="wp_startup_dumbemoji_option" id="wp_startup_dumbemoji_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Remove Emojicons junk code</p>';
    }

    public function wp_startup_dumbemoji_option_init(){
        if( get_option( 'wp_startup_dumbemoji_option' ) != '' && get_option( 'wp_startup_dumbemoji_option' ) == true ){
            disable_wp_emojicons();
        }
    }
}

?>
