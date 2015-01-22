jQuery(document).ready( function() {

    jQuery(".user_vote").click( function() {
        post_id = jQuery(this).attr("data-post_id")
        nonce = jQuery(this).attr("data-nonce")

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : ajaxurl,
            data : {action: "my_action"},
            success: function(response) {
                //alert(response);
                jQuery('#program_event').text(response);
                if(response.type == "success") {
                    //jQuery("#vote_counter").html(response.vote_count)

                }
                else {
                   // alert("Your vote could not be added")
                }
            }
        })

    })

})