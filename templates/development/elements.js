
(function($){
    $(window).load(function(){


        // resize
        var doResizeId;
        $(window).resize(function() {
          clearTimeout(doResizeId);
          doResizeId = setTimeout(doGlobalResizing, 20);
        });

        function doGlobalResizing(){
        }

    });

})(jQuery);
