<?php

namespace App\Composers;

use App\Navwalkers\Walker;
use Roots\Acorn\View\Composer;
use Roots\Acorn\View\Composers\Concerns\AcfFields;
use Roots\Acorn\View\Composers\Concerns\Arrayable;
use Roots\Acorn\View\Composers\Concerns\Cacheable;

class Header extends Composer
{
    use AcfFields, Arrayable;

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
     * Data to be passed to view before rendering
     *
     * @return array
     */
    protected function with()
    {
        return $this->toArray();
    }

    /**
     * Header
     *
     * @return object
     */
    public function header()
    {
        return (object) [
            'logo' => get_option('header_logo'),
        ];
    }

    /**
     * Navigation
     *
     * @return
     */
    public function navigation()
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
