<?php

namespace App\Composers;

use App\Composers\ACF\FieldComposer;
use Illuminate\Support\Arr;

class Plugin extends FieldComposer
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
        $this->useGroups();

        return $data = ['plugin' => (object) $this->group('plugin')];
    }
}
