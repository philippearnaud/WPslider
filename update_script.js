jQuery(function() {
    var description = jQuery('.description_slide', this).text();
    var image = jQuery('.image_slide', this).text();

    jQuery('h4.titre_slide').dblclick(function(ev) {
        var titre = jQuery(this).text();
        jQuery(this).after("<input type='text' name='titre' value='" + titre + "'>").remove();
    });
    
});
