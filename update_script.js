jQuery(function() {

    jQuery('h4.titre_slide').dblclick(function(ev) {
        var titre = jQuery(this).text();
        jQuery(this).after("<input type='text' name='titre' value='" + titre + "'>").hide();
    });

    jQuery('.description_slide').dblclick(function(ev) {
        var description = jQuery(this).text();
        jQuery(this).after("<textarea name='description' row='50' cols='50'>"+ description + "</textarea>").hide();
    });

    jQuery('.image_slide').dblclick(function(ev) {
        var image = jQuery('.image_slide', this).text();
        var html = "<label for='upload_display_image'>";
        html    +=    "<input class='upload_display_image'	type='text' size='36' name='upload_image'>";
        html    += "<input class='upload_display_image_button' type='button' value='Upload Image'>";
        html    += "<br/> Entrez une Url or téléchargez une image";
        html    += "</label>";
        jQuery(this).after(html).hide();
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
