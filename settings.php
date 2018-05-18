<?php
// option page
function plugin_option_page() {
?>
    <div class="wrap">
    <h1>WP startup options</h1>
    <form method="post" action="options.php">
    <?php
    // display all sections for plugin-options page
    settings_fields("wp_startup_optionpage_grp");
    do_settings_sections("wp_startup_optionpage");
    submit_button();
    ?>
    </form>
    </div>
<?php
}

// global plugin desc
function ws_plugin_section_description(){
	echo '<p>WP Startup hooks into your Wordpress installation and adds or removes Wordpress core functionalities. When all these options are blank you are working with a basic Wordpress setup.</p>';
}


function ws_options_select_widgets(){
	$options = get_option( 'ws_widgets_option' );
	echo '<p><input name="ws_widgets_option" id="ws_widgets_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WPStartup widgets</p>';
}

function ws_options_select_pagetemplates(){
	$options = get_option( 'ws_pagetemplates_option' );
	echo '<p><input name="ws_pagetemplates_option" id="ws_pagetemplates_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable WPStartup page templates</p>';

}

function ws_options_select_themebgimage(){
	$options = get_option( 'ws_themebgimage_option' );
	echo '<p><input name="ws_themebgimage_option" id="ws_themebgimage_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable the wordpress build-in theme background image options</p>';

}
function ws_options_select_linkmanager(){
	$options = get_option( 'ws_linkmanager_option' );
	echo '<p><input name="ws_linkmanager_option" id="ws_linkmanager_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable the wordpress build-in link manager</p>';
}


function ws_options_select_categoryhierarchy(){
	$options = get_option( 'ws_categoryhierarchy_option' );
	echo '<p><input name="ws_categoryhierarchy_option" id="ws_categoryhierarchy_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable category hierarchy display in post metabox</p>';
}



function ws_options_select_shortcodesintextwidget(){
	$options = get_option( 'ws_shortcodesintextwidget_option' );
	echo '<p><input name="ws_shortcodesintextwidget_option" id="ws_shortcodesintextwidget_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable shortcodes in the text widget</p>';
}
function ws_options_select_phpintextwidget(){
	
	$options = get_option( 'ws_phpintextwidget_option' );
	echo '<p><input name="ws_phpintextwidget_option" id="ws_phpintextwidget_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Enable php code in the text widget</p>';
}



function ws_options_css_output(){
	$ws_custom_css = '';
	if( get_option( 'ws_custom_css' ) != '' && get_option( 'ws_custom_css' ) != 1 ){
		$ws_custom_css = get_option( 'ws_custom_css' );
	}
	echo '<p><textarea name="ws_custom_css" id="ws_custom_css" rows="7" cols="50" type="textarea">'.$ws_custom_css.'</textarea></p>';
	
}
function ws_options_js_output(){

	$ws_custom_js = '';
	if( get_option( 'ws_custom_js' ) != '' && get_option( 'ws_custom_js' ) != 1 ){
		$ws_custom_js = get_option( 'ws_custom_js' );
	}
	echo '<p><textarea name="ws_custom_js" id="ws_custom_js" rows="7" cols="50" type="textarea">'.$ws_custom_js.'</textarea></p>';
	
}



function ws_options_select_removegravatar(){

	$options = get_option( 'ws_removegravatar_option' );
	echo '<p><input name="ws_removegravatar_option" id="ws_removegravatar_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Disable WP Gravatar function</p>';

}


function ws_options_select_removeemojicons(){
	$options = get_option( 'ws_removeemojicons_option' );
	echo '<p><input name="ws_removeemojicons_option" id="ws_removeemojicons_option" type="checkbox" value="1" class="code" ' . checked( 1, $options, false ) . ' /> Disable WP Emojicons function</p>';
}



/** Plugin settings  */
add_action('admin_init','wp_startup_plugin_settings');

function wp_startup_plugin_settings(){

	add_settings_section( 'global_section', 'Global Settings','ws_plugin_section_description','wp_startup_optionpage');
	
    // extends
    add_option('ws_widgets_option',1);// add option
	add_settings_field('ws_widgets_option','WP Startup Widgets','ws_options_select_widgets','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_widgets_option');

	add_option('ws_pagetemplates_option',1);// add option
	add_settings_field('ws_pagetemplates_option','Theme page templates','ws_options_select_pagetemplates','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_pagetemplates_option');

	add_option('ws_themebgimage_option',1);// add option
	add_settings_field('ws_themebgimage_option','Theme background image','ws_options_select_themebgimage','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_themebgimage_option');
	
	add_option('ws_linkmanager_option',1);// add option
	add_settings_field('ws_linkmanager_option','Link Manager component','ws_options_select_linkmanager','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_linkmanager_option');
	
	add_option('ws_categoryhierarchy_option',1);// add option
	add_settings_field('ws_categoryhierarchy_option','Categories hierarchy','ws_options_select_categoryhierarchy','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_categoryhierarchy_option');
		
	add_option('ws_shortcodesintextwidget_option',1);// add option
	add_settings_field('ws_shortcodesintextwidget_option','Shortcodes in text-widget','ws_options_select_shortcodesintextwidget','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_shortcodesintextwidget_option');
		
	add_option('ws_phpintextwidget_option',1);// add option
	add_settings_field('ws_phpintextwidget_option','PHP coding in text-widget','ws_options_select_phpintextwidget','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_phpintextwidget_option');
	
	// codes
	add_option( 'ws_custom_css', '');// add option
	add_settings_field('ws_custom_css', 'Custom css code', 'ws_options_css_output', 'wp_startup_optionpage', 'global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_custom_css');
	
	add_option( 'ws_custom_js', '');// add option
	add_settings_field('ws_custom_js', 'Custom javascript code', 'ws_options_js_output', 'wp_startup_optionpage', 'global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_custom_js');

	// tweaks
	add_option('ws_removegravatar_option',1);// add option
	add_settings_field('ws_removegravatar_option','Gravatars','ws_options_select_removegravatar','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_removegravatar_option');

	add_option('ws_removeemojicons_option',1);// add option
	add_settings_field('ws_removeemojicons_option','Emojicons','ws_options_select_removeemojicons','wp_startup_optionpage','global_section');
	register_setting( 'wp_startup_optionpage_grp', 'ws_removeemojicons_option');

}



/** Plugin Admin Menu */
add_action('admin_menu', 'wp_startup_admin_menu');
function wp_startup_admin_menu(){
    $page_title = 'wp_startup plugin Options';
    $menu_title = 'WP Startup';
    $capability = 'edit_posts';
    $menu_slug = 'wp_startup_optionpage';
    $function = 'plugin_option_page';
    $icon_url = 'dashicons-editor-kitchensink';
    $position = 60;
    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}


?>
