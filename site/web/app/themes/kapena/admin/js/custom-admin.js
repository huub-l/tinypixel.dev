(function ($) {

    "use strict";

    // COLORS                         
    wp.customize('cocobasic_global_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;

            inlineStyle = '<style class="custom-color-css1">';
            inlineStyle += 'body .site-wrapper a:hover, .site-wrapper blockquote:not(.cocobasic-block-pullquote):before, .site-wrapper .navigation.pagination a:hover, .site-wrapper .tags-holder a, .site-wrapper .single .wp-link-pages, .site-wrapper .comment-form-holder a:hover, .site-wrapper .replay-at-author { color: ' + to + '; }';
            inlineStyle += '.site-wrapper .navigation.pagination .current, .site-wrapper .tags-holder a:hover, .search .site-wrapper h1.entry-title, .archive .site-wrapper h1.entry-title { background-color: ' + to + '; }';
            inlineStyle += '.site-wrapper .tags-holder a { border-color: ' + to + '; }';
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css1');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });


    wp.customize('cocobasic_global_two_color', function (value) {
        value.bind(function (to) {
            var inlineStyle, customColorCssElemnt;

            inlineStyle = '<style class="custom-color-css2">';
            inlineStyle += '.site-wrapper blockquote:not(.cocobasic-block-pullquote), body .site-wrapper .sm-clean .current-menu-parent > a, body .sm-clean a:hover, body .main-menu.sm-clean .sub-menu li a:hover, body .sm-clean li.active a, body .sm-clean li.current-page-ancestor > a, body .sm-clean li.current_page_ancestor > a, body .sm-clean li.current_page_item > a, .single .site-wrapper .post-info-wrapper, .single .site-wrapper .post-info-wrapper a, .site-wrapper .error-text-home a, .site-wrapper .social-holder a:hover, .site-wrapper .copyright-holder a, .site-wrapper ul#footer-sidebar a:hover, .site-wrapper .info-code-content, .site-wrapper .info-code-content a, .site-wrapper .medium-text, .site-wrapper .text-slider .slider-text-holder, .site-wrapper .sm-clean a span.sub-arrow:before { color: ' + to + ' !important; }';
            inlineStyle += '</style>';

            customColorCssElemnt = $('.custom-color-css2');

            if (customColorCssElemnt.length) {
                customColorCssElemnt.replaceWith(inlineStyle);
            } else {
                $('head').append(inlineStyle);
            }

        });
    });


    function cocobasic_hexToRGB(hex, alpha) {
        var r = parseInt(hex.slice(1, 3), 16),
                g = parseInt(hex.slice(3, 5), 16),
                b = parseInt(hex.slice(5, 7), 16);

        if (alpha) {
            return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
        } else {
            return "rgb(" + r + ", " + g + ", " + b + ")";
        }
    }

})(jQuery);