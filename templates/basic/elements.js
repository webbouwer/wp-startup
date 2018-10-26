
(function($){
    $(window).load(function(){

        // content & sidebar size
        function setContentWidth(){

            if($(window).width() < 680 ){
                $('#maincontent,#sidecontent').css({ 'width': '100%' });
            }else{
                $('#maincontent').css({ 'width': '<?php echo $mainwidth; ?>%' });
                $('#sidecontent').css({ 'width': '<?php echo $sidewidth; ?>%' });
            }
        }
        function setTopElements(){
            if($(window).width() < 680 ){
                /*
                $('#upperbar,#topbar').css({ 'position': 'relative'  });
                $('#topbar').css({ 'top': 0 });
                $('#header').css({ 'margin-top': 0 });
                */
            }else{
                /*
                $('#upperbar,#topbar').css({ 'position': 'absolute'  });
                $('#topbar').css({ 'top': $('#upperbar').innerHeight() });
                $('#header').css({ 'margin-top': $('#topbar').innerHeight() });
                */
            }
        }
        setTopElements();
        setContentWidth();


        // resize
        var resizeId;
        $(window).resize(function() {
          clearTimeout(resizeId);
          resizeId = setTimeout(doneGlobalResizing, 20);
        });

        function doneGlobalResizing(){
            setTopElements();
            setContentWidth();
        }

    });

})(jQuery);
