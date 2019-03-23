<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public function siteUrl()
    {
        return get_bloginfo('home_url');
    }

    public static function title()
    {
        if (is_home()) :
            if ($home = get_option('page_for_posts', true)) :
                return get_the_title($home);
            endif;
            return __('Latest Posts', 'sage');
        endif;

        if (is_archive()) :
            return get_the_archive_title();
        endif;

        if (is_search()) :
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        endif;

        if (is_404()) :
            return __('Not Found', 'sage');
        endif;

        return get_the_title();
    }

    public function data()
    {
        $mods = get_theme_mods();

        return (object) [
            'header' => (object) [
                'logo' => get_option('header_logo'),
            ],
            'footer' => (object) [
                'image'     => get_option('footer_image'),
                'copyright' => $mods['copyright'],
                'social'    => $mods['social'],
            ],
        ];
    }

    public function customMenu()
    {
        return has_nav_menu('custom_menu') ?
            wp_nav_menu([
                "container"       => "nav",
                "container_class" => "",
                "container_id"    => "header-main-menu",
                "echo"            => false,
                "fallback_cb"     => false,
                "menu_class"      => "main-menu sm sm-clean",
                "theme_location"  => "custom_menu",
                "items_wrap"      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                "walker"          => new cocobasic_header_menu(),
            ])
        : sprintf(
            'You must add a menu for this location (%1$s)',
            'custom_menu' // %1$s
        );
    }
}
