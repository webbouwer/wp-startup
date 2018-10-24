
(function($){
    $(window).load(function(){

        // content & sidebar size
        function setContentWidth(){
            if($(window).width() < 580 ){
                $('#maincontent,#sidecontent').css({ 'width': '100%' });
            }else{
                $('#maincontent').css({ 'width': '<?php echo $mainwidth; ?>%' });
                $('#sidecontent').css({ 'width': '<?php echo $sidewidth; ?>%' });
            }
        }
        setContentWidth();

        // resize
        var resizeId;
        $(window).resize(function() {
          clearTimeout(resizeId);
          resizeId = setTimeout(doneGlobalResizing, 20);
        });

        function doneGlobalResizing(){
          setContentWidth();
        }

    });

})(jQuery);
