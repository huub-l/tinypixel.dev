<?php
/*
 * Register Theme Customizer
 */
add_action('customize_register', 'cocobasic_theme_customize_register');

function cocobasic_theme_customize_register($wp_customize) {

    function cocobasic_clean_html($value) {
        $allowed_html_array = cocobasic_allowed_html();
        $value = wp_kses($value, $allowed_html_array);
        return $value;
    }

    class Kapena_WP_Customize_Textarea_Control extends WP_Customize_Control {

        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <textarea rows="10" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label>
            <?php
        }

    }

    //----------------------------- BLOG SECTION  ---------------------------------------------

    $wp_customize->add_section('cocobasic_blog_section', array(
        'title' => esc_html__('Blog Section', 'kapena-wp'),
        'priority' => 33
    ));


    $wp_customize->add_setting('cocobasic_blog_loading', array(
        'default' => 'button',        
        'sanitize_callback' => 'cocobasic_clean_html'
    ));
    $wp_customize->add_control('cocobasic_blog_loading', array(
        'label' => esc_html__('Blog More Loading', 'kapena-wp'),
        'section' => 'cocobasic_blog_section',
        'settings' => 'cocobasic_blog_loading',
        'type' => 'radio',
        'choices' => array(
            'button' => esc_html__('Button', 'kapena-wp'),
            'scroll' => esc_html__('Scroll', 'kapena-wp'),
    )));


    //----------------------------- END BLOG SECTION  ---------------------------------------------
    //
    //
    //
    //
    //
    //----------------------------- IMAGE SECTION  ---------------------------------------------

    $wp_customize->add_section('cocobasic_image_section', array(
        'title' => esc_html__('Images Section', 'kapena-wp'),
        'priority' => 33
    ));


    $wp_customize->add_setting('cocobasic_preloader', array(
        'default' => get_template_directory_uri() . '/images/preloader.gif',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cocobasic_preloader', array(
        'label' => esc_html__('Preloader Gif', 'kapena-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_preloader'
    )));

    $wp_customize->add_setting('cocobasic_header_logo', array(
        'default' => get_template_directory_uri() . '/images/logo.png',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cocobasic_header_logo', array(
        'label' => esc_html__('Header Logo', 'kapena-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_header_logo'
    )));

    $wp_customize->add_setting('cocobasic_title_image', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cocobasic_title_image', array(
        'label' => esc_html__('Title Image', 'kapena-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_title_image'
    )));

    $wp_customize->add_setting('cocobasic_footer_image', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cocobasic_footer_image', array(
        'label' => esc_html__('Footer Image', 'kapena-wp'),
        'section' => 'cocobasic_image_section',
        'settings' => 'cocobasic_footer_image'
    )));


    //----------------------------- END IMAGE SECTION  ---------------------------------------------
    //
    //
    //
    //----------------------------------COLORS SECTION--------------------

    $wp_customize->add_setting('cocobasic_global_color', array(
        'default' => '#0000ff',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cocobasic_global_color', array(
        'label' => esc_html__('Global Color', 'kapena-wp'),
        'section' => 'colors',
        'settings' => 'cocobasic_global_color'
    )));

    $wp_customize->add_setting('cocobasic_global_two_color', array(
        'default' => '#939393',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cocobasic_global_two_color', array(
        'label' => esc_html__('Global Color 2', 'kapena-wp'),
        'section' => 'colors',
        'settings' => 'cocobasic_global_two_color'
    )));



    //----------------------------------------------------------------------------------------------
    //
    //
    //
      //------------------------- FOOTER TEXT SECTION ---------------------------------------------

    $wp_customize->add_section('cocobasic_footer_text_section', array(
        'title' => esc_html__('Footer', 'kapena-wp'),
        'priority' => 99
    ));


    $wp_customize->add_setting('cocobasic_footer_copyright_content', array(
        'default' => '',
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control(new Kapena_WP_Customize_Textarea_Control($wp_customize, 'cocobasic_footer_copyright_content', array(
        'label' => esc_html__('Footer Copyright Content:', 'kapena-wp'),
        'section' => 'cocobasic_footer_text_section',
        'settings' => 'cocobasic_footer_copyright_content',
        'priority' => 999
    )));

    $wp_customize->add_setting('cocobasic_footer_social_content', array(
        'default' => '',
        'sanitize_callback' => 'cocobasic_clean_html'
    ));

    $wp_customize->add_control(new Kapena_WP_Customize_Textarea_Control($wp_customize, 'cocobasic_footer_social_content', array(
        'label' => esc_html__('Footer Social Content', 'kapena-wp'),
        'section' => 'cocobasic_footer_text_section',
        'settings' => 'cocobasic_footer_social_content',
        'priority' => 999
    )));


    //---------------------------- END FOOTER TEXT SECTION --------------------------
    //
    //
    //--------------------------------------------------------------------------
    $wp_customize->get_setting('cocobasic_global_color')->transport = 'postMessage';
    $wp_customize->get_setting('cocobasic_global_two_color')->transport = 'postMessage';
    //--------------------------------------------------------------------------
    /*
     * If preview mode is active, hook JavaScript to preview changes
     */
    if ($wp_customize->is_preview() && !is_admin()) {
        add_action('customize_preview_init', 'cocobasic_theme_customize_preview_js');
    }
}

/**
 * Bind Theme Customizer JavaScript
 */
function cocobasic_theme_customize_preview_js() {
    wp_enqueue_script('kapena-wp-theme-customizer', get_template_directory_uri() . '/admin/js/custom-admin.js', array('customize-preview'), '20120910', true);
}

/*
 * Generate CSS Styles
 */

class kapenaWPLiveCSS {

    public static function cocobasic_theme_customized_style() {
        echo '<style type="text/css">' .
        //Global Color
        cocobasic_generate_css('body .site-wrapper a:hover, .site-wrapper blockquote:not(.cocobasic-block-pullquote):before, .site-wrapper .navigation.pagination a:hover, .site-wrapper .tags-holder a, .site-wrapper .single .wp-link-pages, .site-wrapper .comment-form-holder a:hover, .site-wrapper .replay-at-author', 'color', 'cocobasic_global_color') .
        cocobasic_generate_css('.site-wrapper .navigation.pagination .current, .site-wrapper .tags-holder a:hover, .search .site-wrapper h1.entry-title, .archive .site-wrapper h1.entry-title', 'background-color', 'cocobasic_global_color') .
        cocobasic_generate_css('.site-wrapper .tags-holder a', 'border-color', 'cocobasic_global_color') .
        //Global Color 2
        cocobasic_generate_css('.site-wrapper blockquote:not(.cocobasic-block-pullquote), body .site-wrapper .sm-clean .current-menu-parent > a, body .sm-clean a:hover, body .main-menu.sm-clean .sub-menu li a:hover, body .sm-clean li.active a, body .sm-clean li.current-page-ancestor > a, body .sm-clean li.current_page_ancestor > a, body .sm-clean li.current_page_item > a, .single .site-wrapper .post-info-wrapper, .single .site-wrapper .post-info-wrapper a, .site-wrapper .error-text-home a, .site-wrapper .social-holder a:hover, .site-wrapper .copyright-holder a, .site-wrapper ul#footer-sidebar a:hover, .site-wrapper .info-code-content, .site-wrapper .info-code-content a, .site-wrapper .medium-text, .site-wrapper .text-slider .slider-text-holder, .site-wrapper .sm-clean a span.sub-arrow:before', 'color', 'cocobasic_global_two_color', '', ' !important') .
        '</style>';
    }

}

/*
 * Generate CSS Class - Helper Method
 */

function cocobasic_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $rgba = '') {
    $return = '';
    $mod = get_option($mod_name);
    if (!empty($mod)) {
        if ($rgba === true) {
            $mod = '0px 0px 50px 0px ' . cardea_hex2rgba($mod, 0.65);
        }
        $return = sprintf('%s { %s:%s; }', $selector, $style, $prefix . $mod . $postfix
        );
    }
    return $return;
}

function cocobasic_hex2rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided 
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}
?>