<?php

namespace App\Taxonomies;

use App\Taxonomies\Taxonomy;

class PluginType extends Taxonomy
{
    public function registerTaxonomy()
    {
        $labels = [
            'name'              => _x('Plugin Categories', 'taxonomy general name'),
            'singular_name'     => _x('Plugin Category', 'taxonomy singular name'),
            'search_items'      => __('Search Plugin Categories'),
            'all_items'         => __('All Plugin Categories'),
            'parent_item'       => __('Parent Plugin Category'),
            'parent_item_colon' => __('Parent Plugin Category:'),
            'edit_item'         => __('Edit Plugin Category'),
            'update_item'       => __('Update Plugin Category'),
            'add_new_item'      => __('Add New Plugin Category'),
            'new_item_name'     => __('New Plugin Category'),
            'menu_name'         => __('Plugin Categories'),
        ];

        $args = [
            'labels'       => $labels,
            'hierarchical' => true,
        ];

        register_taxonomy('Plugin_category', 'Plugin', $args);
    }
}
