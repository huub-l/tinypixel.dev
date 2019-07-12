<?php

namespace App\Composers;

use App\Navwalkers\Walker;
use Roots\Acorn\View\Composer;

class Header extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.header-*',
        'partials.*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @param  array $data
     * @param  \Illuminate\View\View $view
     * @return array
     */
    public function with($data, $view)
    {
        $mods = get_theme_mods();

        return $data = [
            'header'     => (object) ['logo' => get_option('header_logo')],
            'navigation' => $this->primaryNavigation(),
        ];
    }

    public function primaryNavigation()
    {
        if (has_nav_menu('primary_navigation')) {
            return wp_nav_menu([
                "container"       => "nav",
                "container_class" => "",
                "container_id"    => "header-main-menu",
                "echo"            => false,
                "fallback_cb"     => false,
                "menu_class"      => "main-menu sm sm-clean",
                "theme_location"  => "primary_navigation",
                "items_wrap"      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                "walker"          => new Walker(),
            ]);
        }

        return sprintf(
            'You must add a menu for this location (%1$s)',
            'navigation' // %1$s
        );
    }
}
