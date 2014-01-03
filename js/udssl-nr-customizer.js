(function($) {
    "use strict";

    /**
     * Title
     */
    wp.customize('udssl_nr_options[nr_title_text]', function(value){
        value.bind(function(to) {
            $('#udssl_nr_title' ).html(to);
        });
    });
    wp.customize('udssl_nr_options[nr_title_color]', function(value){
        value.bind(function(to) {
            $('#udssl_nr_title').css('color', to);
        });
    });
    wp.customize('udssl_nr_options[nr_title_font_size]', function(value){
        value.bind(function(to) {
            $('#udssl_nr_title').css('font-size', to + 'px');
        });
    });

    /**
     * Text Color
     */
    wp.customize('udssl_nr_options[nr_text_color]', function(value){
        value.bind(function(to) {
            $('#udssl_nr_body').css('color', to);
        });
    });
    wp.customize('udssl_nr_options[nr_text_font_size]', function(value){
        value.bind(function(to) {
            var bodysize = $('#udssl_nr_body').css('font-size');
            var size = $('.udssl_nr_reading_item_text').css('font-size');
            var ratio = bodysize / size;
            var newsize = size.slice(0, -2) * ratio;

            $('.udssl_nr_reading_item_text').css('font-size', newsize + 'px');
            $('#udssl_nr_body').css('font-size', to + 'px');
        });
    });
    wp.customize('udssl_nr_options[nr_text_ratio]', function(value){
        value.bind(function(to) {
            var size = $('#udssl_nr_body').css('font-size');
            var newsize = size.slice(0, -2) * to;
            $('.udssl_nr_reading_item_text').css('font-size', newsize + 'px');
        });
    });

    /**
     * Read Now
     */
    wp.customize('udssl_nr_options[nr_read_now_text]', function(value){
        value.bind(function(to) {
            $('.udssl_nr_read_now' ).text(to);
        });
    });
    wp.customize('udssl_nr_options[nr_read_now_color]', function(value){
        value.bind(function(to) {
            $('.udssl_nr_read_now').css('color', to);
        });
    });

})(jQuery);
