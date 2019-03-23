<?php

// <editor-fold defaultstate="collapsed" desc="Setup theme">
if (!function_exists('cocobasic_theme_setup')) {

    function cocobasic_theme_setup() {

        global $content_width;
        if (!isset($content_width))
            $content_width = 1070;

        $lang_dir = get_template_directory() . '/languages';
        load_theme_textdomain('kapena-wp', $lang_dir);

        add_theme_support('align-wide');
        add_action('wp_enqueue_scripts', 'cocobasic_load_scripts_and_style');
        add_action('wp_ajax_infinite_scroll_index', 'cocobasic_infinitepaginateindex');
        add_action('wp_ajax_nopriv_infinite_scroll_index', 'cocobasic_infinitepaginateindex');

        add_theme_support('post-thumbnails', array('post'));
        add_action('widgets_init', 'cocobasic_widgets_init');
        add_theme_support('title-tag');
        add_filter('get_search_form', 'cocobasic_search_form');
        add_filter('excerpt_more', 'cocobasic_excerpt_more');
        add_filter('excerpt_length', 'cocobasic_excerpt_length');

        require get_parent_theme_file_path('/admin/custom-admin.php');

        if (function_exists('automatic-feed-links')) {
            add_theme_support('automatic-feed-links');
        }

        add_action('init', 'cocobasic_register_menu');

        add_editor_style('css/custom-editor-style.css');

        if (current_theme_supports('custom-header')) {
            $default_custom_header_settings = array(
                'default-image' => '',
                'random-default' => false,
                'width' => 0,
                'height' => 0,
                'flex-height' => false,
                'flex-width' => false,
                'default-text-color' => '',
                'header-text' => true,
                'uploads' => true,
                'wp-head-callback' => '',
                'admin-head-callback' => '',
                'admin-preview-callback' => '',
            );
            add_theme_support('custom-header', $default_custom_header_settings);
        }

        if (current_theme_supports('custom-background')) {
            $default_custom_background_settings = array(
                'default-color' => '',
                'default-image' => '',
                'wp-head-callback' => '_custom_background_cb',
                'admin-head-callback' => '',
                'admin-preview-callback' => ''
            );
            add_theme_support('custom-background', $default_custom_background_settings);
        }


        /**
         * Include the TGM_Plugin_Activation class.
         */
        require get_parent_theme_file_path('/admin/class-tgm-plugin-activation.php');
        add_action('tgmpa_register', 'cocobasic_register_required_plugins');
    }

}

add_action('after_setup_theme', 'cocobasic_theme_setup');

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Load Google Fonts">
if (!function_exists('cocobasic_google_fonts_url')) {

    function cocobasic_google_fonts_url() {
        $font_url = '';

        if ('off' !== _x('on', 'Google font: on or off', 'kapena-wp')) {
            $font_url = add_query_arg('family', urlencode('Work Sans:400,500,700,900|PT+Serif|Roboto:700'), "//fonts.googleapis.com/css");
        }
        return $font_url;
    }

}

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Load CSS and JS">
if (!function_exists('cocobasic_load_scripts_and_style')) {

    function cocobasic_load_scripts_and_style() {

        wp_enqueue_style('kapena-google-fonts', cocobasic_google_fonts_url(), array(), '1.0.0');


//Initialize once to optimize number of cals to get template directory url method
        $base_theme_url = get_template_directory_uri();

//register and load styles which is used on every pages       
        wp_enqueue_style('kapena-clear-style', $base_theme_url . '/css/clear.css');
        wp_enqueue_style('kapena-common-style', $base_theme_url . '/css/common.css');
        wp_enqueue_style('font-awesome', $base_theme_url . '/css/font-awesome.min.css');
        wp_enqueue_style('sm-cleen', $base_theme_url . '/css/sm-clean.css');
        wp_enqueue_style('kapena-main-theme-style', $base_theme_url . '/style.css');


//JavaScript

        wp_enqueue_script('html5shiv', $base_theme_url . '/js/html5shiv.js');
        wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
        wp_enqueue_script('respond', $base_theme_url . '/js/respond.min.js');
        wp_script_add_data('respond', 'conditional', 'lt IE 9');
        wp_enqueue_script('jquery-fitvids', $base_theme_url . '/js/jquery.fitvids.js', array('jquery'), false, true);
        wp_enqueue_script('imagesloaded', $base_theme_url . '/js/imagesloaded.pkgd.js', array('jquery'), false, true);
        wp_enqueue_script('jquery-smartmenus', $base_theme_url . '/js/jquery.smartmenus.min.js', array('jquery'), false, true);
        wp_enqueue_script('kapena-main', $base_theme_url . '/js/main.js', array('jquery'), false, true);

        if (is_singular()) {
            if (get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        }


        //Infinite Loading JS variables for index
        $count_posts_index = wp_count_posts('post');
        $published_posts_index = $count_posts_index->publish;
        $posts_per_page_index = get_option('posts_per_page');
        $num_pages_index = ceil($published_posts_index / $posts_per_page_index);

        wp_localize_script('kapena-main', 'ajax_var', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax-cocobasic-posts-load-more'),
            'posts_per_page_index' => $posts_per_page_index,
            'total_index' => $published_posts_index,
            'num_pages_index' => $num_pages_index
        ));


        $inlineCustomiserCss = new kapenaWPLiveCSS();
        wp_add_inline_style('kapena-main-theme-style', $inlineCustomiserCss->cocobasic_theme_customized_style());
    }

}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Infinite pagination index">
if (!function_exists('cocobasic_infinitepaginateindex')) {

    function cocobasic_infinitepaginateindex() {
        check_ajax_referer('ajax-cocobasic-posts-load-more', 'security');

        $loopFileIndex = sanitize_text_field($_POST['loop_file_index']);
        $pagedIndex = sanitize_text_field($_POST['page_no_index']);
        $posts_per_page = get_option('posts_per_page');

# Load the posts  
        query_posts(array('paged' => $pagedIndex, 'post_status' => 'publish', 'posts_per_page' => $posts_per_page));
        require get_parent_theme_file_path($loopFileIndex . '.php');

        exit;
    }

}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Custom Search form">
if (!function_exists('cocobasic_search_form')) {

    function cocobasic_search_form($form) {
        $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
	<label>		
	<input autocomplete="off" type="search" class="search-field" placeholder="' . esc_html__('Search', 'kapena-wp') . '" value="" name="s" title="' . esc_html__('Search for:', 'kapena-wp') . '" /> 
</label>    
</form>';

        return $form;
    }

}

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Register theme menu">
if (!function_exists('cocobasic_register_menu')) {

    function cocobasic_register_menu() {
        register_nav_menu('custom_menu', 'Main Menu');
    }

}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Custom menu Walker">
if (!class_exists('cocobasic_header_menu')) {


    class cocobasic_header_menu extends Walker_Nav_Menu {

        var $number = 1;

        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
            $atts['href'] = !empty($item->url) ? $item->url : '';

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ( 'href' === $attr ) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

}
//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="TGM Plugin">

if (!function_exists('cocobasic_register_required_plugins')) {

    function cocobasic_register_required_plugins() {
        $plugins = array(
            array(
                'name' => esc_html('CocoBasic - Kapena WP'), // The plugin name.
                'slug' => 'cocobasic-shortcode', // The plugin slug (typically the folder name).
                'source' => get_template_directory() . '/plugins/cocobasic-shortcode.zip', // The plugin source.
                'required' => true, // If false, the plugin is only 'recommended' instead of required.  
                'version' => '1.1',
            ),
            array(
                'name' => esc_html('Contact Form 7'),
                'slug' => 'contact-form-7',
                'required' => true // If false, the plugin is only 'recommended' instead of required.          
            )
        );

        $config = array(
            'id' => 'kapena-wp', // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '', // Default absolute path to bundled plugins.
            'menu' => 'tgmpa-install-plugins', // Menu slug.
            'has_notices' => true, // Show admin notices or not.
            'dismissable' => true, // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false, // Automatically activate plugins after installation or not.
            'message' => '', // Message to output right before the plugins table.           
        );

        tgmpa($plugins, $config);
    }

}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Sidebar and Widget">
if (!function_exists('cocobasic_widgets_init')) {

    function cocobasic_widgets_init() {
        register_sidebar(array(
            'name' => esc_html__('Footer Sidebar', 'kapena-wp'),
            'id' => 'footer-sidebar',
            'description' => esc_html__('Widgets in this area will be shown on all posts and pages.', 'kapena-wp'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h4 class="widgettitle">',
            'after_title' => '</h4>',
        ));
    }

}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Custom Excerpt"> 
if (!function_exists('cocobasic_excerpt_more')) {

    function cocobasic_excerpt_more($more) {
        return ' ...';
    }

}

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Custom Excerpt Lenght">
if (!function_exists('cocobasic_excerpt_length')) {

    function cocobasic_excerpt_length($length) {
        return 20;
    }

}
// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Archive title filter">
if (!function_exists('cocobasic_archive_title')) {

    function cocobasic_archive_title($title) {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            $title = get_the_author();
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } elseif (is_tax()) {
            $title = single_term_title('', false);
        }

        return $title;
    }

}

//</editor-fold>
// <editor-fold defaultstate="collapsed" desc="Allowed HTML Tags">
if (!function_exists('cocobasic_allowed_html')) {

    function cocobasic_allowed_html() {
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

}
//</editor-fold>
?>