<?php

namespace App\Taxonomies;

use App\Taxonomies\Taxonomy;

class Language extends Taxonomy
{
    public function registerTaxonomy()
    {
        $labels = [
            'name'              => _x('Language', 'taxonomy general name'),
            'singular_name'     => _x('Language', 'taxonomy singular name'),
            'search_items'      => __('Search Language'),
            'all_items'         => __('All Language'),
            'parent_item'       => __('Parent Language'),
            'parent_item_colon' => __('Parent Language:'),
            'edit_item'         => __('Edit Language'),
            'update_item'       => __('Update Language'),
            'add_new_item'      => __('Add New Language'),
            'new_item_name'     => __('New Language'),
            'menu_name'         => __('Languages'),
        ];

        $args = [
            'labels'       => $labels,
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_ui' => true,
            'rewrite' => [
                'slug' => 'open-source/packages/by-language'
            ],
            'show_in_rest' => true,
        ];

        register_taxonomy('language', ['packages'], $args);
    }
}
