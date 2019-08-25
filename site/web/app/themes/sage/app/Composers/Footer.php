<?php

namespace App\Composers;

use Roots\Acorn\View\Composer;
use Roots\Acorn\View\Composers\Concerns\AcfFields;
use Roots\Acorn\View\Composers\Concerns\Arrayable;
use Roots\Acorn\View\Composers\Concerns\Cacheable;

class Footer extends Composer
{
    use AcfFields, Arrayable;

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.footer',
    ];

    protected static $mods;
    protected static $options;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        self::$mods    = \get_theme_mods();
        self::$options = \wp_load_alloptions();
    }

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
     * Footer.
     *
     * @return object
     */
    public function footer()
    {
        return (object) [
            'image'     => self::$options['footer_image'],
            'copyright' => self::$mods['footer_copyright'],
            'social'    => self::$mods['footer_social'],
        ];
    }
}
