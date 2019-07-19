<?php

namespace App\Taxonomies;

use App\Taxonomies\Taxonomy;

class Audience extends Taxonomy
{
    public function registerTaxonomy()
    {
        $labels = [
            'name'              => _x('Audiences', 'taxonomy general name'),
            'singular_name'     => _x('Audience', 'taxonomy singular name'),
            'search_items'      => __('Search Audiences'),
            'all_items'         => __('All Audiences'),
            'parent_item'       => __('Parent Audience'),
            'parent_item_colon' => __('Parent Audience:'),
            'edit_item'         => __('Edit Audience'),
            'update_item'       => __('Update Audience'),
            'add_new_item'      => __('Add New Audience'),
            'new_item_name'     => __('New Audience'),
            'menu_name'         => __('Audiences'),
        ];

        $args = [
            'labels'       => $labels,
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_ui' => true,
            'rewrite' => [
                'slug' => 'open-source/plugins/by-audience'
            ],
            'show_in_rest' => true,
        ];

        register_taxonomy('audience', ['plugin'], $args);
    }
}
