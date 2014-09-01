jQuery(function() {

    //Doubleclick titre_slide: apparition champ input/disparition h4
    jQuery('h4.titre_slide').dblclick(function(ev) {
        var titre = jQuery(this).text();
        jQuery(this).after("<input id='titre_slide' type='text' name='titre' value='" + titre + "'>").hide();
    jQuery(this).after("<button name='titre'>Modification du titre </button>");
    });

    //Doubleclick description_slide: apparition champ textarea/disparition p
    jQuery('.description_slide').dblclick(function(ev) {
        var description = jQuery(this).text();
        jQuery(this).after("<textarea name='description' row='50' cols='50'>"+ description + "</textarea>").hide();
        jQuery(this).after("<button name='description'>Modification de la description </button>");
    });


    //doubleclick image_slide: apparition uploader photo/disparition image
    jQuery('.image_slide').dblclick(function(ev) {
        var image = jQuery('.image_slide', this).text();
        var html = "<label for='upload_display_image'>";
        html    +=    "<input class='upload_display_image'	type='text' size='36' name='upload_image'>";
        html    += "<input class='upload_display_image_button' type='button' value='Upload Image'>";
        html    += "<br/> Entrez une Url or téléchargez une image";
        html    += "</label>";
        jQuery(this).after(html).hide();
        jQuery(this).after("<button name='image'> Modification de l'image</button>");

        //Code permettant d'utiliser le gestionnaire de photo.
        var custom_uploader;
        jQuery('.upload_display_image_button').click(function(e) {
            e.preventDefault();

            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                jQuery('.upload_display_image').val(attachment.url);
            });
            custom_uploader.open();
            });
    });
});
