/* AJAX filter posts */

/* notes
* https://www.slushman.com/troubleshooting-wordpress-ajax/
*/

jQuery(document).ready(function($){

        // on ready use url variable filter or load recent posts

            // get loaded posts

            // tag list

            // category structure incl. taglists




        // on menu click (page load)

        // on category filter click

        // on tag filter click
       $('.tax-filter').click( function(event) {

        // Prevent default action - opening tag page
        if (event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }

        // Get tag slug from title attirbute
        var selected_taxonomy = $(this).attr('title');

          $.ajax({
			url: afp_vars.afp_ajax_url,
			data:{
                'action': 'filter_posts', // function to execute
                'afp_nonce': afp_vars.afp_nonce, // wp_nonce
                'taxonomy': selected_taxonomy, // selected tag
            }, // form data
            dataType: 'json',
			type: 'POST', // POST
			beforeSend:function(xhr){
				$('.tagged-posts').fadeOut();
			},
			success:function(data){
				// Display posts on page
                $('.tagged-posts').html( JSON.stringify(data) );
                // Restore div visibility
                $('.tagged-posts').fadeIn();
			}
		});

        console.log(selected_taxonomy);


    });
});
