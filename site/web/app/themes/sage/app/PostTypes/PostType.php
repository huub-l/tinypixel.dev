<?php

namespace App\PostTypes;

class PostType
{
    /**
     * Construct
     *
     * @param void
     * @return void
     */
    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
    }
}
