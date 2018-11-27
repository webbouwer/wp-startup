<?php
// remove the default common theme styles (comment out to keep)
add_action('wp_print_styles', 'wp_startup_theme_deregister_func', 100);

// Add theme stylesheet link to wp_head
add_action( 'wp_head', 'wpstartup_theme_stylesheet', 9999 );

function wpstartup_theme_stylesheet(){

    // theme default positioning & styling
    $globalstyle = plugins_url().'/wp-startup/templates/basic/global.css';
    echo '<link rel="stylesheet" id="wp-startup-theme-style"  href="'.$globalstyle.'" type="text/css" media="all" />';
    // theme default element positioning javascript
    echo '<script type="text/javascript" src="'.plugins_url().'/wp-startup/templates/basic/elements.js"></script>';

    // theme custom styling
    $stylesheet = plugins_url().'/wp-startup/templates/basic/style.css';
    echo '<link rel="stylesheet" id="wp-startup-theme-style"  href="'.$stylesheet.'" type="text/css" media="all" />';

}


// the current page/post data
global $post;

// determine header image
$header_image = get_header_image();

// header textcolor
$header_text_color = get_header_textcolor();

// page content and sidebar width (jquery onresize)
$sidewidth = 100;
$mainwidth = 100; // extend with page / post settings
if( get_theme_mod('wp_startup_theme_panel_elements_sidebar', 'right' ) != 'hide' ){
    $sidewidth = get_theme_mod('wp_startup_theme_panel_elements_sidebarwidth', 23 );
    $mainwidth = 100 - $sidewidth;
}



// theme html output toplogo (custom_logo) or site title home link
function wpstartup_toplogo_html(){

    if( get_theme_mod('custom_logo', '') != '' ){
        $custom_logo_id = get_theme_mod('custom_logo');
        $custom_logo_attr = array(
            'class'    => 'custom-logo',
            'itemprop' => 'logo',

        );
        echo sprintf( '<a href="%1$s" class="custom-logo-link image" rel="home" itemprop="url">%2$s</a>',
        esc_url( home_url( '/' ) ),
        wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )
        );
    }else{
        echo sprintf( '<a href="%1$s" class="custom-logo-link text" rel="home" itemprop="url">%2$s</a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name', 'display' ) ) //get_bloginfo( 'description' )
        );
    }
}
// theme html output menu's by name (str or array)
function wpstartup_menu_html( $menu ){
    if( $menu != '' || is_array( $menu ) ){
        if( is_array( $menu ) ){
            // multi menu
            foreach( $menu as $nm ){

                if( has_nav_menu( $nm ) ){
                    echo '<div id="'.$nm.'menubox"><div id="'.$nm.'menu" class=""><nav><div class="innerpadding">';
                    //if( $nm == 'top' ){
                    echo '<div class="menutoggle"><span>menu</span></div>';
                    //}
                    wp_nav_menu( array( 'theme_location' => $nm ) );
                    echo '<div class="clr"></div></div></nav></div></div>';
                }
            }
        }else if( has_nav_menu( $menu ) ){
            // single menu
            echo '<div id="'.$menu.'menubox"><div id="'.$menu.'menu" class=""><nav><div class="innerpadding">';
            //if( $menu == 'top' ){
                echo '<div class="menutoggle"><span>menu</span></div>';
            //}
            wp_nav_menu( array( 'theme_location' => $menu , 'menu_class' => 'nav-menu' ) );
            echo '<div class="clr"></div></div></nav></div></div>';
        }
    }
}

// theme html output widget area's by type or default
function wpstartup_widgetarea_html( $id, $type = false ){
    if( isset($id) && $id != '' ){
        if( function_exists('dynamic_sidebar') && function_exists('wp_startup_is_sidebar_active') && wp_startup_is_sidebar_active( $id ) ){
            $class = 'widgetbox';
            if( isset($type) && $type != '' ){
                $class = 'widgetbox widget-'.$type;
                echo '<div id="'.$id.'" class="'.$class.'">';
            }else{
                echo '<div id="'.$id.'" class="'.$class.' columnbox colset'.wp_startup_is_sidebar_active( $id ).'">';
            }
            dynamic_sidebar( $id );
            echo '<div class="clr"></div></div>';
        }else if( is_customize_preview() ){

            echo '<div id="'.$id.'" class="customizer-placeholder"> -- Widget area '.$id.' -- </div>';

        }
    }
}
//    widgets & menu sidebar content
function wpstartup_sidebar_html(){

                    if( has_nav_menu('side') ){
                        echo '<div id="sidebarmenu">';
                        wpstartup_menu_html( 'side' );
                        echo '<div class="clr"></div></div>';
                    }


                    if( !is_page() && !is_single() && wp_startup_is_sidebar_active('sidebar-1') ){
                        echo '<div id="sidebarcontent">';
                        wpstartup_widgetarea_html( 'sidebar-1' );
                        echo '<div class="clr"></div></div>';
                    }else if( wp_startup_is_sidebar_active( 'sidebar-widget' ) ){
                        echo '<div id="sidebarcontent">';
                        wpstartup_widgetarea_html( 'sidebar-widget' );
                        echo '<div class="clr"></div></div>';
                    }
}


// to use twentyseven frontpage sections
function wp_startup_get_frontpage_sections(){
    $my_theme = wp_get_theme();
    if ( $my_theme->get( 'Name' ) ==  'Twenty Seventeen' ){
         if ( 0 !== twentyseventeen_panel_count()  ){ // ||  If we have pages to show.
            $num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
            global $twentyseventeencounter;
            for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
                $twentyseventeencounter = $i;
                twentyseventeen_front_page_section( null, $i );
            }
        }else if( is_customize_preview() ){
            echo '<div align="center"> -- Customizer > Theme options:  add info sections -- </div>';
        }
    }
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php

    if ( ! isset( $content_width ) ) $content_width = 360; // mobile first

    echo '<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	.'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	.'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
    // more info for og api's
    echo '<meta property="og:title" content="' . get_the_title() . '"/>'
        .'<meta property="og:type" content="website"/>'
		.'<meta property="og:url" content="' . get_permalink() . '"/>'
		.'<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'"/>'
		.'<meta property="og:description" content="'.get_bloginfo( 'description' ).'"/>';

        if( !has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
            if( !empty($header_image) ){
                $default_image = get_theme_mod( 'imagazine_globalshare_defaultimage', get_header_image() );
                echo '<meta property="og:image" content="' . $default_image . '"/>';
            }
		}else{
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
		}
    // include wp head
    wp_head();

?>

<script>
(function($){


    $(window).load(function(){

        // content & sidebar on load/resizeEnd
        function setContentWidth(){
            if($(window).width() <= 680 ){
                $('#maincontent,#sidecontent').css({ 'width': '100%' });
            }else{
                $('#maincontent').css({ 'width': '<?php echo $mainwidth; ?>%' });
                $('#sidecontent').css({ 'width': '<?php echo $sidewidth; ?>%' });
            }
        }

        // header height on load/resizeEnd
        <?php $hph = get_theme_mod('wp_startup_theme_header_image_height', 40 );
        $hmh = get_theme_mod('wp_startup_theme_header_image_minheight', 200 ); ?>
        function setHeaderHeight(){


                var percentPxHeight = <?php echo $hmh; ?>;
                if( <?php echo $hmh; ?> < ( $(window).height() / 100 * <?php echo $hph; ?> ) ){
                   var percentPxHeight = $(window).height() / 100 * <?php echo $hph; ?>;
                }
            if( $('#header').css('background-image') !== 'none'){
                $('#header').css({ 'min-height': percentPxHeight });
            }

        }

        // menu's on load/resizeEnd
        function setResponsiveMenu(){

            if($(window).width() <= 680 ){ // small screen css & js
                // add click/touch control
                $('body').unbind().on( 'click touchend', '.menutoggle,li.menu-item-has-children > a', function(event){
                  if (event.preventDefault) {
                    event.preventDefault();
                  } else {
                    event.returnValue = false;
                  }
                  event.stopPropagation(); // parent no click
                  if ($(this).parent().hasClass('dropped')) {
                    if ($(this).hasClass('menutoggle')) {
                        // close all menu's including this
                        $('.menutoggle').parent().removeClass('dropped');
                    } else {
                        // close this submenu
                        $(this).parent().removeClass('dropped');
                        // and all other child menu's
                        $(this).parent().find('ul li.menu-item-has-children').removeClass('dropped'); // closed state
                    }
                    $(this).parent().find('ul li.parentClone').remove(); // onclose remove parent clones
                  } else {
                    if ($(this).hasClass('menutoggle')) {
                      // close all menu's
                      $('.menutoggle, ul li.menu-item-has-children > a').parent().removeClass('dropped');
                    }else{
                        // clone parent link to sublevel
                        $(this).parent().find('ul:first').prepend( $(this).clone() );
                        // wrap parentClone class link
                        $(this).parent().find('ul:first a:first').wrap('<li class="menu-item parentClone" />');
                    }
                    $(this).parent().addClass('dropped'); // dropped state
                  }

                });

            }else{ // large screen pure css
                $('body').find('ul li.parentClone').remove(); // remove parent clones
                $('body').find('.innerpadding, ul li.menu-item-has-children').removeClass('dropped'); // return to closed states
                $('.menutoggle,li.menu-item-has-children > a').unbind('click'); // unbind click/touch events
            }
        }

        // on window resize
        function doneWindowResizing(){
            setResponsiveMenu();
            setHeaderHeight();
            setContentWidth();
        }
        doneWindowResizing();

        // resize
        var resizeId;
        $(window).resize(function() {
          clearTimeout(resizeId);
          resizeId = setTimeout(doneWindowResizing, 20);
        });


    });

})(jQuery);

</script>
</head>
<body <?php body_class(); ?>>
     <div id="pagecontainer" class="site">


                <?php

                // upperbar
                if( get_theme_mod('wp_startup_theme_panel_elements_upperbar', 'hide') == 'show'){
                    echo '<div id="upperbar"><div class="outermargin">';

                    // upperbar menu
                    if( has_nav_menu('upper') ){
                        echo '<div id="upperbarmenu">';
                            wpstartup_menu_html( 'upper' );
                        echo '<div class="clr"></div></div>';
                    }

                    if( wp_startup_is_sidebar_active( 'upperbar-widget' ) ){
                        wpstartup_widgetarea_html( 'upperbar-widget' );
                    }
                    echo '<div class="clr"></div></div></div>';
                }

                echo '<div id="topbar"><div class="outermargin">';

                if( wp_startup_is_sidebar_active( 'topbar-widget-1' ) ){
                    wpstartup_widgetarea_html( 'topbar-widget-1' );
                }

                // topbar logo
                $lmw =  get_theme_mod('wp_startup_theme_panel_content_logowidth', 200 );
                echo '<div id="toplogobox" style="max-width:'.$lmw.'px;">';
                wpstartup_toplogo_html();
                echo '</div>';

                // topbar menu
                if( has_nav_menu('top') || has_nav_menu('primary') ){
                    // topbar menu is top & primary || default menu
                    $topmenu = array( 'top', 'primary' );
                    wpstartup_menu_html( $topmenu );
                }else{
                    // main menu
                    wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'topmenu' ) );
                }

                // topbar side widgets
                if( wp_startup_is_sidebar_active( 'topbar-widget-2' ) ){
                    wpstartup_widgetarea_html( 'topbar-widget-2' );
                }


                // contactbox
                if( get_theme_mod('wp_startup_theme_panel_content_email', '') != ''
                    || get_theme_mod('wp_startup_theme_panel_content_telephone', '') != ''
                    || get_theme_mod('wp_startup_theme_panel_content_office_address', '') != ''
                    || get_theme_mod('wp_startup_theme_panel_content_contact_info', '') != ''){

                    echo '<div id="contactbox">';

                        if( get_theme_mod('wp_startup_theme_panel_content_contact_info', '') != ''){
                            echo '<div class="contactinfo">'.get_theme_mod('wp_startup_theme_panel_content_contact_info').'</div>';
                        }
                        if( get_theme_mod('wp_startup_theme_panel_content_office_address', '') != ''){
                            echo '<div class="addressinfo">'.get_theme_mod('wp_startup_theme_panel_content_office_address').'</div>';
                        }
                        if( get_theme_mod('wp_startup_theme_panel_content_email', '') != ''){
                            echo '<a class="emaillink" href="mailto:'.get_theme_mod('wp_startup_theme_panel_content_email').'">'.get_theme_mod('wp_startup_theme_panel_content_email').'</a>';
                        }
                        if( get_theme_mod('wp_startup_theme_panel_content_telephone', '') != ''){
                            echo '<a class="tellink" href="tel:'.get_theme_mod('wp_startup_theme_panel_content_telephone').'">'.get_theme_mod('wp_startup_theme_panel_content_telephone').'</a>';
                        }

                    echo '<div class="clr"></div></div>';
                }

                echo '<div class="clr"></div></div></div>';

                // div header
                $header_set = get_theme_mod('wp_startup_theme_panel_elements_postheader', 'none' );
                $mh = get_theme_mod('wp_startup_theme_header_image_height', 200 );
                $header_bgimage = get_theme_mod('header_image');
                if( ( is_page() || is_single() ) && $header_set != 'none' && null !== wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )  ){
                    if( ( $header_set == 'page' && is_page() ) || ( $header_set == 'post' && is_single() ) ||  $header_set == 'all' ){
                        $headerorient = wp_startup_check_image_orientation($post->ID);
                        $bgimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                        if( $headerorient == 'portrait' ){
                            $header_set = 'none';
                            $bgimage = 0;
                        }
                        if(!empty( $bgimage ) ){
                            $header_bgimage = $bgimage[0];
                        }
                    }
                }
                if ( ( get_header_image() || !empty( $bgimage ) )
                    && ( $header_set != 'front' || ( get_header_image() && $header_set == 'front' && is_front_page() ) ) ){

                    echo  '<div id="header" class="header_image" style="background-image:url('.$header_bgimage.');background-position:center;background-size:cover;background-repeat:no-repeat;min-height:'.$mh.'px;">';

                }else{
                    echo '<div id="header">';
                }

                echo '<div class="outermargin">';
                if( wp_startup_is_sidebar_active( 'header-widget-1' ) ){
                wpstartup_widgetarea_html( 'header-widget-1' );
                }
                if( wp_startup_is_sidebar_active( 'header-widget-2' ) ){
                wpstartup_widgetarea_html( 'header-widget-2' );
                }
                echo '<div class="clr"></div></div></div>';




                echo '<div id="topcontent"><div class="outermargin">';

                        wpstartup_widgetarea_html( 'topcontent-widget-1' );

                        if( has_nav_menu('main') ){ ?>
                        <div id="mainmenu">
                            <?php // main menu
                            wpstartup_menu_html( 'main' );
                            ?>
                        </div>
                        <?php }

                        wpstartup_widgetarea_html( 'topcontent-widget-2' );

                 echo '<div class="clr"></div></div></div>';

                if( is_front_page() && get_theme_mod('page_layout') == 'one-column'){
                    // Get panels on top
                    wp_startup_get_frontpage_sections();
                    echo '<div class="clr"></div>';
                }



                echo '<div id="maincontainer"><div class="outermargin">';


                if( get_theme_mod('wp_startup_theme_panel_elements_sidebar', 'right') == 'left'){
                    echo '<div id="sidecontent" class="left" style="width:'.$sidewidth.'%;">';
                    wpstartup_sidebar_html();
                    echo '<div class="clr"></div></div>';
                }

                 echo '<div id="maincontent" style="width:'.$mainwidth.'%;">';

                   if( wp_startup_is_sidebar_active( 'before-widget' ) ){ ?>
                    <div id="before-content">
                        <?php wpstartup_widgetarea_html( 'before-widget' ); ?>
                    </div>
                    <?php } ?>

                    <section>
                    <?php

                                if( have_posts() ) {
                                    while( have_posts() ) {
                                        the_post();
                                        ?>
                                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                            <?php // wp_startup_theme_panel_settings_postimage
                                            $contentimage = '';
                                            $orient = wp_startup_check_image_orientation(get_the_ID());
                                            $cntimgset = get_theme_mod('wp_startup_theme_panel_settings_postimage', 'above');
                                            if( ( $header_set == 'page' && is_page() ) || ( $header_set == 'post' && is_single() ) || ( $header_set == 'all' && ( is_page() || is_single() ) ) ){
                                                // in header
                                            }else{
                                                //the_post_thumbnail('big-thumb');
                                                if( $orient == 'portrait' && $cntimgset == 'above'){
                                                    $cntimgset = 'left';
                                                }
                                                $contentimage = get_the_post_thumbnail( get_the_ID(), 'big-thumb', array( 'class' => 'post-image align-'.$cntimgset.' '.$orient ));
                                            }

                                            if( !is_single() && !is_page() ){
                                                $contentimage = '<a class="imagelink" href="'.get_the_permalink().'">'.$contentimage.'</a>';
                                            }

                                            if( ($cntimgset == 'above' || $cntimgset == 'left' || $cntimgset == 'right') && $contentimage != ''){
                                                echo $contentimage;
                                            }
                                            ?>

                                            <header class="entry-header">
                                                <?php if( is_single() || is_page() ){
                                                    echo '<h2 class="entry-title">'.get_the_title().'</h2>';
                                                }else{
                                                    echo '<h2 class="entry-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';
                                                }
                                                if( !is_page() ){
                                                    echo '<div class="entry-title-meta">';
                                                    echo '<span class="date">'.wp_startup_time_ago(get_the_time( 'U' )).'</span>';
                                                    echo ' by <span class="author">'.get_the_author().'</span>';
                                                    echo '</div>';
                                                }
                                                ?>
                                            </header>

                                            <div class="entry-content">
                                            <?php
                                            if( ($cntimgset == 'inlineleft' || $cntimgset == 'inlineright') && $contentimage != ''){
                                                echo $contentimage;
                                            }

                                            if( is_single() || is_page() ){

                                                echo get_the_content();

                                            }else{

                                                echo '<p>';
                                                $textlength = get_theme_mod('wp_startup_theme_panel_settings_excerptlength', 15);
                                                //wp_startup_the_excerpt_length( $textlength, true );  // the_excerpt();
                                                $content = apply_filters('the_content', get_the_content() );
                                                echo wp_startup_truncate( $content, $textlength, '', true, true ); // $text, $length = 100, $ending = '...', $exact = true, $considerHtml = false
                                                echo '</p>';
                                            }
                                            ?>
                                            </div>
                                            <div class="clr"></div>

                                        </article>
                                        <?php
                                    }
                                }
                        ?>
                        </section>

                        <?php if( wp_startup_is_sidebar_active( 'after-widget' ) ){ ?>
                        <div id="after-content">
                            <?php wpstartup_widgetarea_html( 'after-widget' ); ?>
                        </div>
                        <?php }
                            //
                            if( is_front_page() && get_theme_mod('page_layout') == 'two-column'){
                                // Get panels here
                                wp_startup_get_frontpage_sections();
                                echo '<div class="clr"></div>';
                            }

                echo '<div class="clr"></div></div>';

                if( get_theme_mod('wp_startup_theme_panel_elements_sidebar', 'right') == 'right'){
                    echo '<div id="sidecontent" class="right" style="width:'.$sidewidth.'%;">';
                    wpstartup_sidebar_html();
                    echo '<div class="clr"></div></div>';
                }



                echo '<div class="clr"></div></div></div>';


                echo '<div id="subcontainer"><div class="outermargin"><div id="subcontent">';
                wpstartup_widgetarea_html( 'subcontent-widget-1' );
                wpstartup_widgetarea_html( 'subcontent-widget-2' );
                echo '<div class="clr"></div></div></div></div>';
                ?>

                <?php

                echo '<div id="footercontainer"><div class="outermargin"><div id="footercontent">';

                wpstartup_widgetarea_html( 'bottom-widget-1' );

                if( has_nav_menu('bottom') ){
                    // main menu
                    wpstartup_menu_html( 'bottom' );
                }


                wpstartup_widgetarea_html( 'bottom-widget-2' );

                wpstartup_widgetarea_html( 'footer-widget-1' );

                echo '<div id="copyrightbox">'.get_theme_mod('wp_startup_theme_panel_content_copyright', 'copyright 2018').'</div>';

                wpstartup_widgetarea_html( 'footer-widget-2' );
                echo '<div class="clr"></div></div></div></div>';
                ?>

    </div>
    <?php wp_footer(); ?>
</body>
</html>
