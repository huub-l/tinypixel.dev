<?php

namespace App\PostTypes;

use App\PostTypes\PostType;

class Site extends PostType
{
    /**
     * Template filename
     *
     * @var string
     */
    protected $name = 'Site';

    /**
     * Supported
     *
     * @var array
     */
    private $supports = ['title'];

    /**
     * Registers the posttype
     *
     * @param void
     * @return void
     */
    public function registerPostType()
    {
        register_post_type('Site', [
            'labels' => [
                'name'               => _x('Sites', 'post type general name', 'tinypixel'),
                'singular_name'      => _x('Site', 'post type singular name', 'tinypixel'),
                'menu_name'          => _x('Sites', 'admin menu name', 'tinypixel'),
                'name_admin_bar'     => _x('Site', 'add new on admin bar', 'tinypixel'),
                'add_new'            => _x('Add New', 'book', 'tinypixel'),
                'add_new_item'       => __('Add New Site', 'tinypixel'),
                'new_item'           => __('New Site', 'tinypixel'),
                'edit_item'          => __('Edit Site', 'tinypixel'),
                'view_item'          => __('View Site', 'tinypixel'),
                'all_items'          => __('All Sites', 'tinypixel'),
                'search_items'       => __('Search Sites', 'tinypixel'),
                'parent_item_colon'  => __('Parent Sites:', 'tinypixel'),
                'not_found'          => __('No Sites found.', 'tinypixel'),
                'not_found_in_trash' => __('No Sites found in Trash.', 'tinypixel')
            ],
            'description'      => __('Tiny Pixel sites', 'tinypixel'),
            'public'           => false,
            'public_queryable' => true,
            'show_ui'          => true,
            'show_in_menu'     => true,
            'query_var'        => true,
            'show_in_rest'     => true,
            'has_archive'      => false,
            'hierarchical'     => false,
            'menu_position'    => 20,
            'capability_type'  => 'post',
            'rewrite'          => [
                'slug' => 'open-source/sites',
                'with_front' => false,
            ],
            'supports' => $this->supports,
        ]);
    }
}
