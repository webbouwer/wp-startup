<?php

/**
 * Category Hierarchy
 */
function wp_startup_keep_category_hierarchy_func(){

        add_filter( 'widget_text', 'do_shortcode' );
        add_filter( 'wp_terms_checklist_args', 'wp_startup_terms_checklist_args', 1, 2 );
        function wp_startup_terms_checklist_args( $args, $post_id ) {
            $args[ 'checked_ontop' ] = false;
            return $args;
        }

}



/** Remove Emoji junk by Christine Cooper
 * Found on http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function wp_startup_disable_wp_emojicons_func() {
  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' ); // filter to remove TinyMCE emojis
}
function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


?>
