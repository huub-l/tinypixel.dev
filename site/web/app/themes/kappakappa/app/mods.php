<?php

namespace App;

use \WP_Customize_Control as WP_Customize_Control;
use \WP_Customize_Image_Control as WP_Customize_Image_Control;
use \WP_Customize_Color_Control as WP_Customize_Color_Control;

/**
 * Allowed HTML
 */
function allowed_html()
{
    $allowed_tags = array(
        'a' => array(
            'class' => array(),
            'href' => array(),
            'rel' => array(),
            'title' => array(),
            'target' => array(),
            'data-rel' => array(),
        ),
        'abbr' => array(
            'title' => array(),
        ),
        'b' => array(),
        'blockquote' => array(
            'cite' => array(),
        ),
        'cite' => array(
            'title' => array(),
        ),
        'code' => array(),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'br' => array(),
        'dl' => array(),
        'dt' => array(),
        'em' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'i' => array(),
        'img' => array(
            'alt' => array(),
            'class' => array(),
            'height' => array(),
            'src' => array(),
            'width' => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(),
        'strong' => array(),
        'ul' => array(
            'class' => array(),
        ),
        'iframe' => array(
            'class' => array(),
            'src' => array(),
            'allowfullscreen' => array(),
            'width' => array(),
            'height' => array(),
        )
    );

    return $allowed_tags;
}

/*
 * Register Theme Customizer
 */
add_action('customize_register', function ($wp_customize) {

    function clean_html($value)
    {
        $allowed_html_array = allowed_html();
        $value = wp_kses($value, $allowed_html_array);
        return $value;
    }

    class Kapena_WP_Customize_Textarea_Control extends WP_Customize_Control
    {
        public $type = 'textarea';

        public function render_content()
        {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="10" style="width:100%;" <?php $this->link(); ?>>
                    <?php echo esc_textarea($this->value()); ?>
                </textarea>
            </label>
            <?php
        }
    }

    //----------------------------- BLOG SECTION  ---------------------------------------------

    $wp_customize->add_section(
        'blog_section',
        [
            'title' => esc_html__('Blog Section', 'kapena-wp'),
            'priority' => 33
        ]
    );


    $wp_customize->add_setting(
        'blog_loading',
        [
            'default' => 'button',
            'sanitize_callback' => 'clean_html'
        ]
    );
    $wp_customize->add_control(
        'blog_loading',
        [
            'label' => esc_html__('Blog More Loading', 'kapena-wp'),
            'section' => 'blog_section',
            'settings' => 'blog_loading',
            'type' => 'radio',
            'choices' => [
                'button' => esc_html__('Button', 'kapena-wp'),
                'scroll' => esc_html__('Scroll', 'kapena-wp'),
            ]
        ]
    );


    //----------------------------- END BLOG SECTION  ---------------------------------------------
    //
    //
    //
    //
    //
    //----------------------------- IMAGE SECTION  ---------------------------------------------

    $wp_customize->add_section(
        'image_section',
        [
            'title' => esc_html__('Images Section', 'kapena-wp'),
            'priority' => 33
        ]
    );


    $wp_customize->add_setting(
        'preloader',
        [
            'default' => get_template_directory_uri() . '/resources/assets/images/preloader.gif',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field'
        ]
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control($wp_customize, 'preloader', [
            'label' => esc_html__('Preloader Gif', 'kapena-wp'),
            'section' => 'image_section',
            'settings' => 'preloader'
        ])
    );

    $wp_customize->add_setting('header_logo', [
        'default' => get_template_directory_uri() . '/images/logo.png',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'header_logo',
            [
                'label' => esc_html__('Header Logo', 'kapena-wp'),
                'section' => 'image_section',
                'settings' => 'header_logo'
            ]
        )
    );

    $wp_customize->add_setting(
        'title_image',
        [
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field'
        ]
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'title_image',
            [
                'label' => esc_html__('Title Image', 'kapena-wp'),
                'section' => 'image_section',
                'settings' => 'title_image'
            ]
        )
    );

    $wp_customize->add_setting(
        'footer_image',
        [
            'default' => '',
            'capability' => 'edit_theme_options',
            'type' => 'option',
            'sanitize_callback' => 'sanitize_text_field'
        ]
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'footer_image',
            [
                'label' => esc_html__('Footer Image', 'kapena-wp'),
                'section' => 'image_section',
                'settings' => 'footer_image'
            ]
        )
    );


    //----------------------------- END IMAGE SECTION  ---------------------------------------------
    //
    //
    //
    //----------------------------------COLORS SECTION--------------------

    $wp_customize->add_setting(
        'global_color',
        [
            'default' => '#0000ff',
            'type' => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color'
        ]
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'global_color',
            [
                'label' => esc_html__('Global Color', 'kapena-wp'),
                'section' => 'colors',
                'settings' => 'global_color'
            ]
        )
    );

    $wp_customize->add_setting(
        'global_two_color',
        [
            'default' => '#939393',
            'type' => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color'
        ]
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'global_two_color',
            [
                'label' => esc_html__('Global Color 2', 'kapena-wp'),
                'section' => 'colors',
                'settings' => 'global_two_color'
            ]
        )
    );

    //----------------------------------------------------------------------------------------------
    //
    //
    //
      //------------------------- FOOTER TEXT SECTION ---------------------------------------------

    $wp_customize->add_section(
        'footer_text_section',
        [
            'title' => esc_html__('Footer', 'kapena-wp'),
            'priority' => 99
        ]
    );


    $wp_customize->add_setting(
        'footer_copyright',
        [
            'default' => '&copy; 2019 Tiny Pixel Collective, LLC',
        ]
    );

    $wp_customize->add_control(
        new Kapena_WP_Customize_Textarea_Control(
            $wp_customize,
            'footer_copyright',
            [
                'label' => esc_html__('Footer Copyright Content:', 'kapena-wp'),
                'section' => 'footer_text_section',
                'settings' => 'footer_copyright',
                'priority' => 999
            ]
        )
    );

    $wp_customize->add_setting(
        'footer_social',
        [
            'default' => 'FB',
        ]
    );

    $wp_customize->add_control(
        new Kapena_WP_Customize_Textarea_Control(
            $wp_customize,
            'footer_social',
            [
                'label' => esc_html__('Footer Social Content', 'kapena-wp'),
                'section' => 'footer_text_section',
                'settings' => 'footer_social',
                'priority' => 999
            ]
        )
    );


    //---------------------------- END FOOTER TEXT SECTION --------------------------
    //
    //
    //--------------------------------------------------------------------------
    $wp_customize->get_setting('global_color')->transport = 'postMessage';
    $wp_customize->get_setting('global_two_color')->transport = 'postMessage';
    //--------------------------------------------------------------------------
    /*
     * If preview mode is active, hook JavaScript to preview changes
     */
    if ($wp_customize->is_preview() && !is_admin()) {
        add_action('customize_preview_init', function () {
            wp_enqueue_script(
                'kapena-wp-theme-customizer',
                get_template_directory_uri() .'/admin/js/custom-admin.js',
                ['customize-preview'],
                '20120910',
                true
            );
        });
    }
});

/*
 * Generate CSS Styles
 */

class kapenaWPLiveCSS
{
    public static function theme_customized_style()
    {
        echo '<style type="text/css">' .
        //Global Color
        generate_css('body .site-wrapper a:hover, .site-wrapper blockquote:not(.cocobasic-block-pullquote):before, .site-wrapper .navigation.pagination a:hover, .site-wrapper .tags-holder a, .site-wrapper .single .wp-link-pages, .site-wrapper .comment-form-holder a:hover, .site-wrapper .replay-at-author', 'color', 'global_color') .
        generate_css('.site-wrapper .navigation.pagination .current, .site-wrapper .tags-holder a:hover, .search .site-wrapper h1.entry-title, .archive .site-wrapper h1.entry-title', 'background-color', 'global_color') .
        generate_css('.site-wrapper .tags-holder a', 'border-color', 'global_color') .
        //Global Color 2
        generate_css('.site-wrapper blockquote:not(.cocobasic-block-pullquote), body .site-wrapper .sm-clean .current-menu-parent > a, body .sm-clean a:hover, body .main-menu.sm-clean .sub-menu li a:hover, body .sm-clean li.active a, body .sm-clean li.current-page-ancestor > a, body .sm-clean li.current_page_ancestor > a, body .sm-clean li.current_page_item > a, .single .site-wrapper .post-info-wrapper, .single .site-wrapper .post-info-wrapper a, .site-wrapper .error-text-home a, .site-wrapper .social-holder a:hover, .site-wrapper .copyright-holder a, .site-wrapper ul#footer-sidebar a:hover, .site-wrapper .info-code-content, .site-wrapper .info-code-content a, .site-wrapper .medium-text, .site-wrapper .text-slider .slider-text-holder, .site-wrapper .sm-clean a span.sub-arrow:before', 'color', 'global_two_color', '', ' !important') .
        '</style>';
    }
}

/*
 * Generate CSS Class - Helper Method
 */

function generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $rgba = '')
{
    $return = '';
    $mod = get_option($mod_name);
    if (!empty($mod)) {
        if ($rgba === true) {
            $mod = '0px 0px 50px 0px ' . cardea_hex2rgba($mod, 0.65);
        }
        $return = sprintf(
            '%s { %s:%s; }',
            $selector,
            $style,
            $prefix . $mod . $postfix
        );
    }
    return $return;
}

function hex2rgba($color, $opacity = false)
{

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color)) {
        return $default;
    }

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
    } elseif (strlen($color) == 3) {
        $hex = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1) {
            $opacity = 1.0;
        }
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}
