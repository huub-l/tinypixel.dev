<?php

namespace App\Composers;

use App\Navwalkers\Walker;
use Roots\Acorn\View\Composer;

class Plugin extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.single-plugin-*',
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
            'fields' => $this->getFields(),
        ];
    }

    public function getFields()
    {
        if (function_exists('get_fields')) {
            $this->fields = get_fields();
        }
    }
}
