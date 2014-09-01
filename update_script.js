jQuery(function() {
    var description = jQuery('.description_slide', this).text();
    var image = jQuery('.image_slide', this).text();

    jQuery('.titre_slide').dbclick(function(ev) {
        var titre = jQuery('.titre_slide', this).text();
        jQuery('.titre_slide', this).remove().append("<input type='text' name='titre' value='" + titre + "'>");
    }
});

