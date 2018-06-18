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

        // Load textdomain languages
        add_action( 'plugins_loaded', array( $this, 'wp_startup_load_textdomain' ) );

        // load and check options
        add_action( 'admin_init', array( $this, 'wp_startup_admin_settings' ) );

        // add admin hooks
        add_action( 'admin_menu', array( $this, 'wp_startup_admin_menu' ) );

    }


    public function wp_startup_load_textdomain() {

        load_plugin_textdomain( 'wp-startup', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
    }

    public function wp_startup_admin_settings(){

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


        /**
         * Pages loaded from the data class for settings register
         */
        $pages = $this->data->get_wpstartup_pages();


        if( is_array( $pages ) && count( $pages ) > 0 ){

            foreach( $pages as $id => $page ){

                if( $page['parent_slug'] == $page['menu_slug'] ){
                    add_menu_page(
                        $page['title'],
                        $page['menu_title'],
                        $page['capability'],
                        $page['menu_slug'],
                        array( $this->data, $page['menu_slug'].'_html' ),
                        $page['icon_url'],
                        $page['position']
                    );
                }else{
                    add_submenu_page(
                        $page['parent_slug'],
                        $page['title'],
                        $page['menu_title'],
                        $page['capability'],
                        $page['menu_slug'],
                        array( $this->data, $page['menu_slug'].'_html' )
                    );
                }
            }
        }
    }



    /**
     * Innitiate plugin options
     */
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
