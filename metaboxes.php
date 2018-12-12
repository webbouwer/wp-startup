<?php
/********** PAGE CUSTOM META FIELDS **********/
function add_page_meta_box()
{
    add_meta_box(
        "page-custom-meta-box",
        "Page Elements",
        "page_meta_custom_fields",
        "page",
        "side",
        "high",
        null);
}
add_action("add_meta_boxes", "add_page_meta_box");

function page_meta_custom_fields($object)
{
wp_nonce_field(basename(__FILE__), "meta-box-nonce");
$useheaderimage = get_post_meta($object->ID, "meta-page-headerimage", true);
$pagesidebardisplay = get_post_meta($object->ID, "meta-page-pagesidebardisplay", true);
$beforewidgetsdisplay = get_post_meta($object->ID, "meta-page-beforewidgetsdisplay", true);
$afterwidgetsdisplay = get_post_meta($object->ID, "meta-page-afterwidgetsdisplay", true);

$subcontent1display = get_post_meta($object->ID, "meta-page-subcontent1display", true);
$subcontent2display = get_post_meta($object->ID, "meta-page-subcontent2display", true);

$headeroptions = array(
    'none'   => __( 'custom display', 'wp-startup' ),
    'front'  => __( 'custom on frontpage/blogpage only', 'wp-startup' ),
    'post'   => __( 'custom display or post featured image', 'wp-startup' ),
    'page'   => __( 'custom display or page featured image', 'wp-startup' ),
    'all'    => __( 'custom display or page featured image', 'wp-startup' ),
);
$header_set = get_theme_mod('wp_startup_theme_panel_elements_postheader', 'none' );

?>
<p><label for="meta-page-headerimage"><?php echo __('Header image', 'wp-startup'); ?></label>
<select name="meta-page-headerimage" id="meta-page-headerimage">
<option value="default" <?php selected( $useheaderimage, 'default' ); ?>><?php echo __( $headeroptions[$header_set] , 'wp-startup'); ?></option>
<option value="replace" <?php selected( $useheaderimage, 'replace' ); ?>><?php echo __('Force page featured image', 'wp-startup'); ?></option>
<option value="hide" <?php selected( $useheaderimage, 'hide' ); ?>><?php echo __('Hide', 'wp-startup'); ?></option>
</select>
</p>
<?php
$sidebar_set = get_theme_mod('wp_startup_theme_panel_elements_sidebar', 'right');
?>
<p><label for="meta-page-pagesidebardisplay"><?php echo __('Sidebar display', 'wp-startup'); ?></label>
<select name="meta-page-pagesidebardisplay" id="meta-page-pagesidebardisplay">
<option value="default" <?php selected( $pagesidebardisplay, 'default' ); ?>><?php echo __('Default display ('.$sidebar_set.')', 'wp-startup'); ?></option>
<option value="hide" <?php selected( $pagesidebardisplay, 'hide' ); ?>><?php echo __('Hide sidebar', 'wp-startup'); ?></option>
<option value="left" <?php selected( $pagesidebardisplay, 'left' ); ?>><?php echo __('Display sidebar left', 'wp-startup'); ?></option>
<option value="right" <?php selected( $pagesidebardisplay, 'right' ); ?>><?php echo __('Display sidebar right', 'wp-startup'); ?></option>
</select>
</p>
<p><label for="meta-page-beforewidgetsdisplay"><?php echo __('Before-content Widgets', 'wp-startup'); ?></label>
<select name="meta-page-beforewidgetsdisplay" id="meta-page-beforewidgetsdisplay">
<option value="show" <?php selected( $beforewidgetsdisplay, 'show' ); ?>><?php echo __('Display before content', 'wp-startup'); ?></option>
<option value="hide" <?php selected( $beforewidgetsdisplay, 'hide' ); ?>><?php echo __('Do not display', 'wp-startup'); ?></option>
</select>
</p>
<p><label for="meta-page-afterwidgetsdisplay"><?php echo __('After-content Widgets', 'wp-startup'); ?></label>
<select name="meta-page-afterwidgetsdisplay" id="meta-page-afterwidgetsdisplay">
<option value="show" <?php selected( $afterwidgetsdisplay, 'show' ); ?>><?php echo __('Display after content', 'wp-startup'); ?></option>
<option value="hide" <?php selected( $afterwidgetsdisplay, 'hide' ); ?>><?php echo __('Do not display', 'wp-startup'); ?></option>
</select>
</p>

<p><label for="meta-page-subcontent1display"><?php echo __('Subcontent Widgets 1', 'wp-startup'); ?></label>
<select name="meta-page-subcontent1display" id="meta-page-subcontent1display">
<option value="show" <?php selected( $subcontent1display, 'show' ); ?>><?php echo __('Display', 'wp-startup'); ?></option>
<option value="hide" <?php selected( $subcontent1display, 'hide' ); ?>><?php echo __('Do not display', 'wp-startup'); ?></option>
</select>
</p>
<p><label for="meta-page-subcontent2display"><?php echo __('Subcontent Widgets 2', 'wp-startup'); ?></label>
<select name="meta-page-subcontent2display" id="meta-page-subcontent2display">
<option value="show" <?php selected( $subcontent2display, 'show' ); ?>><?php echo __('Display', 'wp-startup'); ?></option>
<option value="hide" <?php selected( $subcontent2display, 'hide' ); ?>><?php echo __('Do not display', 'wp-startup'); ?></option>
</select>
</p>


<?php
}
/* not on theme pages */
//global $post;
//if(!empty($post)){
//$pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);
//if( $pageTemplate != 'gallery.php'){
//add_action("add_meta_boxes", "add_childpage_section_box");
//}
//}


function save_page_meta_box($pid, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $pid;

    if(!current_user_can("edit_post", $pid))
        return $pid;

    if( isset( $_POST['meta-page-headerimage'] ) )
        update_post_meta( $pid, 'meta-page-headerimage', esc_attr(     $_POST['meta-page-headerimage'] ) );

    if( isset( $_POST['meta-page-pagesidebardisplay'] ) )
        update_post_meta( $pid, 'meta-page-pagesidebardisplay', esc_attr( $_POST['meta-page-pagesidebardisplay'] ) );


    if( isset( $_POST['meta-page-beforewidgetsdisplay'] ) )
        update_post_meta( $pid, 'meta-page-beforewidgetsdisplay', esc_attr( $_POST['meta-page-beforewidgetsdisplay'] ) );

    if( isset( $_POST['meta-page-afterwidgetsdisplay'] ) )
        update_post_meta( $pid, 'meta-page-afterwidgetsdisplay', esc_attr( $_POST['meta-page-afterwidgetsdisplay'] ) );

    if( isset( $_POST['meta-page-subcontent1display'] ) )
        update_post_meta( $pid, 'meta-page-subcontent1display', esc_attr( $_POST['meta-page-subcontent1display'] ) );

    if( isset( $_POST['meta-page-subcontent2display'] ) )
        update_post_meta( $pid, 'meta-page-subcontent2display', esc_attr( $_POST['meta-page-subcontent2display'] ) );




}
add_action("save_post", "save_page_meta_box", 10, 3);


?>
