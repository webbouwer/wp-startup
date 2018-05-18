<?php
/**
 * Template name: WP-Startup Basic Homepage
 * Description: A minimal (blank) homepage template to make anything you like.
 */




get_header();


function frontpagesections(){

   // Get each of our panels and show the post data.
   if ( 0 !== twentyseventeen_panel_count() || is_customize_preview() ) { // If we have pages to show.
    /** Filter number of front page sections in Twenty Seventeen.
    * @since Twenty Seventeen 1.0
	* @param int $num_sections Number of front page sections.
    */
			$num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
			global $twentyseventeencounter;

			// Create a setting and control for each of the sections available in the theme.
			for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
				$twentyseventeencounter = $i;
				twentyseventeen_front_page_section( null, $i );
			}
   } // The if ( 0 !== twentyseventeen_panel_count() ) ends here.

}

// post or list content
if ( have_posts() ) :

while( have_posts() ) : the_post();

if ( is_page() ) { // this must be a page template


    // basic Twenty Seventeen theme Homepage sections
    if( is_front_page() && get_option( 'page_on_front' ) == get_the_ID() && twentyseventeen_panel_count() !== 0 ){

        frontpagesections();

    }else{

    // default content wrap
    echo '<div class="wrap">';

    // search
    if( is_search() ){ // search results
    echo '<div class="searchheader">'. __('Search results for', 'wp-startup' ) .' <strong>'.wp_specialchars($s).'</strong></div>';
    }



    // meta & title
    echo '<div class="titlebox">';

    // title
    echo '<h1><a href="'.get_the_permalink().'">';
        if( is_search() ){
            echo get_the_title();//echo search_title_highlight();
        }else{
            echo get_the_title();
        }
    echo '</a></h1>';

    // time
    $t = get_the_time( 'U' );
    printf( _x( '%s '.__('ago','wp-startup'), '%s = human-readable time difference', 'wp-startup' ), human_time_diff( $t, current_time( 'timestamp' ) ) );
    echo '</span>';

    // author
    echo ' <span class="post-author">'. __('by','wp-startup') .' '. get_the_author() .'</span>';

    // admin
    if ( is_super_admin() ) {
        edit_post_link( __('edit','wp-startup'), ' <span class="edit-link">', '</span>' );
    }
    echo '</div>';

    // thumb image
    if ( has_post_thumbnail() ) {
        echo '<a class="coverimage" href="'.get_the_permalink().'" title="'.get_the_title().'" >';
            the_post_thumbnail('medium');
        echo '</a>';
    }
    // content
    echo '<div class="contentbox">';

    echo apply_filters('the_content', get_the_content());

    echo '</div>';


    echo '</div>'; // end wrap


    }

}else{

   // otherwise you must know what you'r doing
   echo 'This is a basic template file where the coder should make his Wordpress knowledge worth to notice';

}

endwhile;

endif;


// get_sidebar();


get_footer();
?>
