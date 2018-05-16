<?php
/**
 * Template name: WP-Startup Basic Homepage
 * Description: A minimal (blank) homepage template to make anything you like.
 */

get_header();

echo '<div class="wrap">';

// search
if( is_search() ){ // search results
echo '<div class="searchheader">';
echo 'Search result for '; // or translate this with theme namespace .__('Result for ', 'imagazine' ).
echo '<strong>'.wp_specialchars($s).'</strong></div>';
}


// post or list content
if ( have_posts() ) :

while( have_posts() ) : the_post();

if ( is_page() ) { // this must be a page template


    if ( is_super_admin() ) {
        edit_post_link( "Edit", '<span class="edit-link">', '</span>' );
    }

    // content
    echo apply_filters('the_content', get_the_content());


    /* meta
    echo '<span>';
    wp_time_ago(get_the_time( 'U' ));
    echo '</span>';

    echo ' <span class="post-author">By '.get_the_author().'</span> ';
    */

}else{

   // otherwise you must know what your doing
   echo 'This is a basic template file where the coder should make his Wordpress knowledge worth to notice';

}

endwhile;

endif;



// get_sidebar();


echo '</div>';

get_footer();
?>
