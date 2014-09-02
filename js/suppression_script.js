jQuery(document).ready(function() {
    jQuery(".suppression_slide").click(function() {
        var slide_id = jQuery(this).attr('data-slide_id');
        var nonce = jQuery(this).attr('data-nonce');

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {action: "suppression_slide", slide_id : slide_id, nonce : nonce },
            success: function(response) {
                if(response.type == "success") {
                    alert('it works');
                    console.log('ça marche');
                }
                else {
                    alert('Bouh');
                    console.log('ca marche pas');
                    }
            }
        })
    })
})

