<?php
/*
Plugin Name: WP Startup
Plugin URI:  https://github.com/webbouwer/wp-startup
Description: Do more with a basic WP install
Version:     0.2
Author:      Webbouwer
Author URI:  http://webdesigndenhaag.net
Text Domain: wp-startup
License:     © Oddsized All rights reserved
License URI: http://webdesigndenhaag.net
*/


/**
 * Verify code usage in WP
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Includes
 */
require_once('data.php');
require_once('functions.php');

/**
 * Main Plugin Object
 */
$wpstartup = new WPstartup;

class WPstartup{

    /** @obj WPstartupData */
    public $data = [];


    public function WPstartup() {

        // get plugin data
        $this->data = new WPstartupData;

        // load plugin settings
        $this->plugin_settings();

        // innitiate plugin options
        $this->plugin_load_options();

    }



    public function plugin_settings(){

        // load and check options
        add_action( 'admin_init', array( $this, 'plugin_settings_page_sections' ) );

        // add admin hooks
        add_action( 'admin_menu', array( $this, 'wp_startup_admin_menu' ) );

    }

    public function plugin_settings_page_sections(){

        /**
         * Sections loaded from the data class for settings register
         */
        $sections = $this->data->get_wpstartup_sections();

        if( is_array( $sections ) && count( $sections ) > 0 ){

            foreach( $sections as $id => $section ){

                add_settings_section(
                    $section['id'],
                    $section['title'],
                    array( $this->data, $section['id'].'_settings_description' ),
                    $section['page']
                );

            }
        }

        /**
         * Options loaded from the data class for settings register
         */
        $options = $this->data->get_wpstartup_options();

        if( is_array( $options ) && count( $options ) > 0 ){

            foreach( $options as $id => $option ){

                // option
                add_option( $option['id'] , 1 );

                add_settings_field(
                    $option['id'],
                    $option['title'],
                    array( $this->data, $option['id'].'_settings_field' ), // data class functions
                    $option['page'],
                    $option['section']
                );

                register_setting( $option['page'].'_grp', $option['id'] );

            }
        }
    }

    public function wp_startup_admin_menu(){
        // !page 1? => oop from sections array for more pages
        $page_title = 'wp_startup plugin Options';
        $menu_title = 'WP Startup';
        $capability = 'edit_posts';
        $menu_slug = 'wp_startup_optionpage';
        $function = array( $this, 'wp_startup_optionpage_html'); //'plugin_option_page';
        $icon_url = 'dashicons-editor-kitchensink';
        $position = 60;
        add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

    }

    function wp_startup_optionpage_html() {
        // !page 1? => oop from sections array for more pages
        echo '<div class="wrap"><h1>WP startup options</h1><form method="post" action="options.php">';
        // display all sections for plugin-options page
        settings_fields("wp_startup_optionpage_grp");
        do_settings_sections("wp_startup_optionpage");
        submit_button();

        echo '</form></div>';

    }


    public function plugin_load_options(){

        $options = $this->data->get_wpstartup_options();

        if( is_array( $options ) && count( $options ) > 0 ){

            foreach( $options as $id => $option ){

                $function = $option['id'].'_init';
                $this->data->$function();

            }

        }
    }

}

?>
