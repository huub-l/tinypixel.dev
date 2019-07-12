<?php

namespace App\Composers;

use Roots\Acorn\View\Composer;

class Footer extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.footer',
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
        $mods = \get_theme_mods();

        return [
            'footer' => (object) [
                'image'     => \get_option('footer_image'),
                'copyright' => $mods['footer_copyright'],
                'social'    => $mods['footer_social'],
            ],
        ];
    }
}
