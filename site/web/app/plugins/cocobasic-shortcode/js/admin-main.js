(function ($) {
    "use stict";
    var custom_uploader;
    var custom_uploader2;

    checkPreviewBackground();
    setPreviewBackgroundOnLoad();

    $(window).on('load', function () {
        $('#upload_image_button').on('click', function (e) {
            var return_field = $(this).prev();
            e.preventDefault();
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function () {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                $(return_field).val(attachment.url);

                var imgcheck = attachment.url.width;
                if (imgcheck !== 0) {
                    $('#small-background-image-preview').css('background-image', 'url(' + attachment.url + ')').addClass('has-background');
                }

            });
            //Open the uploader dialog
            custom_uploader.open();
        });
        $('#upload_image_button2').click(function (e) {

            var return_field = $(this).prev();
            e.preventDefault();
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader2) {
                custom_uploader2.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader2 = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader2.on('select', function () {
                attachment = custom_uploader2.state().get('selection').first().toJSON();
                $(return_field).val(attachment.url);

                var imgcheck = attachment.url.width;
                if (imgcheck !== 0) {
                    $('#small-background-image-preview').css('background-image', 'url(' + attachment.url + ')').addClass('has-background');
                }

            });
            //Open the uploader dialog
            custom_uploader2.open();
        });
    });

    function setPreviewBackgroundOnLoad() {
        $('.image-url-input').each(function () {
            if ($(this).val() !== '') {
                $(this).nextAll('#small-background-image-preview:first').css('background-image', 'url(' + $(this).val() + ')');
            } else {
                $(this).nextAll('#small-background-image-preview:first').removeClass('has-background');
            }
        });
    }

    function checkPreviewBackground() {
        $('.image-url-input').on('change', function () {
            if ($(this).val() === '') {
                $(this).nextAll('#small-background-image-preview:first').css('background-image', 'none').removeClass('has-background');
            }
        });
    }
})(jQuery);