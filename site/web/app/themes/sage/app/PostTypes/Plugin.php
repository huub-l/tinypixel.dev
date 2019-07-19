<?php

namespace App\PostTypes;

use App\PostTypes\PostType;

class Plugin extends PostType
{
    /**
     * Icon
     *
     * @var string
     */
    private $icon = 'dashicons-admin-plugins';

    /**
     * Template filename
     *
     * @var string
     */
    protected $name = 'Plugin';

    /**
     * Supported
     *
     * @var array
     */
    private $supports = [
        'title',
        'editor',
        'thumbnail',
        'excerpt',
    ];

    private $taxonomies = [
        'audiences',
    ];

    /**
     * Registers the posttype
     *
     * @param void
     * @return void
     */
    public function registerPostType()
    {
        register_post_type('Plugin', [
            'labels' => [
                'name'               => _x('Plugins', 'post type general name', 'tinypixel'),
                'singular_name'      => _x('Plugin', 'post type singular name', 'tinypixel'),
                'menu_name'          => _x('Plugins', 'admin menu name', 'tinypixel'),
                'name_admin_bar'     => _x('Plugin', 'add new on admin bar', 'tinypixel'),
                'add_new'            => _x('Add New', 'book', 'tinypixel'),
                'add_new_item'       => __('Add New Plugin', 'tinypixel'),
                'new_item'           => __('New Plugin', 'tinypixel'),
                'edit_item'          => __('Edit Plugin', 'tinypixel'),
                'view_item'          => __('View Plugin', 'tinypixel'),
                'all_items'          => __('All Plugins', 'tinypixel'),
                'search_items'       => __('Search Plugins', 'tinypixel'),
                'parent_item_colon'  => __('Parent Plugins:', 'tinypixel'),
                'not_found'          => __('No Plugins found.', 'tinypixel'),
                'not_found_in_trash' => __('No Plugins found in Trash.', 'tinypixel')
            ],
            'description'      => __('Tiny Pixel developed WordPress plugins', 'tinypixel'),
            'public'           => true,
            'public_queryable' => true,
            'show_ui'          => true,
            'show_in_menu'     => true,
            'query_var'        => true,
            'show_in_rest'     => true,
            'has_archive'      => true,
            'hierarchical'     => false,
            'menu_position'    => 20,
            'capability_type'  => 'post',
            'rewrite'          => [
                'slug'       => 'open-source/plugins',
                'with_front' => false,
            ],
            'menu_icon'        => $this->icon,
            'supports'         => $this->supports,
            'taxonomies'       => $this->taxonomies,
        ]);
    }
}
