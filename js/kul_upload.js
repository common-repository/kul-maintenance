function kul_uploads_multimedia_init(title, buTTon, ediT, mulTiple) {
    var outArray = [];
    var file_frame;
    if (file_frame) {
        file_frame.open();
        return;
    }

    file_frame = wp.media.editor.send.attachment = wp.media({
        title: title,
        button: {
            text: buTTon
        },
        editing: ediT,
        multiple: mulTiple,
    });
    return file_frame;
}

jQuery(document).ready(function () {
    jQuery('.upload_btn').live('click', function (event) {
        event.preventDefault();
        var kulUploadElem = jQuery(this);
        var customData = kulUploadElem.data('imagetype');
        var customClass = '';

        var file_frame = kul_uploads_multimedia_init('Upload Image', 'Select Image', true, false);
        file_frame.on('select', function () {
            var selection = file_frame.state().get('selection');
            selection.map(function (attachment) {
                attachment = attachment.toJSON();
                var image_url = attachment.url,
                    image_id = attachment.id;
                kulUploadElem.parent().find('.delete-img').remove();
                kulUploadElem.parent().find('.boxes').css('background-image', 'url(' + image_url + ')');
                kulUploadElem.parent().find('.boxes').append('<input class="button delete-img remove" type="submit" name="remove_bg" value="x" />');
                kulUploadElem.parent().parent().find('input[type="hidden"]').val(image_url);
            });

        });

        file_frame.open();
        return false;
    });

    jQuery('.delete-img').live('click', function (event) {
        event.preventDefault();
        var kulUploadElem = jQuery(this);
        kulUploadElem.parent().css('background-image', 'none');
        kulUploadElem.parent().parent().parent().find('input[type="hidden"]').val('');
        kulUploadElem.remove();
        return false;
    });

}); 