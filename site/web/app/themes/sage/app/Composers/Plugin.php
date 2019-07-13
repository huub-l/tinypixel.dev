<?php

namespace App\Composers;

use function \get_field_objects;

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
        'partials.plugin-meta',
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
        $this->id = \get_the_ID();

        $this->groupQuery = [$this->id, 'plugin'];

        return $data = ['plugin' => $this->getGroupFields(
            ...$this->groupQuery
        )];
    }

    public function getGroupFields($postId, $groupName)
    {
        if (!function_exists('get_field_objects')) {
            return;
        }

        $groups = (object) collect(\get_field_objects($postId));
        $fields = (object) $groups->get("{$groupName}")['value'];

        return $fields;
    }
}
