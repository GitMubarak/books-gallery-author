(function($) {

    // USE STRICT
    "use strict";

    var aw_uploader = '';
    $("#books_author_media_remove").hide();

    //alert('Hi');
    $('body').on('click', '#books_author_media_button', function(e) {
        //alert('Hello');
        e.preventDefault();
        aw_uploader = wp.media({
                title: 'Books Gallery Author Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).on('select', function() {
                var attachment = aw_uploader.state().get('selection').first().toJSON();
                $('#books_author_image_wrapper').html('');
                $('#books_author_image_wrapper').html(
                    "<img src=" + attachment.url + " style='width: 200px'>"
                );
                $('#books_author_image_id').val(attachment.url);
                $("#books_author_media_button").hide();
                $("#books_author_media_remove").show();
            })
            .open();
    });

    $("#books_author_media_remove").click(function() {
        $('#books_author_image_wrapper').html('');
        $('#books_author_image_id').val('');
        $(this).hide();
        $("#books_author_media_button").show();
    });

})(jQuery);