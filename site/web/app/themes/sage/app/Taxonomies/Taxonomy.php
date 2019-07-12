<?php

namespace App\Taxonomies;

class Taxonomy
{
    /**
     * Construct
     * @param void
     * @return void
     */
    public function __construct()
    {
        add_action('init', [$this, 'registerTaxonomy'], 0);
    }
}
