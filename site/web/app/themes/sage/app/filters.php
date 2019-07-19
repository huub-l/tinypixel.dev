<?php

namespace App;

use function Roots\view;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && ! is_front_page()) {
        if (! in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Render WordPress searchform using Blade
 */
add_filter('get_search_form', function () {
    return view('forms.search');
});

/**
 * Remove archive prefix
 */
add_filter('get_the_archive_title', function ($title) {
    $parts = explode(': ', $title, 2);

    $title = !empty($parts[1]) ? [
        'a11y'    => esc_html($parts[0]),
        'display' =>  wp_kses($parts[1], ['span' => ['class' => []]]),
    ] : $title;

    return "<span class=\"screen-reader-text\">{$title['a11y']}: </span>{$title['display']}";
});


/**
 * Acorn globals
 */
add_filter('acorn/globals', function () {
    return true;
});
