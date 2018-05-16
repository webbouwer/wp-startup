<?php
/**
 * Template name: Basic Template
 * Description: A minimal (blank) template to make anything you like.
 */

//echo '<div class="wrap">';
?>


<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div id="page" class="site">


<?php // Page Header

    if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>

<?php

    // Page Header image
    $pagethumb = true;
    if ( ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) && has_post_thumbnail( get_queried_object_id() ) ) :
		echo '<div class="single-featured-image-header">';
		echo get_the_post_thumbnail( get_queried_object_id(), 'twentyseventeen-featured-image' );
		echo '</div><!-- .single-featured-image-header -->';
        $pagethumb = false;
	endif;




// Page content
echo '<div class="wrap">';

if ( have_posts() ) :

while( have_posts() ) : the_post();

if ( is_page() ) { // this must be a page template


   // meta & title
    echo '<div class="titlebox">';

    // title
    echo '<h1><a href="'.get_the_permalink().'">';

        echo get_the_title();

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
    if ( has_post_thumbnail() && $pagethumb == true ) {
        echo '<a class="coverimage" href="'.get_the_permalink().'" title="'.get_the_title().'" >';
            the_post_thumbnail('full');
        echo '</a>';
    }

    // content
    echo '<div class="contentbox">';

    echo apply_filters('the_content', get_the_content());

    echo '</div>';


    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('area-custom1') ) :
    endif;



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
