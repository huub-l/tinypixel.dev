<?php

namespace App\Composers;

use Roots\Acorn\View\Composer;
use Roots\Acorn\View\Composers\Concerns\AcfFields;
use Roots\Acorn\View\Composers\Concerns\Arrayable;
use Roots\Acorn\View\Composers\Concerns\Cacheable;

class Title extends Composer
{
    use AcfFields, Arrayable;

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive',
        'partials.page-header',
        'partials.content',
        'partials.content-*'
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
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive('audience')) {
            $audience = get_the_archive_title();

            return "Open-Source Plugins for {$audience}";
        }

        if (is_archive('language')) {
            $language = get_the_archive_title();

            return "Open-Source Packages for {$language}";
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }
}
