<?php
/**
 * WP Startup Blog Theme functions
 */

/**
 * localize functions
 * AJAX filter posts
 */
function ajax_filter_posts_scripts() {
  // Enqueue script
  //wp_register_script('afp_script', 'get_template_directory_uri() . '/js-folder/'ajax-filter-posts.js', false, null, false);
  wp_register_script('afp_script', plugin_dir_url( __FILE__ ) . 'ajax-filter-posts.js', false, null, false);
  wp_enqueue_script('afp_script');

  wp_localize_script( 'afp_script', 'afp_vars', array(
        'afp_nonce' => wp_create_nonce( 'afp_nonce' ), // Create nonce which we later will use to verify AJAX request
        'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
      )
  );
}
add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);

/**
 * Theme functions
 * AJAX simple tag filter menu
 * action in index.php (html)
 * Blog theme
 */
function wp_startup_ajax_filter_menu() {
    $tax = 'post_tag';
    $terms = get_terms( $tax );
    $count = count( $terms );

    if ( $count > 0 ): ?>
        <div class="post-tags">
        <?php
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term, $tax );
            echo '<a href="' . $term_link . '" class="tax-filter" title="' . $term->slug . '">' . $term->name . '</a> ';
        } ?>
        </div>
    <?php endif;
}


/* ajax functions loaded with plugin functions.php */



/*
function post_html_output(){

    if( have_posts() ) {

        while( have_posts() ) {

            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php
                //the_post_thumbnail('big-thumb');
                echo get_the_post_thumbnail( get_the_ID(), 'big-thumb', array( 'class' => 'post-image' ));
                ?>
                <header class="entry-header">
                <?php if( is_single() || is_page() ){
                        echo '<h2 class="entry-title">'.get_the_title().'</h2>';
                    }else{
                        echo '<h2 class="entry-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
                }?>
                </header>

                <div class="entry-content">
                <?php
                    if( is_single() || is_page() ){
                        echo get_the_content();
                    }else{
                        echo '<p>';
                        the_excerpt_length( 15, true );  // the_excerpt();
                        echo '</p>';
                    }
                ?>
                </div>

            </article>
            <?php
            }
        } // end post loop

}



$args = array(
    //'child_of'                 => get_category_by_slug($topcat)->term_id,
    'orderby'                  => 'name',
    'order'                    => 'ASC',
    'public'                   => true,
);
$categories = get_categories( $args );

$cat_tags = ''; // tags by category
$tag_idx = ''; // all tags csv string for javascript array
$idxtags = '';
$alltags = array(); // all tags csv string for javascript array

$filtermenubox = ''; // output taglists ordered by category filter
$filtermenubox .= '<ul id="topgridmenu" class="categorymenu">';// start filtermenu html
$filtermenubox .= '<li><a class="category selected" href="#" data-filter="*">All</a></li>';

foreach ( $categories as $category ) {

//if( isset($topcat) && $category->slug != $topcat ){
$filtermenubox .= '<li><a class="category cat-' . $category->slug . '" href="#" data-filter="' . $category->slug . '">' . $category->name . '</a>';
    //if( isset($filters) && $filters == 'all'){

	$posttags = '';
	$postids = get_objects_in_term( $category->term_id, 'category' );

      if( !is_wp_error( $postids ) && !empty( $postids ) ){
        //get the tags for the posts...
        $tags = wp_get_object_terms( (array)$postids, 'post_tag' );
        if( !is_wp_error( $tags ) && !empty( $tags ) ){
          //make a link for each tag...
          foreach( $tags as $tag ){
            //simple paragraph containing linked tag name...
            $posttags .='<li><a class="tag-'.$tag->name.'" href="'.get_site_url().'/tag/'.$tag->name.'/" rel="tag">'.$tag->name.'</a></li>';
			if( !in_array( $tag->name, $alltags) ){
				$alltags[] = $tag->name;
				$idxtags .= '"'.$tag->name.'", ';
			}
          }
        }
      }

    $cat_tags .='<ul class="tagmenu '.$category->slug.'">'.$posttags.'</ul>';
    $tag_idx .= $idxtags;


    //}
	$filtermenubox .= '</li>';
  //}
}
$filtermenubox .= '</ul>';


//$alltagmenuoptions = '';
//foreach( $alltags as $id => $tag){
//$alltagmenuoptions .= '<li><a class="tag-'.$tag.'" href="'.get_site_url().'/tag/'.$tag.'/" rel="tag">'.$tag.'</a></li>';
//}
//$filtermenubox .= '<ul class="tagmenu overview active">'.$alltagmenuoptions.'</ul>'; // fille up with all tags from other menu's, js script at bottom.

$filtermenubox .= $cat_tags;
*/
