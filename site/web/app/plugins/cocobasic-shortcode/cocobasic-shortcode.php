<?php

/*
  Plugin Name: CocoBasic - Kapena WP
  Description: User interface used in Kapena WP theme.
  Version: 1.1
  Author: CocoBasic
  Author URI: http://www.cocobasic.com
 */


if (!defined('ABSPATH')) {
    die("Can't load this file directly");
}

/**
 * Shortcodes
 *
 * #TODO Continue to refactor
 */
class cocobasic_shortcodes
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', [$this, 'myplugin_load_textdomain']);
        add_action('admin_init', [$this, 'cocobasic_plugin_admin_enqueue_script']);
        add_action('wp_enqueue_scripts', [$this, 'cocobasic_plugin_enqueue_script']);
        if (version_compare(get_bloginfo('version'), '5.0', '<')) {
            add_action('admin_init', [$this, 'cocobasic_action_admin_init']);
        }
    }

    /**
     * cocobasic_action_admin_init
     *
     * @return void
     */
    public function cocobasic_action_admin_init()
    {
        // only hook up these filters if the current user has permission
        // to edit posts and pages
        if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
            add_filter('mce_buttons', [$this, 'cocobasic_filter_mce_button']);
            add_filter('mce_external_plugins', [$this, 'cocobasic_filter_mce_plugin']);
        }
    }

    /**
     * cocobasic_filter_mce_button
     *
     * @param mixed $buttons
     * @return void
     */
    public function cocobasic_filter_mce_button($buttons)
    {
        // add a separation before the new button
        array_push($buttons, '|', 'cocobasic_shortcodes_button');
        return $buttons;
    }

    /**
     * cocobasic_filter_mce_plugin
     *
     * @param mixed $plugins
     * @return void
     */
    public function cocobasic_filter_mce_plugin($plugins)
    {
        // this plugin file will work the magic of our button
        $plugins['shortcodes_options'] = plugin_dir_url(__FILE__) .'editor_plugin.js';
        return $plugins;
    }

    public function myplugin_load_textdomain()
    {
        load_plugin_textdomain('cocobasic-shortcode', false, dirname(plugin_basename(__FILE__)) .'/languages/');
    }

    public function cocobasic_plugin_admin_enqueue_script()
    {
        wp_enqueue_style('admin-style', plugins_url('css/admin-style.css', __FILE__));
        wp_enqueue_script('cocobasic-admin-main-js', plugins_url('js/admin-main.js', __FILE__), ['jquery'], '', true);
    }

    public function cocobasic_plugin_enqueue_script()
    {
        wp_enqueue_style('prettyPhoto', plugins_url('css/prettyPhoto.css', __FILE__));
        wp_enqueue_style('swiper-css', plugins_url('css/swiper.min.css', __FILE__));
        wp_enqueue_style('cocobasic-main-plugin-style', plugins_url('css/style.css', __FILE__));

        wp_enqueue_script('isotope', plugins_url('js/isotope.pkgd.js', __FILE__), ['jquery'], '', true);
        wp_enqueue_script('jquery-prettyPhoto', plugins_url('js/jquery.prettyPhoto.js', __FILE__), ['jquery'], '', true);
        wp_enqueue_script('swiper-js', plugins_url('js/swiper.min.js', __FILE__), ['jquery'], '', true);
        wp_enqueue_script('jquery-easing', plugins_url('js/jquery.easing.1.3.js', __FILE__), ['jquery'], '', true);
        wp_enqueue_script('cocobasic-main-js', plugins_url('js/main.js', __FILE__), ['jquery'], '', true);

        //Infinite Loading JS variables for portfolio
        $portfolio_count_posts = wp_count_posts('portfolio');
        $portfolio_count_posts = $portfolio_count_posts->publish;

        wp_localize_script(
            'cocobasic-main-js',
            'ajax_var_portfolio',
            [
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-cocobasic-portfolio-load-more'),
                'total' => $portfolio_count_posts
            ]
        );
    }
}

$cocobasic_shortcodes = new cocobasic_shortcodes();

add_theme_support('post-thumbnails', array('portfolio'));
add_action('init', 'cocobasic_allowed_plugin_html');
add_action('add_meta_boxes', 'cocobasic_add_page_custom_meta_box');
add_action('add_meta_boxes', 'cocobasic_add_portfolio_custom_meta_box');
add_action('add_meta_boxes', 'cocobasic_add_post_custom_meta_box');
add_action('save_post', 'cocobasic_save_page_custom_meta');
add_action('save_post', 'cocobasic_save_portfolio_custom_meta');
add_action('save_post', 'cocobasic_save_post_custom_meta');
add_filter("the_content", "cocobasic_the_content_filter");
add_action('wp_ajax_portfolio_ajax_load_more', 'cocobasic_portfolio_load_more_item');
add_action('wp_ajax_nopriv_portfolio_ajax_load_more', 'cocobasic_portfolio_load_more_item');
/* add_filter('body_class', 'cocobasic_browserBodyClass');
 */

function cocobasic_portfolio_load_more_item()
{
    check_ajax_referer('ajax-cocobasic-portfolio-load-more', 'security');
    if (isset($_POST["action"]) && ($_POST["action"] === 'portfolio_ajax_load_more')) {
        $args = array(
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'posts_per_page' => sanitize_text_field($_POST['portfolio_posts_per_page']),
            'paged' => sanitize_text_field($_POST['portfolio_page_number'])
        );

        $portfolio_load_more_query = new WP_Query($args);
        if (file_exists(get_stylesheet_directory() .'/load-more-portfolio.php')) {
            include get_stylesheet_directory() .'/load-more-portfolio.php';
        } else {
            include 'templates/load-more-portfolio.php';
        }
        exit;
    }
}

function cocobasic_col($atts, $content = null)
{
    extract(shortcode_atts(["size" => 'one', "class" => ''], $atts));

    switch ($size) :

    case "one":
        $return = '<div class = "one '. $class .'">'. do_shortcode($content) .'</div><div class = "clear"></div>';
        break;
    case "one_half_last":
        $return = '<div class = "one_half last '. $class .'">'. do_shortcode($content) .'</div><div class = "clear"></div>';
        break;
    case "one_third_last":
        $return = '<div class = "one_third last '. $class .'">'. do_shortcode($content) .'</div><div class = "clear"></div>';
        break;
    case "two_third_last":
        $return = '<div class = "two_third last '. $class .'">'. do_shortcode($content) .'</div><div class = "clear"></div>';
        break;
    case "one_fourth_last":
        $return = '<div class = "one_fourth last '. $class .'">'. do_shortcode($content) .'</div><div class = "clear"></div>';
        break;
    case "three_fourth_last":
        $return = '<div class = "three_fourth last '. $class .'">'. do_shortcode($content) .'</div><div class = "clear"></div>';
        break;
    default:
        $return = '<div class = "'. $size .' '. $class .'">'. do_shortcode($content) .'</div>';

    endswitch;

    return $return;
}

add_shortcode("col", "cocobasic_col");

// </editor-fold>
//<editor-fold defaultstate="collapsed" desc="BR shortcode">
function cocobasic_br($atts, $content = null) {
    return '<br />';
}

add_shortcode("br", "cocobasic_br");

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="BR shortcode">
function cocobasic_med_text($atts, $content = null) {
    return '<div class="medium-text">'. do_shortcode($content) .'</div>';
}

add_shortcode("med_text", "cocobasic_med_text");

//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Full Page Width">
function cocobasic_full_width($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    return '</div><div class="full-page-width center-relative'. $class .'">'. do_shortcode($content) .'</div><div class="content-1170 center-relative">';
}

add_shortcode("full_width", "cocobasic_full_width");

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Button shortcode">
function cocobasic_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "target" => '_self',
        "href" => '#',
        "position" => 'left'
                    ), $atts));

    switch ($position) {
        case 'center':
            $position = "center-text";
            break;
        case 'right':
            $position = "text-right";
            break;
        default:
            $position = "text-left";
    }

    $return = '<div class="'. $position .'"><a href="'. $href .'" target="'. $target .'" class="button '. $class .'">'. do_shortcode($content) .'</a></div>';

    return $return;
}

add_shortcode("button", "cocobasic_button");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Image Slider holder short code">
function cocobasic_image_slider($atts, $content = null) {
    extract(shortcode_atts(array(
        "name" => 'slider',
        "auto" => 'false',
        "pagination" => '',
        "gap" => '0',
        "items" => '1',
        "speed" => '2000'
                    ), $atts));


    $return = '<script> var '. $name .'_speed = "'. $speed .'";
                var '. $name .'_auto = "'. $auto .'";
                var '. $name .'_items = "'. $items .'";
                var '. $name .'_gap = "'. $gap .'";
    </script>
    <div id = "'. $name .'" class="image-slider-wrapper relative swiper-container">
    <div class = "swiper-wrapper image-slider slider">
            '. do_shortcode($content) .'
        </div>';


    $return .= '<div class = "clear"></div></div>';

    $return .= '<div class="swiper-pagination swiper-pagination-'. $name .' '. $pagination .'"></div>';
    $return .= '<div class="swiper-scrollbar swiper-scrollbar-'. $name .' '. $pagination .'"></div>';


    return $return;
}

add_shortcode("image_slider", "cocobasic_image_slider");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Image Slide short code">
function cocobasic_image_slide($atts, $content = null) {
    extract(shortcode_atts(array(
        "img" => '',
        "href" => '',
        "alt" => '',
        "target" => '_self'
                    ), $atts));
    if ($href != '') {
        return '<div class="swiper-slide"><a href="'. $href .'" target="'. $target .'"><img src = "'. $img .'" alt = "'. $alt .'" /></a></div>';
    } else {
        return '<div class="swiper-slide"><img src = "'. $img .'" alt = "'. $alt .'" /></div>';
    }
}

add_shortcode("image_slide", "cocobasic_image_slide");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Test Slider holder short code">
function cocobasic_text_slider($atts, $content = null) {
    extract(shortcode_atts(array(
        "name" => 'textSlider',
        "auto" => 'false',
        "pagination" => '',
        "speed" => '2000'
                    ), $atts));


    $return = '<script> var '. $name .'_speed = "'. $speed .'";
                var '. $name .'_auto = "'. $auto .'";
    </script>
    <div id = "'. $name .'" class="text-slider-wrapper relative swiper-container">
    <div class = "swiper-wrapper text-slider slider">
            '. do_shortcode($content) .'
        </div>';


    $return .= '<div class = "clear"></div></div>';

    $return .= '<div class="swiper-pagination swiper-pagination-'. $name .' '. $pagination .'"></div>';
    $return .= '<div class="swiper-scrollbar swiper-scrollbar-'. $name .' '. $pagination .'"></div>';


    return $return;
}

add_shortcode("text_slider", "cocobasic_text_slider");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Text Slide short code">
function cocobasic_text_slide($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    return '<div class="swiper-slide '. $class .'"><div class="slider-text-holder">'. do_shortcode($content) .'</div></div>';
}

add_shortcode("text_slide", "cocobasic_text_slide");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Portfolio shortcode">
function cocobasic_portfolio($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "show" => '5',
        "load_more" => ''
                    ), $atts));

    $return = '<div id="portfolio-wrapper">';

    global $post;
    $args = array('post_type' => 'portfolio', 'post_status' => 'publish', 'posts_per_page' => $show);
    $loop = new WP_Query($args);
    if ($loop->have_posts()) :
        $return .= '<ul class="grid" id="portfolio-grid"><li class="gutter-sizer"></li><li class="grid-sizer"></li>';
        while ($loop->have_posts()) : $loop->the_post();
            if (has_post_thumbnail($post->ID)) {
                $portfolio_post_thumb = get_the_post_thumbnail();
            } else {
                $portfolio_post_thumb = '<img src = "'. plugin_dir_url(__FILE__) .'/images/no-photo.png" alt = "" />';
            }

            $p_size = get_post_meta($post->ID, "portfolio_thumb_image_size", true);

            if (get_post_meta($post->ID, "portfolio_hover_thumb_title", true) != ''):
                $p_thumb_title = get_post_meta($post->ID, "portfolio_hover_thumb_title", true);
            else:
                $p_thumb_title = get_the_title();
            endif;

            $p_thumb_text = get_post_meta($post->ID, "portfolio_hover_thumb_text", true);
            $link_thumb_to = get_post_meta($post->ID, "portfolio_link_item_to", true);

            switch ($link_thumb_to):
                case 'link_to_image_url':
                    $image_popup = get_post_meta($post->ID, "portfolio_image_popup", true);
                    $return .= '<li class="grid-item element-item '. $p_size .'"><a class="item-link" href="'. $image_popup .'" data-rel="prettyPhoto[gallery1]">';
                    break;
                case 'link_to_video_url':
                    $video_popup = get_post_meta($post->ID, "portfolio_video_popup", true);
                    $return .= '<li class="grid-item element-item '. $p_size .'"><a class="item-link" href="'. $video_popup .'" data-rel="prettyPhoto[gallery1]">';
                    break;
                case 'link_to_extern_url':
                    $extern_site_url = get_post_meta($post->ID, "portfolio_extern_site_url", true);
                    $return .= '<li class="grid-item element-item '. $p_size .'"><a class="item-link" href="'. $extern_site_url .'" target="_blank">';
                    break;

                default:
                    $return .= '<li class="grid-item element-item '. $p_size .'"><a class="item-link" href="'. get_permalink() .'">';
            endswitch;

            $return .= $portfolio_post_thumb .'<div class="portfolio-text-holder"><p class="portfolio-title">'. $p_thumb_title .'</p><p class="portfolio-desc">'. $p_thumb_text .'</p></div></a></li>';

        endwhile;

        $return .= '</ul>';
    endif;
    $return .= '<div class="clear"></div></div><div class = "block center-relative center-text more-posts-portfolio-holder '. $load_more .'"><a target = "_self" class = "more-posts-portfolio">'. esc_html__('LOAD MORE', 'cocobasic-shortcode') .'</a><a class = "more-posts-portfolio-loading">'. esc_html__('LOADING', 'cocobasic-shortcode') .'</a><a class = "no-more-posts-portfolio">'. esc_html__('NO MORE', 'cocobasic-shortcode') .'</a></div>';
    wp_reset_postdata();
    return $return;
}

add_shortcode("portfolio", "cocobasic_portfolio");

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Skills short code">
function cocobasic_skills($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "title" => '',
        "percent" => '50%'
                    ), $atts));

    $return = '<div class="progress_bar '. $class .'">
               <div class="progress_bar_title">'. $title .'</div>
               <div class="progress_bar_field_holder">
               <div class="progress_bar_field_perecent" style="width:'. $percent .';"></div>
               </div>
               </div>';
    return $return;
}

add_shortcode("skills", "cocobasic_skills");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Service shortcode">
function cocobasic_service($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "title" => '',
        "img" => '',
        "alt" => ''
                    ), $atts));

    $return = '<div class="service-item center-text relative '. $class .'"><img class="service-icon" src="'. $img .'" alt="'. $alt .'"/><h3 class="service-title">'. $title .'</h3><div class="service-content">'. do_shortcode($content) .'</div></div>';

    return $return;
}

add_shortcode("service", "cocobasic_service");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Team Holder">
function cocobasic_team($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));

    $return = '<div class="team-holder '. $class .'">'. do_shortcode($content) .'<div class="clear"></div></div>';
    return $return;
}

add_shortcode("team", "cocobasic_team");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Member shortcode">
function cocobasic_member($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => '',
        "size" => 'one_third',
        "name" => '',
        "img" => '',
        "alt" => '',
        "href" => '#',
        "target" => '_self'
                    ), $atts));
    if (($href != '') && ($href != '#')) {
        $return = '<div class="member '. $size .' '. $class .'"><img src="'. $img .'" alt="'. $alt .'"/><div class="member-info"><div class="member-name"><a href="'. $href .'" target="'. $target .'">'. $name .'</a></div><div class="member-social-holder">'. do_shortcode($content) .'</div></div></div>';
    } else {
        $return = '<div class="member '. $size .' '. $class .'"><img src="'. $img .'" alt="'. $alt .'"/><div class="member-info"><div class="member-name">'. $name .'</div><div class="member-social-holder">'. do_shortcode($content) .'</div></div></div>';
    }

    return $return;
}

add_shortcode("member", "cocobasic_member");

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Social shortcode">
function cocobasic_social($atts, $content = null)
{
    extract(shortcode_atts(["class" => '', "icon" => '', "href" => '', "target" => '_blank'], $atts));

    $return = '
        <div class="social '. $class .'">
            <a href="'. $href .'" target="'. $target .'">
                <i class="fab fa-'. $icon .'"></i>
            </a>
        </div>';

    return $return;
}

add_shortcode("social", "cocobasic_social");

function cocobasic_info($atts, $content = null)
{
    extract(shortcode_atts(["class" => '', "title" => ''], $atts));

    $return = '<div class="info-code '. $class .'">
               <p class="info-code-title">'. $title .'</p>
               <p class="info-code-content">'. do_shortcode($content) .'</p>
               </div>';
    return $return;
}

add_shortcode("info", "cocobasic_info");

function create_portfolio()
{
    $portfolio_args = array(
        'label' => esc_html__('Portfolio', 'cocobasic-shortcode'),
        'singular_label' => esc_html__('Portfolio', 'cocobasic-shortcode'),
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor', 'custom-fields', 'thumbnail', 'comments'),
        'show_in_rest' => true
    );
    register_post_type('portfolio', $portfolio_args);
}

add_action('init', 'create_portfolio');

function cocobasic_add_portfolio_custom_meta_box()
{
    add_meta_box(
        'cocobasic_portfolio_custom_meta_box', // $id
        __('Portfolio Preference', 'cocobasic-shortcode'), // $title
        'cocobasic_show_portfolio_custom_meta_box', // $callback
        'portfolio', // $page
        'normal', // $context
        'high'  // $priority
    );
}

// Field Array Post Page
$prefix = 'portfolio_';
$portfolio_custom_meta_fields = [
    [
        'label' => __('Custom thumb title on mouse over', 'cocobasic-shortcode'),
        'desc' => __('by default is used item title', 'cocobasic-shortcode'),
        'id' => $prefix .'hover_thumb_title',
        'type' => 'text'
    ],
    [
        'label' => __('Thumb text on mouse over (second line)', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix .'hover_thumb_text',
        'type' => 'text'
    ],
    [
        'label' => __('Thumb image size', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix .'thumb_image_size',
        'type' => 'select',
        'options' => [
            'one' => [
                'label' => '33%',
                'value' => 'p_one_third'
            ],
            'two' => [
                'label' => '66%',
                'value' => 'p_two_third'
            ],
            'three' => [
                'label' => '100%',
                'value' => 'p_one'
            ],
        ],
    ],
    [
        'label' => __('Link thumb to', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix .'link_item_to',
        'type' => 'select',
        'options' => [
            'one' => [
                'label' => __('This post', 'cocobasic-shortcode'),
                'value' => 'link_to_this_post'
            ],
            'two' => [
                'label' => __('Image', 'cocobasic-shortcode'),
                'value' => 'link_to_image_url'
            ],
            'three' => [
                'label' => __('Video', 'cocobasic-shortcode'),
                'value' => 'link_to_video_url'
            ],
            'four' => [
                'label' => __('External URL', 'cocobasic-shortcode'),
                'value' => 'link_to_extern_url'
            ],
        ],
    ],
    [
        'label' => __('Link thumb to Image:', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix .'image_popup',
        'type' => 'text'
    ],
    [
        'label' => __('Link thumb to Video', 'cocobasic-shortcode'),
        'desc' => __('For example: http://vimeo.com/XXXXXX or http://www.youtube.com/watch?v=XXXXXX', 'cocobasic-shortcode'),
        'id' => $prefix .'video_popup',
        'type' => 'text'
    ],
    [
        'label' => __('Link thumb to External URL:', 'cocobasic-shortcode'),
        'desc' => __('Set URL to external site', 'cocobasic-shortcode'),
        'id' => $prefix .'extern_site_url',
        'type' => 'text'
    ],
];

function cocobasic_show_portfolio_custom_meta_box()
{
    global $portfolio_custom_meta_fields, $post;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();

    // Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'. esc_attr(wp_create_nonce(basename(__FILE__))) .'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';

    foreach ($portfolio_custom_meta_fields as $field)
    {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);

        // begin a table row with
        echo '<tr><th><label for="'. esc_attr($field['id']) .'">'. esc_attr($field['label']) .'</label></th><td>';
        switch ($field['type']) {
            case 'text' :
                if ($field['id'] == 'portfolio_image_popup') {
                    echo '<label for="upload_image">
                            <input id="'. esc_attr($field['id']) .'" class="image-url-input" type="text" size="36" name="'. esc_attr($field['id']) .'" value="'. esc_attr($meta) .'" />
                            <input id="upload_image_button" class="button" type="button" value="'. __('Upload Image', 'cocobasic-shortcode') .'" /><br /><span class="image-upload-desc">
                            '. esc_html($field['desc']) .'</span><span id="small-background-image-preview" class="has-background"></span></label>';
                } else {
                    echo '<input type="text" name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'" value="'. esc_attr($meta) .'" size="50" />
						<br /><span class="description">'. esc_html($field['desc']) .'</span>';
                }
                break;
            case 'select' :
                echo '<select name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'. esc_attr($option['value']) .'">'. esc_html($option['label']) .'</option>';
                }
                echo '</select><br /><span class="description">'. esc_html($field['desc']) .'</span>';
                break;
            case 'textarea' :
                echo '<textarea name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'" cols="60" rows="4">'. wp_kses($meta, $allowed_plugin_tags) .'</textarea>
					<br /><span class="description">'. esc_html($field['desc']) .'</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function cocobasic_save_portfolio_custom_meta($post_id)
{
    global $portfolio_custom_meta_fields;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
    // verify nonce
    if (isset($_POST['custom_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($portfolio_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = null;
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            $new = wp_kses($new, $allowed_plugin_tags);
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}

function cocobasic_add_page_custom_meta_box()
{
    add_meta_box(
        'cocobasic_page_custom_meta_box', // $id
        __('Page Preference', 'cocobasic-shortcode'), // $title
        'cocobasic_show_page_custom_meta_box', // $callback
        'page', // $page
        'normal', // $context
        'high' // $priority
    );
}

// Field Array Post Page
$prefix = 'page_';

$page_custom_meta_fields = array(
    array(
        'label' => __('Show Page Title', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix .'show_title',
        'type' => 'select',
        'options' => array(
            'one' => array(
                'label' => 'Yes',
                'value' => 'yes'
            ),
            'two' => array(
                'label' => 'No',
                'value' => 'no'
            )
        )
    ),
    array(
        'label' => __('Page Custom Title', 'cocobasic-shortcode'),
        'desc' => '',
        'id' => $prefix .'custom_title',
        'type' => 'textarea'
    )
);

// The Callback
function cocobasic_show_page_custom_meta_box() {
    global $page_custom_meta_fields, $post;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'. esc_attr(wp_create_nonce(basename(__FILE__))) .'" />';
    echo '<table class="form-table">';
    foreach ($page_custom_meta_fields as $field) {
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr class="'. $field['id'] .'">
                <th><label for="'. esc_attr($field['id']) .'">'. esc_attr($field['label']) .'</label></th>
                <td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'" value="'. esc_attr($meta) .'" size="50" />
						<br /><span class="description">'. esc_html($field['desc']) .'</span>';
                break;
            case 'select':
                echo '<select name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'. esc_attr($option['value']) .'">'. esc_html($option['label']) .'</option>';
                }
                echo '</select><br /><span class="description">'. esc_html($field['desc']) .'</span>';
                break;
            case 'textarea':
                echo '<textarea name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'" cols="60" rows="4">'. wp_kses($meta, $allowed_plugin_tags) .'</textarea>
					<br /><span class="description">'. esc_html($field['desc']) .'</span>';
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

function cocobasic_save_page_custom_meta($post_id)
{
    global $page_custom_meta_fields, $post;

    $allowed_plugin_tags = cocobasic_allowed_plugin_html();

    // verify nonce
    if (isset($_POST['custom_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }
// check autosave
// Stop WP from clearing custom fields on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
// Prevent quick edit from clearing custom fields
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
// check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
// loop through fields and save the data
    foreach ($page_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = null;
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            $new = wp_kses($new, $allowed_plugin_tags);
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}

function cocobasic_add_post_custom_meta_box()
{
    add_meta_box(
        'cocobasic_post_custom_meta_box', // $id
        __('Post Preference', 'cocobasic-shortcode'), // $title
        'cocobasic_show_post_custom_meta_box', // $callback
        'post', // $page
        'normal', // $context
        'high' // $priority
    );
}

$prefix = 'post_';
$post_custom_meta_fields = array(
    array(
        'label' => __('Blog Feature Image', 'cocobasic-shortcode'),
        'desc' => __('use different feature image on Blog page (default is Featured Image)', 'cocobasic-shortcode'),
        'id' => $prefix .'blog_featured_image',
        'type' => 'text'
    ),
    array(
        'label' => __('Post Header Content', 'cocobasic-shortcode'),
        'desc' => __('set slider, vimeo or youtube iframe video in header', 'cocobasic-shortcode'),
        'id' => $prefix .'header_content',
        'type' => 'textarea'
    )
);

// The Callback
function cocobasic_show_post_custom_meta_box()
{
    global $post_custom_meta_fields, $post;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();
    // Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'. esc_attr(wp_create_nonce(basename(__FILE__))) .'" />';
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($post_custom_meta_fields as $field) {
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr><th><label for="'. esc_attr($field['id']) .'">'. esc_attr($field['label']) .'</label></th><td>';
        switch ($field['type']) {
            case 'text':
                if ($field['id'] == 'post_blog_featured_image') {
                    echo '<label for="upload_image">
                            <input id="'. esc_attr($field['id']) .'" class="image-url-input" type="text" size="36" name="'. esc_attr($field['id']) .'" value="'. esc_attr($meta) .'" />
                            <input id="upload_image_button" class="button" type="button" value="'. __('Upload Image', 'cocobasic-shortcode') .'" />
                            <br /><span class="image-upload-desc">'. esc_html($field['desc']) .'</span>
                            <span id="small-background-image-preview" class="has-background"></span>
                            </label>';
                } else {
                    echo '<input type="text" name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'" value="'. esc_attr($meta) .'" size="50" />
						<br /><span class="description">'. esc_html($field['desc']) .'</span>';
                }
                break;
            // select
            case 'select':
                echo '<select name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'. esc_attr($option['value']) .'">'. esc_html($option['label']) .'</option>';
                }
                echo '</select><br /><span class="description">'. esc_html($field['desc']) .'</span>';
                break;
            // textarea
            case 'textarea':
                echo '<textarea name="'. esc_attr($field['id']) .'" id="'. esc_attr($field['id']) .'" cols="60" rows="4">'. wp_kses($meta, $allowed_plugin_tags) .'</textarea>
					<br /><span class="description">'. esc_html($field['desc']) .'</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function cocobasic_save_post_custom_meta($post_id)
{
    global $post_custom_meta_fields;
    $allowed_plugin_tags = cocobasic_allowed_plugin_html();

    // verify nonce
    if (isset($_POST['custom_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($post_custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = null;

        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }

        if ($new && $new != $old) {
            $new = wp_kses($new, $allowed_plugin_tags);
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

/* function cocobasic_browserBodyClass($classes)
{
    global
        $is_lynx,
        $is_gecko,
        $is_IE,
        $is_opera,
        $is_NS4,
        $is_safari,
        $is_chrome,
        $is_iphone;

    $classes[] =
        switch():
            case ($is_lynx):

    if ($is_lynx) :
        $classes[] = 'lynx';
    elseif ($is_gecko)
        $classes[] = 'gecko';
    elseif ($is_opera)
        $classes[] = 'opera';
    elseif ($is_NS4)
        $classes[] = 'ns4';
    elseif ($is_safari)
        $classes[] = 'safari';
    elseif ($is_chrome)
        $classes[] = 'chrome';
    elseif ($is_IE) {
        $classes[] = 'ie';
        if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version)) {
            $classes[] = 'ie'. $browser_version[1];
        }
    } else {
        $classes[] = 'unknown';
    }

    if ($is_iphone) {
        $classes[] = 'iphone';
    if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {
        $classes[] = 'osx';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {
        $classes[] = 'linux';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {
        $classes[] = 'windows';
    }
    return $classes;
} */

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Shortcodes p-tag fix">
function cocobasic_the_content_filter($content) {
    // array of custom shortcodes requiring the fix
    $block = join("|", array("col", "service", "image_slider", "image_slide", "text_slider", "text_slide", "skills", "info", "med_text", "member", "social", "portfolio", "full_width"));
    // opening tag
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

    // closing tag
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);
    return $rep;
}

function cocobasic_allowed_plugin_html() {
    $allowed_tags = array(
        'a' => array(
            'class' => array(),
            'href' => array(),
            'rel' => array(),
            'title' => array(),
            'target' => array(),
            'data-rel' => array(),
            'data-id' => array(),
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
            'id' => array(),
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
