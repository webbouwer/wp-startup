jQuery( document ).ready( function( $ ) {
    // Tabs
    var $view = $( '.nav-view' );
    var $navi = $( '.nav-tab-wrapper' );
    var $navs = $( '.nav-tab' );
    var $tabs = $( '.tabs' );
    var $lt    = '';
    var toggleView = function() {

       if( !$view.hasClass('active') ){

           // switch to full page view
           $navi.hide();
           $tabs.show();
           $view.addClass('active');

       }else{

            // switch to tab view
           $navi.show();
           $tabs.hide();
           $view.removeClass('active');
           $tabs.hide();
           if( !window.location.hash || window.location.hash == '' ){
                $tabs.first().show();
           }else{
                $( window.location.hash ).show();
           }

       }

    }
    var toggleTab = function( hash ) {

        $navs.removeClass( 'nav-tab-active' );
        $( 'a[href=' + hash + ']' ).addClass( 'nav-tab-active' );
        $tabs.hide();
        $lt = hash;
        $( hash ).show();

    };

    if( !window.location.hash || window.location.hash == '' || !$( 'a[href=' + window.location.hash + ']' ) ){

        $tabs.hide();
        $navs.first().addClass( 'nav-tab-active' );
        $tabs.first().show();

    }else{

        toggleTab( window.location.hash );

    }

    $view.on( 'click', function( e ) {

        e.preventDefault();
        //var hash = e.target.hash;
        toggleView();

    });

    $navs.on( 'click', function( e ) {

        e.preventDefault();
        var hash = e.target.hash;
        toggleTab( hash );
        history.replaceState( {page: hash}, 'title ' + hash, hash );

    });

});
