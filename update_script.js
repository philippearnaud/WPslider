jQuery(function() {
    var image = jQuery('.image_slide', this).text();

    jQuery('h4.titre_slide').dblclick(function(ev) {
        var titre = jQuery(this).text();
        jQuery(this).after("<input type='text' name='titre' value='" + titre + "'>").remove();
    });

    jQuery('.description_slide').dblclick(function(ev) {
        var description = jQuery('.description_slide', this).text();
        jQuery(this).after("<textarea name='description' value='" + description + "' row='50' cols='50'>").remove();
    });

        

    });
});
