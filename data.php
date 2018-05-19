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

        $sections = array(

            'global_section' => array(
                'id'=>'global_section',
                'title'=>'Global Settings',
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

    /** Settings section functions (related to section['id'] + _settings_description ) */
    public function global_section_settings_description(){
        echo '<p>WP Startup hooks into your Wordpress installation and adds or removes Wordpress core functionalities. When all these options are blank you are working with a basic Wordpress setup.</p>';
    }


    /** Option setting functions (related to option['id'] + _setting_field ) */
    public function wp_startup_linkmanager_option_settings_field(){
        $options = get_option( 'wp_startup_linkmanager_option' );
        echo '<p><input name="wp_startup_linkmanager_option" id="wp_startup_linkmanager_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable the wordpress build-in link manager</p>';
    }

    /** Option usage functions (related to option['id'] + _init ) */
    public function wp_startup_linkmanager_option_init(){
        if( get_option( 'wp_startup_linkmanager_option' ) != '' && get_option( 'wp_startup_linkmanager_option' ) == true ){
            add_filter( 'pre_option_link_manager_enabled', '__return_true' );
        }
    }

}

?>
