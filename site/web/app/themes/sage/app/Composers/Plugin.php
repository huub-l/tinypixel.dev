<?php

namespace App\Composers;

use \TinyPixel\FieldsComposer\FieldsComposer;
use Illuminate\Support\Arr;

class Plugin extends FieldsComposer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.header-plugin',
        'partials.content-single-plugin',
        'partials.plugin-meta',
    ];

    /**
     * Expiration time of cache in seconds
     *
     * @var int
     */
    public $cacheExpiry = 3600;

    /**
     * Data to be passed to view before rendering.
     *
     * @param  array $data
     * @param  \Illuminate\View\View $view
     * @return array
     */
    public function with($data, $view)
    {
        return $data = ['plugin' => $this->fields('plugin')];
    }
}
