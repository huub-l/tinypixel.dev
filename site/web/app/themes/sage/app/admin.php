<?php

namespace App;

use function Roots\asset;
use \WP_Customize_Control as WP_Customize_Control;
use \WP_Customize_Image_Control as WP_Customize_Image_Control;
use \WP_Customize_Color_Control as WP_Customize_Color_Control;

/**
 * Allowed HTML
 */
function allowed_html()
{
    return [
        'a' => [
            'class' => [],
            'href' => [],
            'rel' => [],
            'title' => [],
            'target' => [],
            'data-rel' => [],
        ],
        'abbr' => [
            'title' => [],
        ],
        'b' => [],
        'blockquote' => [
            'cite' => [],
        ],
        'cite' => [
            'title' => [],
        ],
        'code' => [],
        'del' => [
            'datetime' => [],
            'title' => [],
        ],
        'dd' => [],
        'div' => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'br' => [],
        'dl' => [],
        'dt' => [],
        'em' => [],
        'h1' => [],
        'h2' => [],
        'h3' => [],
        'h4' => [],
        'h5' => [],
        'h6' => [],
        'i' => [],
        'img' => [
            'alt' => [],
            'class' => [],
            'height' => [],
            'src' => [],
            'width' => [],
        ],
        'li' => [
            'class' => [],
        ],
        'ol' => [
            'class' => [],
        ],
        'p' => [
            'class' => [],
        ],
        'q' => [
            'cite' => [],
            'title' => [],
        ],
        'span' => [
            'class' => [],
            'title' => [],
            'style' => [],
        ],
        'strike' => [],
        'strong' => [],
        'ul' => [
            'class' => [],
        ],
        'iframe' => [
            'class'           => [],
            'src'             => [],
            'allowfullscreen' => [],
            'width'           => [],
            'height'          => [],
        ]
    ];
}

function clean_html($value)
{
    $allowed_html_array = allowed_html();
    $value = wp_kses($value, $allowed_html_array);
    return $value;
}

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer', asset('scripts/customizer.js')->uri(), ['customize-preview'], null, true);
});

/**
 * Customizer Registration
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
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

    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);

    $wp_customize->add_section('blog_section', [
        'title' => __('Blog Section', 'kapena-wp'),
        'priority' => 33,
    ]);

    $wp_customize->add_setting('blog_loading', [
        'default' => 'button',
        'sanitize_callback' => 'clean_html',
    ]);

    $wp_customize->add_control('blog_loading', [
        'label' => __('Blog More Loading', 'kapena-wp'),
        'section' => 'blog_section',
        'settings' => 'blog_loading',
        'type' => 'radio',
        'choices' => [
            'button' => __('Button', 'kapena-wp'),
            'scroll' => __('Scroll', 'kapena-wp'),
        ],
    ]);

    $wp_customize->add_section(
        'image_section',
        [
        'title' => __('Images Section', 'kapena-wp'),
        'priority' => 33
        ]
    );

    $wp_customize->add_setting(
        'preloader',
        [
        'default' => get_template_directory_uri() . ' /resources/assets/images/preloader.gif',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
        ]
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control($wp_customize, 'preloader', [
            'label' => __('Preloader Gif', 'kapena-wp'),
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
        new WP_Customize_Image_Control($wp_customize, 'header_logo', [
            'label' => __('Header Logo', 'kapena-wp'),
            'section' => 'image_section',
            'settings' => 'header_logo'
        ])
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
        new WP_Customize_Image_Control($wp_customize, 'title_image', [
            'label' => __('Title Image', 'kapena-wp'),
            'section' => 'image_section',
            'settings' => 'title_image'
        ])
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
        new WP_Customize_Image_Control($wp_customize, 'footer_image', [
            'label' => __('Footer Image', 'kapena-wp'),
            'section' => 'image_section',
            'settings' => 'footer_image'
        ])
    );

    $wp_customize->add_setting('global_color', [
        'default' => '#0000ff',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control($wp_customize, 'global_color', [
            'label' => __('Global Color', 'kapena-wp'),
            'section' => 'colors',
            'settings' => 'global_color'
        ])
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
            'label' => __('Global Color 2', 'kapena-wp'),
            'section' => 'colors',
            'settings' => 'global_two_color'
            ]
        )
    );

    $wp_customize->add_section(
        'footer_text_section',
        [
        'title' => __('Footer', 'kapena-wp'),
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
            'label' => __('Footer Copyright Content:', 'kapena-wp'),
            'section' => 'footer_text_section',
            'settings' => 'footer_copyright',
            'priority' => 999
            ]
        )
    );

    $wp_customize->add_setting('footer_social', [
        'default' => 'FB',
    ]);

    $wp_customize->add_control(
        new Kapena_WP_Customize_Textarea_Control(
            $wp_customize,
            'footer_social',
            [
            'label' => __('Footer Social Content', 'kapena-wp'),
            'section' => 'footer_text_section',
            'settings' => 'footer_social',
            'priority' => 999
            ]
        )
    );

    $wp_customize->get_setting('global_color')->transport = 'postMessage';

    $wp_customize->get_setting('global_two_color')->transport = 'postMessage';

    if ($wp_customize->is_preview() && !is_admin()) :
        add_action('customize_preview_init', function () {
            wp_enqueue_script(
                'kapena-wp-theme-customizer',
                get_template_directory_uri() .'/admin/js/custom-admin.js',
                ['customize-preview'],
                '20120910',
                true
            );
        });
    endif;
});

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

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset('scripts/customizer.js'), ['customize-preview'], null, true);
});
