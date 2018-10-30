
(function($){
    $(window).load(function(){


        // resize
        var resizeId;
        $(window).resize(function() {
          clearTimeout(resizeId);
          resizeId = setTimeout(doneGlobalResizing, 20);
        });

        function doneGlobalResizing(){
        }

    });

})(jQuery);
