<?php

namespace App\PostTypes;

use App\PostTypes\PostType;

class Package extends PostType
{
    /**
     * Icon
     * @var string
     */
    private $icon = 'dashicons-archive';

    /**
     * Template filename
     * @var string
     */
    protected $name = 'Package';

    /**
     * Supported
     * @var array
     */
    private $supports = [
        'title',
        'thumbnail',
        'excerpt',
    ];

    private $taxonomies = [
        'language',
    ];

    /**
     * Registers the posttype
     *
     * @param void
     * @return void
     */
    public function registerPostType()
    {
        register_post_type('Package', [
            'labels' => [
                'name'               => _x('Packages', 'post type general name', 'tinypixel'),
                'singular_name'      => _x('Package', 'post type singular name', 'tinypixel'),
                'menu_name'          => _x('Packages', 'admin menu name', 'tinypixel'),
                'name_admin_bar'     => _x('Package', 'add new on admin bar', 'tinypixel'),
                'add_new'            => _x('Add New', 'book', 'tinypixel'),
                'add_new_item'       => __('Add New Package', 'tinypixel'),
                'new_item'           => __('New Package', 'tinypixel'),
                'edit_item'          => __('Edit Package', 'tinypixel'),
                'view_item'          => __('View Package', 'tinypixel'),
                'all_items'          => __('All Packages', 'tinypixel'),
                'search_items'       => __('Search Packages', 'tinypixel'),
                'parent_item_colon'  => __('Parent Packages:', 'tinypixel'),
                'not_found'          => __('No Packages found.', 'tinypixel'),
                'not_found_in_trash' => __('No Packages found in Trash.', 'tinypixel')
            ],
            'description'      => __('Software packages', 'tinypixel'),
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
                'slug'       => 'open-source/packages',
                'with_front' => true,
            ],
            'menu_icon'        => $this->icon,
            'supports'         => $this->supports,
            'taxonomies'       => $this->taxonomies,
        ]);
    }
}
